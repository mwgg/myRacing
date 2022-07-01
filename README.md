# myRacing
Self-hosted iRacing dashboard and season planner.

![Dashboard](https://github.com/mwgg/myRacing/raw/main/myracing_1.png)
![Planner](https://github.com/mwgg/myRacing/raw/main/myracing_2.png)

## What does it do?
This is a personal project, designed to replace a bunch of notes I take every season to keep track of the races I want to do on any particular week (and practice ahead of that week). With myRacing, you can browse through the current series and their schedules, mark the weeks/tracks that you wish to race, and have a quick and easy way to see your chosen series and tracks on any given week.

## Why self-hosted?
I would have loved to make this available as a public website, however there are a couple of reason for not doing so.

First of all, I would prefer not to deal with storing user data at all. I also wanted myRacing to keep maintain the list of purchased race tracks automatically and that requires authentication with the user's login and password. Storing other people's iRacing credentials is not an option at all.

## Running myRacing

I intend to package myRacing as a Docker container at some point, which would make running it very easy. For now, just some brief notes if you know what you're doing.

Install PHP and the following modules: `dom, bcmath, mbstring, curl, sqlite`

Rename `.env.example` to `.env`, configure the database and provide your iRacing credentials:
```
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/myracing.db
DB_FOREIGN_KEYS=true

IRACING_USERNAME="yourusername"
IRACING_PASSWORD="yourpassword"
```

Run the following commands in the project folder:
```
composer install
npm install
npm run prod
php artisan data:global
php artisan data:member
php artisan data:assets
```

Add the following line to cron:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
