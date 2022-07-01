<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>myRacing - @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/bootstrap-dark.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
  </head>
  <body>
    
    <nav class="shadow-lg sticky navbar navbar-expand-md navbar-dark bg-dark mb-4">
      <div class="container">
        <div class="ml-3">
          <img src="/img/logo.png"/>
        </div>
        <div class="navbar">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link {{ (Route::currentRouteName() == 'dashboard') ? 'active' : '' }}" aria-current="page" href="/">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ (Route::currentRouteName() == 'planner') ? 'active' : '' }}" href="/planner">Planner</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <main class="container">
      <div class="p-1 rounded">
        <!-- <h1>@yield('title')</h1> -->

        @yield('content')

      </div>
    </main>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ url('/js/myracing.js') }}"></script>
  </body>
</html>