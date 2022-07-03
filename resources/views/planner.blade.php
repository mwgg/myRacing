@extends('layouts.app')
@section('title', 'Planner')

@section('content')


@foreach($series as $catId=>$catSeries)

<h5 class="{{ ($catId===1) ? '' : 'mt-4' }}"><span class="iracing-icons subtitle-icon">{!! Constants::CAT_ICONS[$catId] !!}</span> {{ Constants::CATEGORIES[$catId] }}</h5>
    @foreach($catSeries as $seriesId=>$s)
        <div class="card planner-card shadow" data-target="#planner-schedule-{{ $s[0]->series_id }}" data-series-id="{{ $s[0]->series_id }}">
            <div class="card-body position-relative">
                <div class="series-eligibility position-absolute no-select iracing-icons {{ ($s[0]->eligible) ? 'text-success' : 'text-danger' }}">&#xE03A;</div>
                <span class="no-select position-absolute license-badge badge badge-pill pill-cat-license {{Constants::LIC_CLASSES[$s[0]->license_group] }}">
                    <span class="category-icon iracing-icons">{!! Constants::CAT_ICONS[$s[0]->category_id] !!}</span>
                    <span class="series-license">{{ Constants::LIC_NAMES[$s[0]->license_group] }}</span>
                </span>
                <div class="series-logo series-logo-large position-absolute">
                    <img src="/img/series/{{ $s[0]->series_id }}.png"/>
                </div>
                <div class="planner-series-name position-absolute">{{ $s[0]->name }}</div>
                <div class="planner-favorite-message position-absolute" style="display:none;" data-series-id="{{ $s[0]->series_id }}">
                    <span class="planner-favorite-count" data-series-id="{{ $s[0]->series_id }}"></span>
                    <span> selected</span>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap planner-hidden" id="planner-schedule-{{ $s[0]->series_id }}" data-bs-parent="#planner-accordion">
            
                @foreach($s as $schedule)
                    @include('layouts.track', [
                        'schedule' => $schedule,
                        'inactive' => false,
                        'muteNonFavorite' => false,
                        'ownership' => in_array($schedule->track_id, $ownedTracks)
                    ])
                @endforeach
        </div>
    @endforeach
@endforeach

@endsection