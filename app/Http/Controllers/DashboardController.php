<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IracingData\Constants;
use App\IracingData\Processors;
use App\Models\Member;
use App\Models\Series;
use App\Models\Schedule;
use App\Models\OwnedTrack;
use App\Models\Track;

class DashboardController extends Controller
{
    public function data()
    {
        $member = Member::firstOrFail();
        $member->decodeValues();

        $ownedTracks = OwnedTrack::pluck('item_id')
            ->toArray();

        $tracksToBuy = Schedule::distinct()
            ->select('schedules.track_id', 'tracks.name')
            ->groupBy('tracks.name')
            ->where('favorite', true)
            ->where('current_week', '<=', 'race_week_num')
            ->whereNotIn('schedules.track_id', $ownedTracks)
            ->leftJoin('tracks', 'schedules.track_id', '=', 'tracks.track_id')
            ->get();

        $favSeriesIds = Schedule::distinct()
            ->where('favorite', true)
            ->where('current_week', '<=', 'race_week_num')
            ->pluck('series_id')
            ->toArray();

        $schedules = Schedule::orderBy('race_week_num')
            ->wherein('schedules.series_id', $favSeriesIds)
            ->leftJoin('series_notes', 'schedules.series_id', '=', 'series_notes.series_id')
            ->join('series', 'schedules.series_id', '=', 'series.series_id')
            ->select('schedules.*', 'series_notes.note', 'series.name as series_name')
            ->get()
            ->groupBy('series_id');

        return view('dashboard', [
            'member' => $member,
            'schedules' => $schedules,
            'tracksToBuy' => $tracksToBuy,
            'ownedTracks' => $ownedTracks
        ]);
    }
}
