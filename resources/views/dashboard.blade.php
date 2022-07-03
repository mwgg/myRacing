@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="card">
    <div class="card-body">
        <h4>{{ $member->name }}</h4>
        <div class="row">
            @foreach(Constants::CATEGORIES as $catId=>$catName)
                <div class="col">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title mb-1">
                                <span class="iracing-icons subtitle-icon">{!! Constants::CAT_ICONS[$catId] !!}</span> {{ $catName }}
                                <span class="ml-1 no-select license-badge badge {{Constants::LIC_CLASSES[$member->licenses[$catId]] }}">
                                    <span class="series-license">{{ Constants::LIC_SHORT[$member->licenses[$catId]] }} {{ $member->sr[$catId] }}</span>
                                </span>
                            </h6>
                            <div>iRating: <b>{{ $member->ir[$catId] }}</b></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <div class="calendar">
            @if(count($schedules)===0)
                <span>Nothing here, select what you are interested in on the <a href="{{ route('planner') }}">Planner</a> page</span>
            @endif
    <div class="calendar-logos-container">
            @foreach($schedules as $seriesId=>$s)
                <div class="calendar-series">
                    <div class="series-logo-large series-logo calendar-series-logo" title="{{ $schedules[$seriesId][0]->series_name }}">
                        <img src="/img/series/{{ $seriesId }}.png"/>
                    </div>
                </div>
            @endforeach
    </div>
    <div class="calendar-container inner-shadow">
            @foreach($schedules as $seriesId=>$s)
                <div class="calendar-series">
                    @foreach($schedules[$seriesId] as $schedule)
                        @if($schedule->race_week_num >= $schedule->current_week)
                            <div class="calendar-week {{ ($schedule->current_week === $schedule->race_week_num) ? 'calendar-current-week' : '' }}">
                                @include('layouts.track', [
                                    'schedule' => $schedule,
                                    'inactive' => true,
                                    'muteNonFavorite' => true,
                                    'ownership' => in_array($schedule->track_id, $ownedTracks)
                                ])
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
            <div class="mb-1"></div>
    </div>
        </div>
    </div>
</div>

@if(count($tracksToBuy)>0)
<div class="card mt-4 mb-4">
    <div class="card-body">
        <h4>{{ count($tracksToBuy) }} {{ (count($tracksToBuy)>1) ? 'tracks' : 'track' }} to be purchased:</h4>
        @foreach($tracksToBuy as $k=>$track)
            <a href="https://members.iracing.com/membersite/member/TrackDetail.do?trkid={{ $track->track_id }}" target="_blank">{{ $track->name }}</a>@if(isset($tracksToBuy[$k+1]))<span>, </span>@endif
        @endforeach
    </div>
</div>
@endif

@endsection