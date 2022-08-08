<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\IracingData\Updater;

class PopulateMember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:member';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate/update member information';

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
            $updater->populateMemberInfo();
        }
        catch(\iRacingPHP\Exceptions\iRacingException $e)
        {
            Log::channel('updater')->error('iRacing API error: ' . $e->getMessage());
        }
    }
}
