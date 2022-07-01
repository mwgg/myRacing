<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IracingData\Constants;
use App\IracingData\Processors;
use App\Models\Schedule;
use App\Models\Series;
use App\Models\OwnedTrack;
use Illuminate\Support\Facades\DB;

class PlannerController extends Controller
{
    public function data()
    {

        $series = Series::orderBy('category_id')
            ->orderBy('name')
            ->leftJoin('schedules', 'series.series_id', '=', 'schedules.series_id')
            ->orderBy('race_week_num')
            ->get()
            ->groupBy(['category_id', 'series_id']);

        $ownedTracks = OwnedTrack::pluck('item_id')
            ->toArray();

        return view('planner', [
            'series' => $series,
            'ownedTracks' => $ownedTracks
        ]);
    }

    public function setFavorite(Request $request)
    {
        $schedule = Schedule::where('id', $request->schedule_id)->FirstOrFail();
        if($schedule)
        {
            $schedule->favorite = $request->favorite;
            $schedule->save();
            return response()->json('{success: true}');
        }
        
        return response()->json('{success: false}');
    }
}
