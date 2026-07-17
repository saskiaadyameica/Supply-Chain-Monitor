@php
    use Illuminate\Support\Facades\Auth;
@endphp

<nav class="navbar-custom">

    <div>
        <h4 class="mb-0 fw-bold">Dashboard</h4>
    </div>

    <div class="d-flex align-items-center gap-3">

        <span class="fw-semibold">

            {{ Auth::check() ? Auth::user()->name : 'Admin' }}

        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="btn btn-outline-danger btn-sm">
                Logout
            </button>

        </form>

    </div>

</nav>