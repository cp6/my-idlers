@section("title", "Public viewable servers")
<x-app-layout>
    <x-slot name="header">
        {{ __('Servers') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                    <tr class="bg-gray-100 bg-">
                        @if(Session::get('show_server_value_hostname') === 1)
                            <th class="nowrap">Name</th>
                        @endif
                        <th class="text-center"><i class="fas fa-box" title="Virt"></i></th>
                        <th class="text-center">OS</th>
                        <th class="text-center"><i class="fas fa-microchip" title="CPU"></i></th>
                        <th class="text-center">Mhz</th>
                        <th class="text-center"><i class="fas fa-memory" title="ram"></i></th>
                        <th class="text-center"><i class="fas fa-compact-disc" title="disk"></i></th>
                        <th class="text-nowrap">Location</th>
                        <th class="text-nowrap">Provider</th>
                        <th class="text-nowrap">Price</th>
                        <th class="text-nowrap">Had since</th>
                        <th class="text-nowrap">GB5 S</th>
                        <th class="text-nowrap">GB5 M</th>
                        <th class="text-nowrap">4k</th>
                        <th class="text-nowrap">64k</th>
                        <th class="text-nowrap">512k</th>
                        <th class="text-nowrap">1m</th>
                        @if(Session::get('show_server_value_ip') === 1)
                            <th class="text-nowrap">IPv4</th>
                            <th class="text-nowrap">IPv6</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($servers[0]))
                        @foreach($servers as $s)
                            <tr>
                                @if(Session::get('show_server_value_hostname') === 1)
                                    <td class="nowrap">
                                        {{ $s->hostname }}
                                    </td>
                                @endif
                                <td class="text-center">
                                    {{ App\Models\Server::serviceServerType($s->server_type) }}
                                </td>
                                <td class="text-center">{!!App\Models\Server::osIntToIcon($s->os->id, $s->os->name)!!}</td>
                                <td class="text-center">{{$s->cpu}}</td>
                                <td class="text-nowrap">{{$s->yabs[0]->cpu_freq}}</td>
                                <td class="text-nowrap">
                                    @if(isset($s->yabs[0]->ram))
                                        {{ $s->yabs[0]->ram}}<small>{{ $s->yabs[0]->ram_type}}</small>
                                    @else
                                        {{$s->ram_as_mb}}<small>MB</small>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if($s->disk > 1000)
                                        {{ number_format(($s->disk / 1024),1) }}<small>TB</small>
                                    @else
                                        {{$s->disk}}<small>GB</small>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_location') === 1)
                                        {{ $s->location->name }}
                                    @endif</td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_provider') === 1)
                                        {{ $s->provider->name }}
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ $s->price->price }} {{$s->currency}} {{\App\Process::paymentTermIntToString($s->price->term)}}</td>
                                <td class="text-nowrap"> {{ $s->owned_since }}</td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->yabs[0]->gb5_single}}
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->yabs[0]->gb5_multi}}
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->yabs[0]->disk_speed->d_4k}}<small>{{$s->yabs[0]->disk_speed->d_4k_type}}</small>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->yabs[0]->disk_speed->d_64k}}<small>{{$s->yabs[0]->disk_speed->d_64k_type}}</small>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->yabs[0]->disk_speed->d_512k}}<small>{{$s->yabs[0]->disk_speed->d_512k_type}}</small>
                                    @endif</td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->yabs[0]->disk_speed->d_1m}}<small>{{$s->yabs[0]->disk_speed->d_1m_type}}</small>
                                    @endif</td>
                                @if(Session::get('show_server_value_ip') === 1)
                                    <td class="text-nowrap">
                                        @if($s->ips[0]->is_ipv4 === 1)
                                            {{ $s->ips[0]->address }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        @if($s->ips[0]->is_ipv6 === 1)
                                            {{ $s->ips[0]->address }}
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="px-4 py-2 border text-red-500" colspan="3">No servers found.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </x-card>
        <x-details-footer></x-details-footer>
    </div>
</x-app-layout>
