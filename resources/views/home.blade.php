@section("title", "Dashboard")
<x-app-layout>
    <div class="dashboard-container">
        <!-- Stats Overview -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('servers.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="stat-value">{{ $information['servers'] }}</div>
                        <div class="stat-label">Servers</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('shared.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="stat-value">{{ $information['shared'] }}</div>
                        <div class="stat-label">Shared</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('reseller.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="stat-value">{{ $information['reseller'] }}</div>
                        <div class="stat-label">Reseller</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('domains.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="stat-value">{{ $information['domains'] }}</div>
                        <div class="stat-label">Domains</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('misc.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="stat-value">{{ $information['misc'] }}</div>
                        <div class="stat-label">Misc</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('dns.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="stat-value">{{ $information['dns'] }}</div>
                        <div class="stat-label">DNS</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Costs & Resources Row -->
        <div class="row g-3 mb-4">
            <!-- Costs Card -->
            <div class="col-12 col-lg-6">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">Costs</h5>
                        <span class="badge bg-secondary">{{ $information['currency'] }}</span>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <div class="cost-item">
                                    <div class="cost-value">{{ $information['total_cost_weekly'] }}</div>
                                    <div class="cost-label">Weekly</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="cost-item">
                                    <div class="cost-value">{{ $information['total_cost_monthly'] }}</div>
                                    <div class="cost-label">Monthly</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="cost-item">
                                    <div class="cost-value">{{ $information['total_cost_yearly'] }}</div>
                                    <div class="cost-label">Yearly</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="cost-item">
                                    <div class="cost-value">{{ $information['total_cost_2_yearly'] }}</div>
                                    <div class="cost-label">2 Years</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resources Card -->
            <div class="col-12 col-lg-6">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">Server Resources</h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3">
                            <div class="col-4 col-md-2">
                                <div class="resource-item">
                                    <div class="resource-value">{{ $information['servers_summary']['cpu_sum'] }}</div>
                                    <div class="resource-label">CPU</div>
                                </div>
                            </div>
                            <div class="col-4 col-md-2">
                                <div class="resource-item">
                                    <div class="resource-value">{{ number_format($information['servers_summary']['ram_mb_sum'] / 1024, 1) }}</div>
                                    <div class="resource-label">RAM GB</div>
                                </div>
                            </div>
                            <div class="col-4 col-md-2">
                                <div class="resource-item">
                                    @if($information['servers_summary']['disk_gb_sum'] >= 1000)
                                        <div class="resource-value">{{ number_format($information['servers_summary']['disk_gb_sum'] / 1024, 1) }}</div>
                                        <div class="resource-label">Disk TB</div>
                                    @else
                                        <div class="resource-value">{{ $information['servers_summary']['disk_gb_sum'] }}</div>
                                        <div class="resource-label">Disk GB</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4 col-md-2">
                                <div class="resource-item">
                                    <div class="resource-value">{{ number_format($information['servers_summary']['bandwidth_sum'] / 1024, 1) }}</div>
                                    <div class="resource-label">BW TB</div>
                                </div>
                            </div>
                            <div class="col-4 col-md-2">
                                <div class="resource-item">
                                    <div class="resource-value">{{ $information['servers_summary']['locations_sum'] }}</div>
                                    <div class="resource-label">Locations</div>
                                </div>
                            </div>
                            <div class="col-4 col-md-2">
                                <div class="resource-item">
                                    <div class="resource-value">{{ $information['servers_summary']['providers_sum'] }}</div>
                                    <div class="resource-label">Providers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Due Soon Section -->
        @if(Session::get('due_soon_amount') > 0 && !empty($information['due_soon']))
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">Due Soon</h5>
                        <span class="badge bg-warning text-dark">{{ count($information['due_soon']) }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Due</th>
                                    <th>Price</th>
                                    <th class="text-center" style="width: 60px;">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($information['due_soon'] as $due_soon)
                                <tr>
                                    <td>
                                        @if($due_soon->service_type === 1)
                                            {{ $due_soon->hostname }}
                                        @elseif($due_soon->service_type === 2)
                                            {{ $due_soon->main_domain }}
                                        @elseif($due_soon->service_type === 3)
                                            {{ $due_soon->reseller }}
                                        @elseif($due_soon->service_type === 4)
                                            {{ $due_soon->domain }}.{{ $due_soon->extension }}
                                        @elseif($due_soon->service_type === 5)
                                            {{ $due_soon->name }}
                                        @elseif($due_soon->service_type === 6)
                                            {{ $due_soon->title }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
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
                                        </span>
                                    </td>
                                    <td>{{ Carbon\Carbon::parse($due_soon->next_due_date)->diffForHumans() }}</td>
                                    <td>{{ $due_soon->price }} {{ $due_soon->currency }} {{ \App\Process::paymentTermIntToString($due_soon->term) }}</td>
                                    <td class="text-center">
                                        @php
                                            $routes = [
                                                1 => 'servers.show',
                                                2 => 'shared.show',
                                                3 => 'reseller.show',
                                                4 => 'domains.show',
                                                5 => 'misc.show',
                                                6 => 'seedboxes.show'
                                            ];
                                        @endphp
                                        <a href="{{ route($routes[$due_soon->service_type], $due_soon->service_id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recently Added Section -->
        @if(Session::get('recently_added_amount') > 0 && !empty($information['newest']))
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">Recently Added</h5>
                        <span class="badge bg-success">{{ count($information['newest']) }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Added</th>
                                    <th>Price</th>
                                    <th class="text-center" style="width: 60px;">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($information['newest'] as $new)
                                <tr>
                                    <td>
                                        @if($new->service_type === 1)
                                            {{ $new->hostname }}
                                        @elseif($new->service_type === 2)
                                            {{ $new->main_domain }}
                                        @elseif($new->service_type === 3)
                                            {{ $new->reseller }}
                                        @elseif($new->service_type === 4)
                                            {{ $new->domain }}.{{ $new->extension }}
                                        @elseif($new->service_type === 5)
                                            {{ $new->name }}
                                        @elseif($new->service_type === 6)
                                            {{ $new->title }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
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
                                        </span>
                                    </td>
                                    <td>{{ Carbon\Carbon::parse($new->created_at)->diffForHumans() }}</td>
                                    <td>{{ $new->price }} {{ $new->currency }} {{ \App\Process::paymentTermIntToString($new->term) }}</td>
                                    <td class="text-center">
                                        @php
                                            $routes = [
                                                1 => 'servers.show',
                                                2 => 'shared.show',
                                                3 => 'reseller.show',
                                                4 => 'domains.show',
                                                5 => 'misc.show',
                                                6 => 'seedboxes.show'
                                            ];
                                        @endphp
                                        <a href="{{ route($routes[$new->service_type], $new->service_id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        @if(Session::get('timer_version_footer', 0) === 1)
        <div class="row">
            <div class="col-12">
                <p class="text-muted small text-end mb-4">
                    Page loaded in {{ $information['execution_time'] }}s &middot;
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} &middot;
                    PHP v{{ PHP_VERSION }} &middot;
                    Rates by <a href="https://www.exchangerate-api.com" class="text-muted">Exchange Rate API</a>
                </p>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
