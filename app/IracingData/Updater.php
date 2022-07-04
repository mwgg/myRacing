<?php

namespace App\IracingData;

use Illuminate\Support\Facades\DB;
use iRacingPHP\iRacing;
use App\Models\Series;
use App\Models\Schedule;
use App\Models\SeriesAssets;
use App\Models\Member;
use App\Models\OwnedCar;
use App\Models\OwnedTrack;
use App\Models\Track;
use App\Models\TrackAssets;
use App\Models\SeriesSeason;

class Updater
{

    private iRacing $iracing;

    function __construct()
    {
        $this->iracing = new iRacing(env('IRACING_USERNAME'), env('IRACING_PASSWORD'));
    }

    public function populateSeries()
    {
        echo "Updating series...";

        $series = $this->iracing->series->get();

        foreach($series as $s)
        {
            $serie = Series::updateOrCreate(
                ['series_id' => $s->series_id],
                [
                    'series_id' => $s->series_id,
                    'category_id' => $s->category_id,
                    'eligible' => $s->eligible,
                    'name' => $s->series_name
                ]
            )->save();
        }
        echo "Done\r\n";
        Log::channel('updater')->debug('Series updated.');
    }

    public function populateSchedules()
    {
        echo "Updating schedules...";

        $seasons = $this->iracing->series->seasons();

        foreach($seasons as $s)
        {
            foreach($s->schedules as $week)
            {
                $schedule = Schedule::updateOrCreate(
                    [
                        'season_id' => $s->season_id,
                        'race_week_num' => $week->race_week_num
                    ],
                    [
                        'series_id' => $s->series_id,
                        'license_group' =>$s->license_group,
                        'season_id' => $s->season_id,
                        'season_year' => $s->season_year,
                        'season_quarter' => $s->season_quarter,
                        'race_week_num' => $week->race_week_num,
                        'track_id' => $week->track->track_id,
                        'track_name' => $week->track->track_name,
                        'config_name' => (isset($week->track->config_name)) ? $week->track->config_name : '',
                        'current_week' => $s->race_week
                    ]
                )->save();
            }
            $this->deleteOldSeasonsForSeries($s->series_id);            
        }
        echo "Done\r\n";
        Log::channel('updater')->debug('Schedules updated.');
    }

    public function populateSeriesAssets()
    {
        echo "Downloading series assets...";

        $assets = $this->iracing->series->assets();

        foreach($assets as $a)
        {
            $path = dirname(__FILE__, 3) . '/public/img/series/' . $a->series_id . '.png';
            $this->downloadImageIfDoesntExist('https://images-static.iracing.com/img/logos/series/' . $a->logo, $path);
        }
        echo "Done\r\n";
        Log::channel('updater')->debug('Series assets downloaded.');
    }

    public function populateMemberInfo()
    {
        echo "Updating member info...";

        $ir = $sr = $lic = [];
        $info = $this->iracing->member->info();
        foreach($info->licenses as $l)
        {
            $ir[$l->category_id] = $l->irating;
            $sr[$l->category_id] = $l->safety_rating;
            $lic[$l->category_id] = $l->group_id;
        }

        $member = Member::updateOrCreate(
            ['member_id' => $info->cust_id],
            [
                'member_id' => $info->cust_id,
                'name' => $info->first_name ." ". $info->last_name,
                'ir' => json_encode($ir),
                'sr' => json_encode($sr),
                'licenses' => json_encode($lic)
            ]
        );

        foreach($info->track_packages as $package)
        {
            foreach($package->content_ids as $id)
            {
                $track_id = OwnedTrack::firstOrCreate(['item_id' => $id]);
            }
        }
        echo "Done\r\n";
        Log::channel('updater')->debug('Member info updated.');
    }

    public function populateTracks()
    {
        echo "Updating tracks...";

        $tracks = $this->iracing->track->get();

        foreach($tracks as $t)
        {
            $track = Track::firstOrCreate(
                ['track_id' => $t->track_id],
                [
                    'category_id' => $t->track_id,
                    'free' => $t->free_with_subscription,
                    'location' => $t->location,
                    'package_id' => $t->package_id,
                    'track_id' => $t->track_id,
                    'price' => $t->price,
                    'sku' => $t->sku,
                    'name' => $t->track_name,
                    'config_name' => (isset($t->config_name)) ? $t->config_name : ''
                ]
            );
        }
        echo "Done\r\n";
        Log::channel('updater')->debug('Tracks updated.');
    }

    public function populateTracksAssets()
    {
        echo "Downloading track assets...";

        $assets = $this->iracing->track->assets();

        foreach($assets as $a)
        {
            $imagePath = dirname(__FILE__, 3) . '/public/img/tracks/images/' . $a->track_id . '.jpg';
            $logoPath = dirname(__FILE__, 3) . '/public/img/tracks/logos/' . $a->track_id . '.png';
            $mapPath = dirname(__FILE__, 3) . '/public/img/tracks/maps/' . $a->track_id . '.svg';

            $this->downloadImageIfDoesntExist('https://images-static.iracing.com' . $a->folder . '/' . $a->small_image, $imagePath);
            $this->downloadImageIfDoesntExist('https://images-static.iracing.com' . $a->logo, $logoPath);
            $this->downloadImageIfDoesntExist($a->track_map . $a->track_map_layers->active, $mapPath);
        }
        echo "Done\r\n";
        Log::channel('updater')->debug('Track assets downloaded.');
    }

    private function downloadImageIfDoesntExist($url, $path)
    {
        $exists = file_exists($path);
        $shouldUpdate = ($exists && time() - filemtime($path) > (86400 * 14) ); // If exists & modified > 14 days ago

        if(!$exists || $shouldUpdate)
        {
            file_put_contents($path, file_get_contents($url));
        }
    }

    private function deleteOldSeasonsForSeries(int $seriesId)
    {
        $latest = Schedule::select(DB::raw('max(season_year + season_quarter*0.1)'))
        ->where('series_id', $seriesId)
        ->first()
        ->toArray();

        $latestValues = explode('.', array_values($latest)[0]);

        $deleted = DB::table('schedules')
            ->where('season_year', '!=', $latestValues[0])
            ->where('season_quarter', '!=', $latestValues[1])
            ->delete();
    }

}
