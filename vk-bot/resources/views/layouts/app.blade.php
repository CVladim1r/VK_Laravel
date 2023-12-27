<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('dashboard') }}">VK APP PHP :)</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Панель</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('publics') ? 'active' : '' }}" href="{{ route('publics.index') }}">База пабликов</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contests') ? 'active' : '' }}" href="{{ route('contests.index') }}">Конкурсы</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Табы для переключения между Contests и Publics -->
    <!--    <ul class="nav nav-tabs" id="myTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('contests') ? 'active' : '' }}" id="contests-tab" data-toggle="tab" href="#contests" role="tab">Contests</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('publics') ? 'active' : '' }}" id="publics-tab" data-toggle="tab" href="#publics" role="tab">Publics</a>
            </li>
        </ul> -->
        <!-- Содержимое табов -->
        <div class="tab-content" id="myTabsContent">
            <div class="tab-pane fade {{ request()->is('contests') ? 'show active' : '' }}" id="contests" role="tabpanel">
                @yield('contests_content')
            </div>
            <div class="tab-pane fade {{ request()->is('publics') ? 'show active' : '' }}" id="publics" role="tabpanel">
                @yield('publics_content')
            </div>
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    @yield('scripts')
</body>
</html>
