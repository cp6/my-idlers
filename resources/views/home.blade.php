@section("title", "Home")
<x-app-layout>
    <div class="row mt-3">
        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tally-tab" data-bs-toggle="tab" data-bs-target="#tally"
                        type="button"
                        role="tab" aria-controls="tally" aria-selected="true">Tally
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="costings-tab"
                        data-bs-toggle="tab" data-bs-target="#costings" type="button" role="tab"
                        aria-controls="costings" aria-selected="false">Costings
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="averages-tab"
                        data-bs-toggle="tab" data-bs-target="#averages" type="button" role="tab"
                        aria-controls="averages" aria-selected="false">Averages
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tally" role="tabpanel" aria-labelledby="tally-tab">
                <div class="row mt-3">
                    <div class="col-6 col-lg-2 mb-3">
                        <x-service-tally-card tally="{{ $information['servers'] }}"
                                              route="{{route('servers.index')}}"
                                              service="Servers"></x-service-tally-card>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <x-service-tally-card tally="{{ $information['shared'] }}" route="{{route('shared.index')}}"
                                              service="Shared"></x-service-tally-card>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <x-service-tally-card tally="{{ $information['reseller'] }}"
                                              route="{{route('reseller.index')}}"
                                              service="Reseller"></x-service-tally-card>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <x-service-tally-card tally="{{ $information['domains'] }}"
                                              route="{{route('domains.index')}}"
                                              service="Domains"></x-service-tally-card>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <x-service-tally-card tally="{{ $information['misc'] }}" route="{{route('misc.index')}}"
                                              service="Misc"></x-service-tally-card>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <x-service-tally-card tally="{{ $information['dns'] }}" route="{{route('dns.index')}}"
                                              service="DNS"></x-service-tally-card>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="costings" role="tabpanel" aria-labelledby="costings-tab">
                <div class="row mt-3">
                    <div class="col-12 col-lg-2 mb-3">
                        <x-info-card value="{{$information['total_cost_weekly']}}" title="Weekly cost"
                                     append="{{$information['currency']}}"></x-info-card>
                    </div>
                    <div class="col-12 col-lg-2 mb-3">
                        <x-info-card value="{{$information['total_cost_monthly']}}" title="Monthly cost"
                                     append="{{$information['currency']}}"></x-info-card>
                    </div>
                    <div class="col-12 col-lg-2 mb-3">
                        <x-info-card value="{{$information['total_cost_yearly']}}" title="Yearly cost"
                                     append="{{$information['currency']}}"></x-info-card>
                    </div>
                    <div class="col-12 col-lg-2 mb-3">
                        <x-info-card value="{{$information['total_cost_2_yearly']}}" title="2 yearly cost"
                                     append="{{$information['currency']}}"></x-info-card>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="averages" role="tabpanel" aria-labelledby="averages-tab">
                <div class="row mt-3">
                    <div class="col-6 col-lg-2 mb-3">
                        <x-info-card value="{{$information['servers_summary']['cpu_sum']}}"
                                     title="CPU"></x-info-card>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <x-info-card
                            value="{{number_format($information['servers_summary']['ram_mb_sum'] / 1024, 2)}}"
                            title="RAM"
                            append="GB"></x-info-card>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        @if($information['servers_summary']['disk_gb_sum'] >= 1000)
                            <x-info-card
                                value="{{number_format($information['servers_summary']['disk_gb_sum'] / 1024,2)}}"
                                title="DISK" append="TB"></x-info-card>
                        @else
                            <x-info-card value="{{$information['servers_summary']['disk_gb_sum']}}" title="DISK"
                                         append="GB"></x-info-card>
                        @endif
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <x-info-card
                            value="{{number_format($information['servers_summary']['bandwidth_sum'] / 1024, 2)}}"
                            title="Bandwidth" append="TB"></x-info-card>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <x-info-card value="{{$information['servers_summary']['locations_sum']}}"
                                     title="Locations"></x-info-card>
                    </div>
                    <div class="col-6 col-lg-2 mb-3">
                        <x-info-card value="{{$information['servers_summary']['providers_sum']}}"
                                     title="Providers"></x-info-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        @if(Session::get('due_soon_amount') > 0)
            <h3 class="my-3">Due soon</h3>
            @if(!empty($information['due_soon']))
                <div class="card shadow mt-3 p-0">
                    <div class="table-responsive rounded">
                        <table class="table table-bordered mb-0">
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
            @endif
        @endif

        @if(Session::get('recently_added_amount') > 0)
            <h3 class="mt-4">Recently added</h3>
            @if(!empty($information['newest']))
                <div class="card shadow mt-3 p-0">
                    <div class="table-responsive rounded">
                        <table class="table table-bordered mb-0">
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
</x-app-layout>
