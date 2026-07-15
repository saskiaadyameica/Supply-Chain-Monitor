<div class="sidebar">

    <div class="logo">
        <h3>SCM</h3>
        <p>Supply Chain Monitor</p>
    </div>

    <ul class="menu">

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

        <li>
            <a href="#">
                <i class="bi bi-cloud-sun"></i>
                <span>Weather</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-currency-exchange"></i>
                <span>Currency</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-geo-alt"></i>
                <span>Ports</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-newspaper"></i>
                <span>News</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-bar-chart"></i>
                <span>Analytics</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-bookmark-heart"></i>
                <span>Favorites</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-person-circle"></i>
                <span>Admin</span>
            </a>
        </li>

    </ul>

</div>