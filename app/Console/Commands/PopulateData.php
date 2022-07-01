<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\IracingData\Updater;

class PopulateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:global';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate/update database with data from the iRacing API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $updater = new Updater();
        $updater->populateSeries();
        $updater->populateSchedules();
        $updater->populateTracks();
    }
}
