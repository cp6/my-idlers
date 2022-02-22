@section('title') {{$server->hostname}} {{'server'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Server details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $server->hostname }}</h2>
                    <code>@foreach($labels as $label)
                            @if($loop->last)
                                {{$label->label}}
                            @else
                                {{$label->label}},
                            @endif
                        @endforeach</code>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $server->id }}</h6>
                    @if($server->active !== 1)
                        <h6 class="text-danger pe-lg-4">not active</h6>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Type</td>
                                <td>
                                    {{ $server->serviceServerType($server->server_type) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">OS</td>
                                <td>{{ $server_extras[0]->os_name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Location</td>
                                <td>{{$server_extras[0]->location}}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Provider</td>
                                <td>{{$server_extras[0]->provider}}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Price</td>
                                <td>{{ $server_extras[0]->price }} {{ $server_extras[0]->currency }}
                                    <small>{{\App\Process::paymentTermIntToString($server_extras[0]->term)}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Next due date</td>
                                <td>{{Carbon\Carbon::parse($server_extras[0]->next_due_date)->diffForHumans()}}
                                    ({{Carbon\Carbon::parse($server_extras[0]->next_due_date)->format('d/m/Y')}})
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">CPU</td>
                                <td>{{ $server_extras[0]->cpu }} @if($server_extras[0]->has_yabs)
                                        <small>@</small> {{ $server_extras[0]->cpu_freq }}
                                    @endif</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">RAM</td>
                                <td>{{ $server_extras[0]->ram }} {{ $server_extras[0]->ram_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Disk</td>
                                <td>{{ $server_extras[0]->disk }} {{ $server_extras[0]->disk_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Bandwidth</td>
                                <td>{{ $server_extras[0]->bandwidth }} GB</td>
                            </tr>
                            @foreach($ip_addresses as $ip)
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">@if($ip['is_ipv4'])
                                            IPv4
                                        @else
                                            IPv6
                                        @endif
                                    </td>
                                    <td><code>{{ $ip['address'] }}</code></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Was promo</td>
                                <td>{{ ($server_extras[0]->was_promo === 1) ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Owned since</td>
                                <td>
                                    @if(!is_null($server->owned_since))
                                        {{ date_format(new DateTime($server->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Inserted</td>
                                <td>
                                    @if(!is_null($server->created_at))
                                        {{ date_format(new DateTime($server->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($server->updated_at))
                                        {{ date_format(new DateTime($server->updated_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('servers.index') }}"
                       class="btn btn-success btn-sm mx-2">
                        Go back
                    </a>
                    <a href="{{ route('servers.edit', $server->id) }}"
                       class="btn btn-primary btn-sm mx-2">
                        Edit
                    </a>
                </div>
                <div class="col-12 col-lg-6">
                    @if($server_extras[0]->has_yabs)
                        <div class="table-responsive">
                            <table class="table table-borderless text-nowrap">
                                <tbody>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">GB5 Single/Multi</td>
                                    <td>
                                        {{$server_extras[0]->gb5_single}} / {{$server_extras[0]->gb5_multi}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">CPU</td>
                                    <td>{{$server_extras[0]->cpu_model}}</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">AES</td>
                                    <td>{{ ($server_extras[0]->aes === 1) ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">VM</td>
                                    <td>{{ ($server_extras[0]->vm === 1) ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">Disk 4k</td>
                                    <td>{{$server_extras[0]->d_4k}} <small>{{$server_extras[0]->d_4k_type}}</small></td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">Disk 64k</td>
                                    <td>{{$server_extras[0]->d_64k}} <small>{{$server_extras[0]->d_64k_type}}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">Disk 512k</td>
                                    <td>{{$server_extras[0]->d_512k}} <small>{{$server_extras[0]->d_512k_type}}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">Disk 1m</td>
                                    <td>{{$server_extras[0]->d_1m}} <small>{{$server_extras[0]->d_1m_type}}</small></td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold">Network speed (s/r)</td>
                                </tr>
                                @foreach($network_speeds as $ns)
                                    <tr>
                                        <td class="px-2 py-2 font-bold text-muted">{{$ns['location']}}</td>
                                        <td>{{$ns['send']}} <small>{{$ns['send_type']}}</small> {{$ns['receive']}}
                                            <small>{{$ns['receive_type']}}</small></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>Please <a href="{{ route('yabs.create') }}" class="text-decoration-none">add a YABs</a> to
                            see Geekbench, disk and network speeds</p>
                    @endif
                </div>
            </div>
        </x-card>
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>
                    Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}
                    )</small>
            </p>
        @endif
    </div>
</x-app-layout>
