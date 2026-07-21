<div class="sidebar">

    <div class="logo">
        <h3>SCM</h3>
        <p>Supply Chain Monitor</p>
    </div>

    <ul class="menu">

        {{-- ================= ADMIN ================= --}}
        @if(auth()->user()->role == 'admin')

            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Users</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.dataset.*') ? 'active' : '' }}">
                <a href="{{ route('admin.dataset.index') }}">
                    <i class="bi bi-geo-alt"></i>
                    <span>Port Dataset</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <a href="{{ route('admin.articles.index') }}">
                    <i class="bi bi-newspaper"></i>
                    <span>Analysis Articles</span>
                </a>
            </li>

        {{-- ================= USER ================= --}}
        @else

            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('countries.*') ? 'active' : '' }}">
                <a href="{{ route('countries.index') }}">
                    <i class="bi bi-globe2"></i>
                    <span>Countries</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('weather.*') ? 'active' : '' }}">
                <a href="{{ route('weather.index') }}">
                    <i class="bi bi-cloud-sun"></i>
                    <span>Weather</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('currency.*') ? 'active' : '' }}">
                <a href="{{ route('currency.index') }}">
                    <i class="bi bi-currency-exchange"></i>
                    <span>Currency</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('ports.*') ? 'active' : '' }}">
                <a href="{{ route('ports.index') }}">
                    <i class="bi bi-geo-alt"></i>
                    <span>Port</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('news.*') ? 'active' : '' }}">
                <a href="{{ route('news.index') }}">
                    <i class="bi bi-newspaper"></i>
                    <span>News</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('analysis.*') ? 'active' : '' }}">
                <a href="#">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Analysis</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('favorites.*') ? 'active' : '' }}">
                <a href="#">
                    <i class="bi bi-bookmark-heart"></i>
                    <span>Favorites</span>
                </a>
            </li>

        @endif

    </ul>

</div>