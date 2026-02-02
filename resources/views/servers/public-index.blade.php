@section("title", "Public viewable servers")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Public Servers</h2>
        </div>

        <div class="card content-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table data-table mb-0">
                        <thead>
                            <tr>
                                @if(Session::get('show_server_value_hostname') === 1)
                                    <th>Hostname</th>
                                @endif
                                <th class="text-center">Type</th>
                                <th class="text-center">OS</th>
                                <th class="text-center">CPU</th>
                                <th class="text-center">MHz</th>
                                <th class="text-center">RAM</th>
                                <th class="text-center">Disk</th>
                                <th>Location</th>
                                <th>Provider</th>
                                <th>Price</th>
                                <th class="text-center">Since</th>
                                <th class="text-center">GB6 S</th>
                                <th class="text-center">GB6 M</th>
                                <th class="text-center">4K</th>
                                <th class="text-center">64K</th>
                                <th class="text-center">512K</th>
                                <th class="text-center">1M</th>
                                @if(Session::get('show_server_value_ip') === 1)
                                    <th>IPv4</th>
                                    <th>IPv6</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($servers[0]))
                            @foreach($servers as $s)
                                <tr>
                                    @if(Session::get('show_server_value_hostname') === 1)
                                        <td class="fw-medium">{{ $s->hostname }}</td>
                                    @endif
                                    <td class="text-center">
                                        <span class="badge badge-type">{{ App\Models\Server::serviceServerType($s->server_type) }}</span>
                                    </td>
                                    <td class="text-center">{!! App\Models\Server::osIntToIcon($s->os->id, $s->os->name) !!}</td>
                                    <td class="text-center">{{ $s->cpu }}</td>
                                    <td class="text-center text-nowrap">{{ $s->yabs[0]->cpu_freq ?? '—' }}</td>
                                    <td class="text-center text-nowrap">
                                        @if(isset($s->yabs[0]->ram))
                                            {{ $s->yabs[0]->ram }}<small class="text-muted">{{ $s->yabs[0]->ram_type }}</small>
                                        @else
                                            {{ $s->ram_as_mb }}<small class="text-muted">MB</small>
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        @if($s->disk > 1000)
                                            {{ number_format($s->disk / 1024, 1) }}<small class="text-muted">TB</small>
                                        @else
                                            {{ $s->disk }}<small class="text-muted">GB</small>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        @if(Session::get('show_server_value_location') === 1)
                                            {{ $s->location->name }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        @if(Session::get('show_server_value_provider') === 1)
                                            {{ $s->provider->name }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        {{ $s->price->price }} {{ $s->currency }}
                                        <small class="text-muted">{{ \App\Process::paymentTermIntToString($s->price->term) }}</small>
                                    </td>
                                    <td class="text-center text-nowrap">{{ $s->owned_since }}</td>
                                    <td class="text-center text-nowrap">
                                        @if(Session::get('show_server_value_yabs') === 1)
                                            {{ $s->yabs[0]->gb6_single ?? '—' }}
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        @if(Session::get('show_server_value_yabs') === 1)
                                            {{ $s->yabs[0]->gb6_multi ?? '—' }}
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        @if(Session::get('show_server_value_yabs') === 1)
                                            {{ $s->yabs[0]->disk_speed->d_4k ?? '—' }}<small class="text-muted">{{ $s->yabs[0]->disk_speed->d_4k_type ?? '' }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        @if(Session::get('show_server_value_yabs') === 1)
                                            {{ $s->yabs[0]->disk_speed->d_64k ?? '—' }}<small class="text-muted">{{ $s->yabs[0]->disk_speed->d_64k_type ?? '' }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        @if(Session::get('show_server_value_yabs') === 1)
                                            {{ $s->yabs[0]->disk_speed->d_512k ?? '—' }}<small class="text-muted">{{ $s->yabs[0]->disk_speed->d_512k_type ?? '' }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        @if(Session::get('show_server_value_yabs') === 1)
                                            {{ $s->yabs[0]->disk_speed->d_1m ?? '—' }}<small class="text-muted">{{ $s->yabs[0]->disk_speed->d_1m_type ?? '' }}</small>
                                        @endif
                                    </td>
                                    @if(Session::get('show_server_value_ip') === 1)
                                        <td class="text-nowrap">
                                            @if(isset($s->ips[0]) && $s->ips[0]->is_ipv4 === 1)
                                                {{ $s->ips[0]->address }}
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            @if(isset($s->ips[0]) && $s->ips[0]->is_ipv6 === 1)
                                                {{ $s->ips[0]->address }}
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="17" class="text-center text-muted py-4">No public servers found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <x-details-footer></x-details-footer>
    </div>
</x-app-layout>
