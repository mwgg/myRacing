# myRacing
Self-hosted iRacing dashboard and season planner.

This version of myRacing is no longer maintainted, it has been superceded by a [new version](https://github.com/mwgg/myRacing_v2), which features client-side data storage, does not require end-user iRacing credentials, and is hosted as a public website. All development efforts will be focused on the new version.

![Dashboard](https://github.com/mwgg/myRacing/raw/main/myracing_1.png)
![Planner](https://github.com/mwgg/myRacing/raw/main/myracing_2.png)

## What does it do?
This is a personal project, designed to replace a bunch of notes I take every season to keep track of the races I want to do on any particular week (and practice ahead of that week). With myRacing, you can browse through the current series and their schedules, mark the weeks/tracks that you wish to race, and have a quick and easy way to see your chosen series and tracks on any given week.

This is a work in progress.

## Why self-hosted?
I would have loved to make this available as a public website, however there are a couple of reason for not doing so.

First of all, I would prefer not to deal with storing user data at all. I also wanted myRacing to maintain the list of purchased race tracks automatically and that requires authentication with the user's login and password. Storing other people's iRacing credentials is not an option at all.

## Running myRacing

I intend to package myRacing as a Docker container at some point, which would make running it very easy. For now, just some brief notes on how to get going, assuming a clean Ubuntu 20.04 box.

Install PHP8, nginx:
```
sudo apt -y install software-properties-common dirmngr apt-transport-https lsb-release ca-certificates
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install nginx openssl php8.0 php8.0-common php8.0-fpm php8.0-dom php8.0-bcmath php8.0-mbstring php8.0-curl php8.0-sqlite3
```

Create an empty database file: `touch /path/to/myracing.db`
Create the following directories: `public/img/series`, `public/img/tracks/images`, `public/img/tracks/logos`, `public/img/tracks/maps`

Rename `.env.example` to `.env`, configure the database and provide your iRacing credentials:
```
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/myracing.db

IRACING_USERNAME="yourusername"
IRACING_PASSWORD="yourpassword"
```

Run the following commands in the project folder:
```
composer install
npm install
npm run prod
php artisan key:generate
php artisan migrate
php artisan data:global
php artisan data:member
php artisan data:assets
```

Add the following line to cron:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Configure nginx as needed by pointing it at the `public` folder, and you're good to go.

## Logging

myRacing logs iRacing API updates to the `logs/updater.log` file.

To change what is being logged, change the `LOG_LEVEL` variable in the `.env` file. Successful updates are logged as `debug` messages, updater exceptions as `error` messages.
