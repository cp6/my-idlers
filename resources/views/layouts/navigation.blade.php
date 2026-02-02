<nav class="navbar navbar-expand-md main-navbar" aria-label="Main navigation">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ route('/') }}">
            @if (config()->has('app.name')) {{ config('app.name') }} @else My Idlers @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if(Auth::check())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('servers.index') ? 'active' : '' }}" href="{{ route('servers.index') }}">Servers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shared.index') ? 'active' : '' }}" href="{{ route('shared.index') }}">Shared</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reseller.index') ? 'active' : '' }}" href="{{ route('reseller.index') }}">Reseller</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('domains.index') ? 'active' : '' }}" href="{{ route('domains.index') }}">Domains</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('labels.index') ? 'active' : '' }}" href="{{ route('labels.index') }}">Labels</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('misc.index') ? 'active' : '' }}" href="{{ route('misc.index') }}">Misc</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">More</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('dns.index') }}">DNS</a></li>
                        <li><a class="dropdown-item" href="{{ route('IPs.index') }}">IPs</a></li>
                        <li><a class="dropdown-item" href="{{ route('locations.index') }}">Locations</a></li>
                        <li><a class="dropdown-item" href="{{ route('os.index') }}">OS</a></li>
                        <li><a class="dropdown-item" href="{{ route('providers.index') }}">Providers</a></li>
                        <li><a class="dropdown-item" href="{{ route('seedboxes.index') }}">Seedboxes</a></li>
                        <li><a class="dropdown-item" href="{{ route('yabs.index') }}">YABS</a></li>
                        <li><a class="dropdown-item" href="{{ route('notes.index') }}">Notes</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('settings.index') }}">Settings</a></li>
                        <li><a class="dropdown-item" href="{{ route('account.index') }}">Account</a></li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="https://github.com/cp6/my-idlers">View on GitHub</a>
                </li>
                @endif
            </ul>
            @if(Auth::check())
            <form method="POST" action="{{ route('logout') }}" class="d-flex">
                @csrf
                <button type="submit" class="btn btn-link nav-link logout-link">Log Out</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-link nav-link">Log in</a>
            @endif
        </div>
    </div>
</nav>
