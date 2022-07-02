<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\IracingData\Updater;

class PopulateAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate series and track assets.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $updater = new Updater();
        $updater->populateSeriesAssets();
        $updater->populateTracksAssets();
    }
}
