@section('title') {{'Public viewable servers'}} @endsection
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
                        <th>Name</th>
                        <th class="text-center"><i class="fas fa-box" title="Virt"></i></th>
                        <th class="text-center">OS</th>
                        <th class="text-center"><i class="fas fa-microchip" title="CPU"></i></th>
                        <th class="text-center">Ghz</th>
                        <th class="text-center"><i class="fas fa-memory" title="ram"></i></th>
                        <th class="text-center"><i class="fas fa-compact-disc" title="disk"></i></th>
                        <th class="text-nowrap">Location</th>
                        <th class="text-nowrap">Provider</th>
                        <th class="text-nowrap">Price</th>
                        <th class="text-nowrap">GB5 S</th>
                        <th class="text-nowrap">GB5 M</th>
                        <th class="text-nowrap">4k</th>
                        <th class="text-nowrap">64k</th>
                        <th class="text-nowrap">512k</th>
                        <th class="text-nowrap">1m</th>
                        <th class="text-nowrap">Had since</th>
                        <th class="text-nowrap">IPv4</th>
                        <th class="text-nowrap">IPv6</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($servers))
                        @foreach($servers as $s)
                            <tr>
                                <td>
                                @if(Session::has('show_server_value_hostname') && Session::get('show_server_value_hostname') === '1')
                                        {{ $s->hostname }}
                                @endif
                                </td>
                                <td class="text-center">
                                    {{ App\Models\Server::serviceServerType($s->server_type) }}
                                </td>
                                <td class="text-center">{!!App\Models\Server::osIntToIcon($s->os_id, $s->os_name)!!}</td>
                                <td class="text-center">{{$s->cpu_cores}}</td>
                                <td class="text-center">{{$s->cpu_freq}}</td>
                                <td class="text-center">
                                    @if($s->ram_as_mb > 1024)
                                        {{ number_format(($s->ram_as_mb / 1000),0) }}<small>GB</small>
                                    @else
                                        {{$s->ram_as_mb}}<small>MB</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($s->disk > 1000)
                                        {{ number_format(($s->disk / 1000),1) }}<small>TB</small>
                                    @else
                                        {{$s->disk}}<small>GB</small>
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ $s->location }}</td>
                                <td class="text-nowrap">{{ $s->provider_name }}</td>
                                <td class="text-nowrap">{{ $s->price }} {{$s->currency}} {{\App\Process::paymentTermIntToString($s->term)}}</td>
                                <td class="text-nowrap">{{$s->gb5_single}}</td>
                                <td class="text-nowrap">{{$s->gb5_multi}}</td>
                                <td class="text-nowrap">{{$s->d_4k_as_mbps}}<small>Mbps</small></td>
                                <td class="text-nowrap">{{$s->d_64k_as_mbps}}<small>Mbps</small></td>
                                <td class="text-nowrap">{{$s->d_512k_as_mbps}}<small>Mbps</small></td>
                                <td class="text-nowrap">{{$s->d_1m_as_mbps}}<small>Mbps</small></td>
                                <td class="text-nowrap"> {{ $s->owned_since }}</td>
                                <td class="text-nowrap">
                                    @if(Session::has('show_server_value_ip') && Session::get('show_server_value_ip') === '1')
                                        {{ $s->ipv4 }}
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if(Session::has('show_server_value_ip') && Session::get('show_server_value_ip') === '1')
                                        {{ $s->ipv6 }}
                                    @endif
                                </td>
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
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>Built on Laravel
                    v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</small></p>
        @endif
    </div>
</x-app-layout>
