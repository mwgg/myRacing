<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
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
        try
        {
            $updater = new Updater();
            $updater->populateSeriesAssets();
            $updater->populateTracksAssets();
        }
        catch(iRacingPHP\Exceptions\iRacingException $e)
        {
            Log::channel('updater')->error('iRacing exception: ' . $e->getMessage());
        }
    }
}
