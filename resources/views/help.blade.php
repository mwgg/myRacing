@extends('layouts.app')
@section('title', 'Help')

@section('content')

<h1>Help</h1>


<h4>Basic usage</h4>
<p>Look for the series you would like to race on the <a href="{{ route('planner') }}">Planner</a> page, click on it to expand the current season's schedule.
You will be presented with the full season schedule, with the past weeks grayed out.
Tracks you don't yet own will have a red band on the left side, and a shopping cart icon.
Clicking on the shopping cart will take you directly to the track page on the iRacing website, from where you can choose to buy the track.
Choose the weeks that interest you, and click on those tracks, which will highlight them in green.</p>
<p>Once you've chosen all of the tracks you'd like to race for all of the series that interest you, feel free to navigate to the <a href="{{ route('dashboard') }}">Dashboard</a> page.
At the top you will see your iRacing stats, and just below a list of all the series that you are interested in, with their season schedules starting with the current race week.
Whether you want to choose from one of the series to race on any given day, or practice for the next weeks, the <a href="{{ route('dashboard') }}">Dashboard</a> page will make it easy make a decision.</p>

<h4>Tips and tricks</h4>
<ul>
    <li>Note track ownership may not update instantly. Even though myRacing updates this data every 10 minutes, it may not be reflected in the API for longer than that.</li>
    <li>You can leave notes for any of the series on the <a href="{{ route('planner') }}">Planner</a> page, and then view them by hovering over the series logo on the <a href="{{ route('dashboard') }}">Dashboard</a>. Such notes may include SOF times, or anything you'd like.</li>
</ul>

@endsection