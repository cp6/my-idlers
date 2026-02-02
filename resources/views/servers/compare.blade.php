@section("title", "Compare servers")
@section('style')
    <style>
        .compare-table th, .compare-table td {
            white-space: nowrap;
            vertical-align: middle;
        }
        .compare-table th:first-child, .compare-table td:first-child {
            position: sticky;
            left: 0;
            z-index: 1;
        }
        .plus-td { background: rgba(40, 167, 69, 0.15) !important; }
        .neg-td { background: rgba(220, 53, 69, 0.15) !important; }
        .equal-td { background: rgba(108, 117, 125, 0.1) !important; }
        .data-type { color: var(--text-muted); font-size: 0.85em; margin-left: 2px; }
    </style>
@endsection
<x-app-layout>
    <div class="container" id="app">
        <div class="page-header">
            <h2 class="page-title">Server Comparison</h2>
            <div class="page-actions">
                <a href="{{ route('servers-compare-choose') }}" class="btn btn-outline-secondary">Choose Others</a>
            </div>
        </div>

        <div class="card content-card">
            <div class="card-header card-section-header">
                <h5 class="card-section-title mb-0">
                    {{ $server1_data[0]->hostname }} vs {{ $server2_data[0]->hostname }}
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table data-table compare-table mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Metric</th>
                                <th class="text-center">{{ $server1_data[0]->hostname }}</th>
                                <th class="text-center">Difference</th>
                                <th class="text-center">{{ $server2_data[0]->hostname }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 fw-medium">CPU Cores</td>
                                <td class="text-center">{{ $server1_data[0]->yabs[0]->cpu_cores }}</td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->cpu_cores, $server2_data[0]->yabs[0]->cpu_cores, ' cores') !!}
                                <td class="text-center">{{ $server2_data[0]->yabs[0]->cpu_cores }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">CPU Frequency</td>
                                <td class="text-center">{{ $server1_data[0]->yabs[0]->cpu_freq }}<span class="data-type">MHz</span></td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->cpu_freq, $server2_data[0]->yabs[0]->cpu_freq, 'MHz') !!}
                                <td class="text-center">{{ $server2_data[0]->yabs[0]->cpu_freq }}<span class="data-type">MHz</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">RAM</td>
                                <td class="text-center">{{ $server1_data[0]->yabs[0]->ram_mb }}<span class="data-type">MB</span></td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->ram_mb, $server2_data[0]->yabs[0]->ram_mb, 'MB') !!}
                                <td class="text-center">{{ $server2_data[0]->yabs[0]->ram_mb }}<span class="data-type">MB</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Disk</td>
                                <td class="text-center">{{ $server1_data[0]->yabs[0]->disk_gb }}<span class="data-type">GB</span></td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_gb, $server2_data[0]->yabs[0]->disk_gb, 'GB') !!}
                                <td class="text-center">{{ $server2_data[0]->yabs[0]->disk_gb }}<span class="data-type">GB</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">GB5 Single</td>
                                <td class="text-center">{{ $server1_data[0]->yabs[0]->gb5_single }}</td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->gb5_single, $server2_data[0]->yabs[0]->gb5_single, '') !!}
                                <td class="text-center">{{ $server2_data[0]->yabs[0]->gb5_single }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">GB5 Multi</td>
                                <td class="text-center">{{ $server1_data[0]->yabs[0]->gb5_multi }}</td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->gb5_multi, $server2_data[0]->yabs[0]->gb5_multi, '') !!}
                                <td class="text-center">{{ $server2_data[0]->yabs[0]->gb5_multi }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">4K Disk Speed</td>
                                <td class="text-center">{{ $server1_data[0]->yabs[0]->disk_speed->d_4k_as_mbps }}<span class="data-type">MB/s</span></td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_speed->d_4k_as_mbps, $server2_data[0]->yabs[0]->disk_speed->d_4k_as_mbps, 'MB/s') !!}
                                <td class="text-center">{{ $server2_data[0]->yabs[0]->disk_speed->d_4k_as_mbps }}<span class="data-type">MB/s</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">64K Disk Speed</td>
                                <td class="text-center">{{ $server1_data[0]->yabs[0]->disk_speed->d_64k_as_mbps }}<span class="data-type">MB/s</span></td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_speed->d_64k_as_mbps, $server2_data[0]->yabs[0]->disk_speed->d_64k_as_mbps, 'MB/s') !!}
                                <td class="text-center">{{ $server2_data[0]->yabs[0]->disk_speed->d_64k_as_mbps }}<span class="data-type">MB/s</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">512K Disk Speed</td>
                                <td class="text-center">{{ $server1_data[0]->yabs[0]->disk_speed->d_512k_as_mbps }}<span class="data-type">MB/s</span></td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_speed->d_512k_as_mbps, $server2_data[0]->yabs[0]->disk_speed->d_512k_as_mbps, 'MB/s') !!}
                                <td class="text-center">{{ $server2_data[0]->yabs[0]->disk_speed->d_512k_as_mbps }}<span class="data-type">MB/s</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">1M Disk Speed</td>
                                <td class="text-center">{{ $server1_data[0]->yabs[0]->disk_speed->d_1m_as_mbps }}<span class="data-type">MB/s</span></td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_speed->d_1m_as_mbps, $server2_data[0]->yabs[0]->disk_speed->d_1m_as_mbps, 'MB/s') !!}
                                <td class="text-center">{{ $server2_data[0]->yabs[0]->disk_speed->d_1m_as_mbps }}<span class="data-type">MB/s</span></td>
                            </tr>
                            @for($i = 0; $i < 5; $i++)
                                @if(isset($server1_data[0]->yabs[0]->network_speed[$i]) && isset($server2_data[0]->yabs[0]->network_speed[$i]) && $server1_data[0]->yabs[0]->network_speed[$i]->location === $server2_data[0]->yabs[0]->network_speed[$i]->location)
                                    <tr>
                                        <td class="ps-3 fw-medium">{{ $server1_data[0]->yabs[0]->network_speed[$i]->location }} Send</td>
                                        <td class="text-center">{{ $server1_data[0]->yabs[0]->network_speed[$i]->send_as_mbps }}<span class="data-type">MB/s</span></td>
                                        {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[$i]->send_as_mbps, $server2_data[0]->yabs[0]->network_speed[$i]->send_as_mbps, 'MB/s') !!}
                                        <td class="text-center">{{ $server2_data[0]->yabs[0]->network_speed[$i]->send_as_mbps }}<span class="data-type">MB/s</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-3 fw-medium">{{ $server1_data[0]->yabs[0]->network_speed[$i]->location }} Receive</td>
                                        <td class="text-center">{{ $server1_data[0]->yabs[0]->network_speed[$i]->receive_as_mbps }}<span class="data-type">MB/s</span></td>
                                        {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[$i]->receive_as_mbps, $server2_data[0]->yabs[0]->network_speed[$i]->receive_as_mbps, 'MB/s') !!}
                                        <td class="text-center">{{ $server2_data[0]->yabs[0]->network_speed[$i]->receive_as_mbps }}<span class="data-type">MB/s</span></td>
                                    </tr>
                                @endif
                            @endfor
                            <tr>
                                <td class="ps-3 fw-medium">USD per Month</td>
                                <td class="text-center">{{ $server1_data[0]->price->usd_per_month }}<span class="data-type">/mo</span></td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->price->usd_per_month, $server2_data[0]->price->usd_per_month, '/mo') !!}
                                <td class="text-center">{{ $server2_data[0]->price->usd_per_month }}<span class="data-type">/mo</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Actual Price</td>
                                <td class="text-center">{{ $server1_data[0]->price->price }}<span class="data-type">{{ $server1_data[0]->currency }}</span> {{ \App\Process::paymentTermIntToString($server1_data[0]->price->term) }}</td>
                                <td class="text-center equal-td">—</td>
                                <td class="text-center">{{ $server2_data[0]->price->price }}<span class="data-type">{{ $server2_data[0]->price->currency }}</span> {{ \App\Process::paymentTermIntToString($server2_data[0]->price->term) }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">CPU per USD</td>
                                <td class="text-center">{{ number_format($server1_data[0]->yabs[0]->cpu_cores / $server1_data[0]->price->usd_per_month, 2) }}</td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->cpu_cores / $server1_data[0]->price->usd_per_month, $server2_data[0]->yabs[0]->cpu_cores / $server2_data[0]->price->usd_per_month, '') !!}
                                <td class="text-center">{{ number_format($server2_data[0]->yabs[0]->cpu_cores / $server2_data[0]->price->usd_per_month, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Disk GB per USD</td>
                                <td class="text-center">{{ number_format($server1_data[0]->yabs[0]->disk_gb / $server1_data[0]->price->usd_per_month, 2) }}</td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_gb / $server1_data[0]->price->usd_per_month, $server2_data[0]->yabs[0]->disk_gb / $server2_data[0]->price->usd_per_month, '') !!}
                                <td class="text-center">{{ number_format($server2_data[0]->yabs[0]->disk_gb / $server2_data[0]->price->usd_per_month, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">RAM MB per USD</td>
                                <td class="text-center">{{ number_format($server1_data[0]->yabs[0]->ram_mb / $server1_data[0]->price->usd_per_month, 2) }}</td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->ram_mb / $server1_data[0]->price->usd_per_month, $server2_data[0]->yabs[0]->ram_mb / $server2_data[0]->price->usd_per_month, '') !!}
                                <td class="text-center">{{ number_format($server2_data[0]->yabs[0]->ram_mb / $server2_data[0]->price->usd_per_month, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">GB5 Single per USD</td>
                                <td class="text-center">{{ number_format($server1_data[0]->yabs[0]->gb5_single / $server1_data[0]->price->usd_per_month, 2) }}</td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->gb5_single / $server1_data[0]->price->usd_per_month, $server2_data[0]->yabs[0]->gb5_single / $server2_data[0]->price->usd_per_month, '') !!}
                                <td class="text-center">{{ number_format($server2_data[0]->yabs[0]->gb5_single / $server2_data[0]->price->usd_per_month, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">GB5 Multi per USD</td>
                                <td class="text-center">{{ number_format($server1_data[0]->yabs[0]->gb5_multi / $server1_data[0]->price->usd_per_month, 2) }}</td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->gb5_multi / $server1_data[0]->price->usd_per_month, $server2_data[0]->yabs[0]->gb5_multi / $server2_data[0]->price->usd_per_month, '') !!}
                                <td class="text-center">{{ number_format($server2_data[0]->yabs[0]->gb5_multi / $server2_data[0]->price->usd_per_month, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Location</td>
                                <td class="text-center">{{ $server1_data[0]->location->name }}</td>
                                <td class="text-center equal-td">—</td>
                                <td class="text-center">{{ $server2_data[0]->location->name }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Provider</td>
                                <td class="text-center">{{ $server1_data[0]->provider->name }}</td>
                                <td class="text-center equal-td">—</td>
                                <td class="text-center">{{ $server2_data[0]->provider->name }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Owned Since</td>
                                <td class="text-center">{{ date_format(new DateTime($server1_data[0]->owned_since), 'F Y') }}</td>
                                <td class="text-center equal-td">{{ \Carbon\Carbon::parse($server1_data[0]->owned_since)->diffForHumans(\Carbon\Carbon::parse($server2_data[0]->owned_since)) }}</td>
                                <td class="text-center">{{ date_format(new DateTime($server2_data[0]->owned_since), 'F Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <x-details-footer></x-details-footer>
    </div>
</x-app-layout>
