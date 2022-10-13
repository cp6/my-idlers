@section("title", "Home")
<x-app-layout>
    <div class="container">
        @if (Route::has('login'))
            @auth
                <div class="row mt-4">
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h3>{{ $information['servers'] }}</h3>
                                    <h5><a href="servers" class="text-decoration-none">Servers</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h3>{{ $information['shared'] }}</h3>
                                    <h5><a href="shared" class="text-decoration-none">Shared</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h3>{{ $information['reseller'] }}</h3>
                                    <h5><a href="reseller" class="text-decoration-none">Reseller</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h3>{{ $information['domains'] }}</h3>
                                    <h5><a href="domains" class="text-decoration-none">Domains</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h3>{{ $information['misc'] }}</h3>
                                    <h5><a href="misc" class="text-decoration-none">Misc</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h3>{{ $information['dns'] }}</h3>
                                    <h5><a href="dns" class="text-decoration-none">DNS</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>
                                        {{$information['total_cost_weekly']}}
                                        <small class="text-muted">{{$information['currency']}}</small>
                                    </h4>
                                    <p>Weekly cost</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>
                                        {{$information['total_cost_monthly']}}
                                        <small class="text-muted">{{$information['currency']}}</small>
                                    </h4>
                                    <p>Monthly cost</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>
                                        {{$information['total_cost_yearly']}}
                                        <small class="text-muted">{{$information['currency']}}</small>
                                    </h4>
                                    <p>Yearly cost</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>
                                        {{$information['total_cost_2_yearly']}}
                                        <small class="text-muted">{{$information['currency']}}</small>
                                    </h4>
                                    <p>2 yearly cost</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>{{$information['total_services']}}</h4>
                                    <p>Active services</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>{{$information['total_inactive']}}</h4>
                                    <p>Inactive services</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>{{$information['servers_summary']['cpu_sum']}}</h4>
                                    <p>CPU</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>{{number_format($information['servers_summary']['ram_mb_sum'] / 1024, 2)}}
                                        <small
                                            class="text-muted">GB</small></h4>
                                    <p>Ram</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>
                                        @if($information['servers_summary']['disk_gb_sum'] >= 1000)
                                            {{number_format($information['servers_summary']['disk_gb_sum'] / 1024,2)}}
                                            <small
                                                class="text-muted">TB</small>
                                        @else
                                            {{$information['servers_summary']['disk_gb_sum']}} <small
                                                class="text-muted">GB</small>
                                        @endif
                                    </h4>
                                    <p>Disk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>{{number_format($information['servers_summary']['bandwidth_sum'] / 1024,2)}}
                                        <small
                                            class="text-muted">TB</small></h4>
                                    <p>Bandwidth</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>{{$information['servers_summary']['locations_sum']}}</h4>
                                    <p>Locations</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <div class="card">
                            <div class="card-body text-center shadow">
                                <div class="row">
                                    <h4>{{$information['servers_summary']['providers_sum']}}</h4>
                                    <p>Providers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(Session::get('due_soon_amount') > 0)
                    <h3 class="my-3">Due soon</h3>
                    @if(!empty($information['due_soon']))
                        <div class="card shadow mt-3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="text-nowrap">Name</th>
                                            <th class="text-nowrap">Type</th>
                                            <th class="text-nowrap">Due</th>
                                            <th class="text-nowrap">Price</th>
                                            <th class="text-nowrap"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($information['due_soon'] as $due_soon)
                                            <tr>
                                                <td class="text-nowrap">
                                                    @if($due_soon->service_type === 1)
                                                        {{$due_soon->hostname}}
                                                    @elseif($due_soon->service_type === 2)
                                                        {{$due_soon->main_domain}}
                                                    @elseif($due_soon->service_type === 3)
                                                        {{$due_soon->reseller}}
                                                    @elseif($due_soon->service_type === 4)
                                                        {{$due_soon->domain}}.{{$due_soon->extension}}
                                                    @elseif($due_soon->service_type === 5)
                                                        {{$due_soon->name}}
                                                    @elseif($due_soon->service_type === 6)
                                                        {{$due_soon->title}}
                                                    @endif
                                                </td>
                                                <td class="text-nowrap">
                                                    @if($due_soon->service_type === 1)
                                                        VPS
                                                    @elseif($due_soon->service_type === 2)
                                                        Shared
                                                    @elseif($due_soon->service_type === 3)
                                                        Reseller
                                                    @elseif($due_soon->service_type === 4)
                                                        Domain
                                                    @elseif($due_soon->service_type === 5)
                                                        Misc
                                                    @elseif($due_soon->service_type === 6)
                                                        Seedbox
                                                    @endif
                                                </td>
                                                <td class="text-nowrap">
                                                    {{Carbon\Carbon::parse($due_soon->next_due_date)->diffForHumans()}}</td>
                                                <td class="text-nowrap">{{$due_soon->price}} {{$due_soon->currency}} {{\App\Process::paymentTermIntToString($due_soon->term)}}</td>
                                                <td class="text-nowrap text-center">
                                                    @if($due_soon->service_type === 1)
                                                        <a href="{{ route('servers.show', $due_soon->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @elseif($due_soon->service_type === 2)
                                                        <a href="{{ route('shared.show', $due_soon->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @elseif($due_soon->service_type === 3)
                                                        <a href="{{ route('reseller.show', $due_soon->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @elseif($due_soon->service_type === 4)
                                                        <a href="{{ route('domains.show', $due_soon->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @elseif($due_soon->service_type === 5)
                                                        <a href="{{ route('misc.show', $due_soon->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @elseif($due_soon->service_type === 6)
                                                        <a href="{{ route('seedboxes.show', $due_soon->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                @if(Session::get('recently_added_amount') > 0)
                    <h3 class="mt-4">Recently added</h3>
                    @if(!empty($information['newest']))
                        <div class="card shadow mt-3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="text-nowrap">Name</th>
                                            <th class="text-nowrap">Type</th>
                                            <th class="text-nowrap">Added</th>
                                            <th class="text-nowrap">Price</th>
                                            <th class="text-nowrap"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($information['newest'] as $new)
                                            <tr>
                                                <td class="text-nowrap">
                                                    @if($new->service_type === 1)
                                                        {{$new->hostname}}
                                                    @elseif($new->service_type === 2)
                                                        {{$new->main_domain}}
                                                    @elseif($new->service_type === 3)
                                                        {{$new->reseller}}
                                                    @elseif($new->service_type === 4)
                                                        {{$new->domain}}.{{$new->extension}}
                                                    @elseif($new->service_type === 5)
                                                        {{$new->name}}
                                                    @elseif($new->service_type === 6)
                                                        {{$new->title}}
                                                    @endif
                                                </td>
                                                <td class="text-nowrap">
                                                    @if($new->service_type === 1)
                                                        VPS
                                                    @elseif($new->service_type === 2)
                                                        Shared
                                                    @elseif($new->service_type === 3)
                                                        Reseller
                                                    @elseif($new->service_type === 4)
                                                        Domain
                                                    @elseif($new->service_type === 5)
                                                        Misc
                                                    @elseif($new->service_type === 6)
                                                        Seedbox
                                                    @endif
                                                </td>
                                                <td class="text-nowrap">{{Carbon\Carbon::parse($new->created_at)->diffForHumans()}}</td>
                                                <td class="text-nowrap">{{$new->price}} {{$new->currency}} {{\App\Process::paymentTermIntToString($new->term)}}</td>
                                                <td class="text-nowrap text-center">
                                                    @if($new->service_type === 1)
                                                        <a href="{{ route('servers.show', $new->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @elseif($new->service_type === 2)
                                                        <a href="{{ route('shared.show', $new->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @elseif($new->service_type === 3)
                                                        <a href="{{ route('reseller.show', $new->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @elseif($new->service_type === 4)
                                                        <a href="{{ route('domains.show', $new->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @elseif($new->service_type === 5)
                                                        <a href="{{ route('misc.show', $new->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @elseif($new->service_type === 6)
                                                        <a href="{{ route('seedboxes.show', $new->service_id) }}"
                                                           class="text-body mx-1"><i class="fas fa-eye"
                                                                                     title="view"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
                    <p class="text-muted mt-4 text-end"><small>Page took {{$information['execution_time']}} seconds,
                            Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}),
                            Rates By <a href="https://www.exchangerate-api.com">Exchange Rate API</a>
                        </small>
                    </p>
                @endif
    </div>

    @else
        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
            @endif
            @endauth
            </div>
        @endif

</x-app-layout>
