<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm" aria-label="Eleventh navbar example">
    <div class="container">
        <a class="navbar-brand" href="{{route('/')}}">My Idlers</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample09"
                aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample09">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if(Auth::check())
                <x-nav-link :href="route('servers.index')" :active="request()->routeIs('servers.index')">
                    {{ __('Servers') }}
                </x-nav-link>
                <x-nav-link :href="route('shared.index')" :active="request()->routeIs('shared.index')">
                    {{ __('Shared') }}
                </x-nav-link>
                <x-nav-link :href="route('reseller.index')" :active="request()->routeIs('reseller.index')">
                    {{ __('Reseller') }}
                </x-nav-link>
                <x-nav-link :href="route('domains.index')" :active="request()->routeIs('domains.index')">
                    {{ __('Domains') }}
                </x-nav-link>
                <x-nav-link :href="route('labels.index')" :active="request()->routeIs('labels.index')">
                    {{ __('Labels') }}
                </x-nav-link>
                <x-nav-link :href="route('misc.index')" :active="request()->routeIs('misc.index')">
                    {{ __('Misc') }}
                </x-nav-link>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown09" data-bs-toggle="dropdown"
                       aria-expanded="false">More</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown09">
                        <li><a class="dropdown-item" href="{{route('dns.index')}}">DNS</a></li>
                        <li><a class="dropdown-item" href="{{route('IPs.index')}}">IPs</a></li>
                        <li><a class="dropdown-item" href="{{route('locations.index')}}">Locations</a></li>
                        <li><a class="dropdown-item" href="{{route('os.index')}}">OS</a></li>
                        <li><a class="dropdown-item" href="{{route('providers.index')}}">Providers</a></li>
                        <li><a class="dropdown-item" href="{{route('yabs.index')}}">YABs</a></li>
                        <li><a class="dropdown-item" href="{{route('settings.index')}}">Settings</a></li>
                        <li><a class="dropdown-item" href="{{route('account.index')}}">Account</a></li>
                    </ul>
                </li>
                @else
                    <x-nav-link href="https://github.com/cp6/my-idlers" :active="false">
                        {{ __('View My idlers on Github') }}
                    </x-nav-link>
                @endif
            </ul>
            @if(Auth::check())
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            @else
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Log in') }}
                </x-responsive-nav-link>
            @endif
        </div>
    </div>
</nav>
