<div class="track-container {{ ($schedule->race_week_num < $schedule->current_week) ? 'track-past-week' : 'shadow' }}
    {{ ($inactive) ? 'track-container-inactive' : '' }}
    {{ ($muteNonFavorite && !$schedule->favorite) ? 'track-past-week' : '' }}
    {{ ($schedule->favorite && $schedule->race_week_num == $schedule->current_week) ? 'track-favorite' : '' }}"
     style="background: linear-gradient( rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7) ), url('/img/tracks/images/{{ $schedule->track_id }}.jpg')"
     data-schedule-id="{{ $schedule->id }}"
     data-series-id="{{ $schedule->series_id }}"
     data-favorite="{{ $schedule->favorite }}">
    <span class="track-name"><b>{{ $schedule->track_name }}</b> {{ $schedule->config_name }}</span>
    <div class="track-week track-ownership no-select {{ ($ownership) ? 'track-ownership-green' : 'track-ownership-red' }}">{{ $schedule->race_week_num + 1 }}</div>
    <div class="track-logo" style="background: url('/img/tracks/logos/{{ $schedule->track_id }}.png') no-repeat;"></div>
    <div class="track-map" style="background: url('/img/tracks/maps/{{ $schedule->track_id }}.svg') no-repeat;"></div>
    @if(!$ownership)
        <div class="track-buy iracing-icons">
            <a href="https://members.iracing.com/membersite/member/TrackDetail.do?trkid={{ $schedule->track_id }}" target="_blank">&#xE030;</a>
        </div>
    @endif
</div>