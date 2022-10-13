@section("title", "{$reseller->main_domain} reseller hosting")
<x-app-layout>
    <x-slot name="header">
        {{ __('Reseller hosting details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $reseller->main_domain }}</h2>
                    @foreach($reseller->labels as $label)
                        <span class="badge bg-primary mx-1">{{$label->label->label}}</span>
                    @endforeach
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $reseller->id }}</h6>
                    @if($reseller->active !== 1)
                        <h6 class="text-danger pe-lg-4">not active</h6>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="'col-12 col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Type</td>
                                <td>{{ $reseller->reseller_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Main domain</td>
                                <td><a href="https://{{ $reseller->main_domain }}"
                                       class="text-decoration-none">{{ $reseller->main_domain }}</a></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Location</td>
                                <td>{{ $reseller->location->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Provider</td>
                                <td>{{ $reseller->provider->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Price</td>
                                <td>{{ $reseller->price->price }} {{ $reseller->price->currency }}
                                    <small>{{\App\Process::paymentTermIntToString($reseller->price->term)}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Has dedicated IP?</td>
                                <td>
                                    @if(isset($reseller->ips[0]->address))
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">IP</td>
                                <td><code>@if(isset($reseller->ips[0]->address))
                                            {{$reseller->ips[0]->address}}
                                        @endif
                                    </code></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Owned since</td>
                                <td>
                                    @if(!is_null($reseller->owned_since))
                                        {{ date_format(new DateTime($reseller->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Next due date</td>
                                <td>{{Carbon\Carbon::parse($reseller->price->next_due_date)->diffForHumans()}}
                                    ({{Carbon\Carbon::parse($reseller->price->next_due_date)->format('d/m/Y')}})
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Inserted</td>
                                <td>
                                    @if(!is_null($reseller->created_at))
                                        {{ date_format(new DateTime($reseller->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($reseller->updated_at))
                                        {{ date_format(new DateTime($reseller->updated_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="'col-12 col-lg-6">
                    <table class="table table-borderless">
                        <tbody>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Disk GB</td>
                            <td>{{$reseller->disk_as_gb}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Accounts</td>
                            <td>{{$reseller->accounts}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Domains Limit</td>
                            <td>{{$reseller->domains_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Subdomains Limit</td>
                            <td>{{$reseller->subdomains_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Bandwidth GB</td>
                            <td>{{$reseller->bandwidth}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Email Limit</td>
                            <td>{{$reseller->email_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">DB Limit</td>
                            <td>{{$reseller->db_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">FTP Limit</td>
                            <td>{{$reseller->ftp_limit}}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <x-back-btn>
                <x-slot name="route">{{ route('reseller.index') }}</x-slot>
            </x-back-btn>
            <x-edit-btn>
                <x-slot name="route">{{ route('reseller.edit', $reseller->id) }}</x-slot>
            </x-edit-btn>
        </x-card>
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>
                    Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}
                    )</small>
            </p>
        @endif
    </div>
</x-app-layout>
