@section('title')
    {{$server_data->hostname}} {{'server'}}
@endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Server details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $server_data->hostname }}</h2>
                    @foreach($server_data->labels as $label)
                        <span class="badge bg-primary mx-1">{{$label->label->label}}</span>
                    @endforeach
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $server_data->id }}</h6>
                    @if($server_data->active !== 1)
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
                                    {{ $server_data->serviceServerType($server_data->server_type) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">OS</td>
                                <td>{{ $server_data->os->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Location</td>
                                <td>{{$server_data->location->name}}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Provider</td>
                                <td>{{$server_data->provider->name}}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Price</td>
                                <td>{{ $server_data->price->price }} {{ $server_data->price->currency }}
                                    <small>{{\App\Process::paymentTermIntToString($server_data->price->term)}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Next due date</td>
                                <td>{{Carbon\Carbon::parse($server_data->price->next_due_date)->diffForHumans()}}
                                    ({{Carbon\Carbon::parse($server_data->price->next_due_date)->format('d/m/Y')}})
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">CPU</td>
                                <td>
                                    {{ $server_data->cpu }} @if($server_data->has_yabs)
                                        <small>@</small> {{ $server_data->yabs[0]->cpu_freq }} Mhz
                                    @endif</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">RAM</td>
                                <td>
                                    @if(isset($server_data->yabs[0]->ram))
                                        {{ $server_data->yabs[0]->ram }} {{ $server_data->yabs[0]->ram_type }}
                                    @else
                                        {{ $server_data->ram }} {{ $server_data->ram_type }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Disk</td>
                                <td>
                                    @if(isset($server_data->yabs[0]->disk))
                                        {{ $server_data->yabs[0]->disk }} {{ $server_data->yabs[0]->disk_type }}
                                    @else
                                        {{ $server_data->disk }} {{ $server_data->disk_type }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Bandwidth</td>
                                <td>{{ $server_data->bandwidth }} GB</td>
                            </tr>
                            @foreach($server_data->ips as $ip)
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
                                <td>{{ ($server_data->was_promo === 1) ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Owned since</td>
                                <td>
                                    @if(!is_null($server_data->owned_since))
                                        {{ date_format(new DateTime($server_data->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Inserted</td>
                                <td>
                                    @if(!is_null($server_data->created_at))
                                        {{ date_format(new DateTime($server_data->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($server_data->updated_at))
                                        {{ date_format(new DateTime($server_data->updated_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <x-back-btn>
                        <x-slot name="route">{{ route('servers.index') }}</x-slot>
                    </x-back-btn>
                    <x-edit-btn>
                        <x-slot name="route">{{ route('servers.edit', $server_data->id) }}</x-slot>
                    </x-edit-btn>
                </div>
                <div class="col-12 col-lg-6">
                    @if($server_data->has_yabs)
                        <div class="table-responsive">
                            <table class="table table-borderless text-nowrap">
                                <tbody>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">GB5 Single/Multi</td>
                                    <td>
                                        {{$server_data->yabs[0]->gb5_single}} / {{$server_data->yabs[0]->gb5_multi}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">CPU</td>
                                    <td>{{$server_data->yabs[0]->cpu_model}}</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">AES</td>
                                    <td>{{ ($server_data->yabs[0]->aes === 1) ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">VM</td>
                                    <td>{{ ($server_data->yabs[0]->vm === 1) ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">Disk 4k</td>
                                    <td>{{$server_data->yabs[0]->disk_speed->d_4k}}
                                        <small>{{$server_data->yabs[0]->disk_speed->d_4k_type}}</small></td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">Disk 64k</td>
                                    <td>{{$server_data->yabs[0]->disk_speed->d_64k}}
                                        <small>{{$server_data->yabs[0]->disk_speed->d_64k_type}}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">Disk 512k</td>
                                    <td>{{$server_data->yabs[0]->disk_speed->d_512k}}
                                        <small>{{$server_data->yabs[0]->disk_speed->d_512k_type}}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold text-muted">Disk 1m</td>
                                    <td>{{$server_data->yabs[0]->disk_speed->d_1m}}
                                        <small>{{$server_data->yabs[0]->disk_speed->d_1m_type}}</small></td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 font-bold">Network speed (s/r)</td>
                                </tr>
                                @foreach($server_data->yabs[0]->network_speed as $ns)
                                    <tr>
                                        <td class="px-2 py-2 font-bold text-muted">{{$ns->location}}</td>
                                        <td>{{$ns->send}} <small>{{$ns->send_type}}</small> {{$ns->receive}}
                                            <small>{{$ns->receive_type}}</small></td>
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
