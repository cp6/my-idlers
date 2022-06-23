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
                                <td class="text-center">{!!App\Models\Server::osIntToIcon($s->os_id, $s->os_name)!!}</td>
                                <td class="text-center">{{$s->cpu}}</td>
                                <td class="text-nowrap">{{$s->cpu_freq}}</td>
                                <td class="text-nowrap">
                                    @if(isset($s->ram))
                                        {{ $s->ram}}<small>{{ $s->ram_type}}</small>
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
                                        {{ $s->location }}
                                    @endif</td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_provider') === 1)
                                        {{ $s->provider_name }}
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ $s->price }} {{$s->currency}} {{\App\Process::paymentTermIntToString($s->term)}}</td>
                                <td class="text-nowrap"> {{ $s->owned_since }}</td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->gb5_single}}
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->gb5_multi}}
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->d_4k}}<small>{{$s->d_4k_type}}</small>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->d_64k}}<small>{{$s->d_64k_type}}</small>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->d_512k}}<small>{{$s->d_512k_type}}</small>
                                    @endif</td>
                                <td class="text-nowrap">
                                    @if(Session::get('show_server_value_yabs') === 1)
                                        {{$s->d_1m}}<small>{{$s->d_1m_type}}</small>
                                    @endif</td>
                                @if(Session::get('show_server_value_ip') === 1)
                                    <td class="text-nowrap">
                                        @if($s->is_ipv4 === 1)
                                            {{ $s->ip }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        @if($s->is_ipv4 === 0)
                                            {{ $s->ip }}
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
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>Built on Laravel
                    v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</small></p>
        @endif
    </div>
</x-app-layout>
