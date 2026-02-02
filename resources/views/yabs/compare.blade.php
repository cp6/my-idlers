@section("title", "Compare YABS")
@section('style')
    <style>
        .compare-table th, .compare-table td { white-space: nowrap; vertical-align: middle; }
        .compare-table th:first-child, .compare-table td:first-child { position: sticky; left: 0; z-index: 1; }
        .plus-td { background: rgba(40, 167, 69, 0.15) !important; }
        .neg-td { background: rgba(220, 53, 69, 0.15) !important; }
        .equal-td { background: rgba(108, 117, 125, 0.1) !important; }
        .data-type { color: var(--text-muted); font-size: 0.85em; margin-left: 2px; }
    </style>
@endsection
<x-app-layout>
    <div class="container" id="app">
        <div class="page-header">
            <h2 class="page-title">YABS Comparison</h2>
            <div class="page-actions">
                <a href="{{ route('yabs.compare-choose') }}" class="btn btn-outline-secondary">Choose Others</a>
            </div>
        </div>
        <div class="card content-card">
            <div class="card-header card-section-header">
                <h5 class="card-section-title mb-0">{{ $yabs1_data->server->hostname }} vs {{ $yabs2_data->server->hostname }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table data-table compare-table mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Metric</th>
                                <th class="text-center">YABS #{{ $yabs1_data->id }}</th>
                                <th class="text-center">Difference</th>
                                <th class="text-center">YABS #{{ $yabs2_data->id }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 fw-medium">Date</td>
                                <td class="text-center">{{ date_format(new DateTime($yabs1_data->output_date), 'M j, Y g:ia') }}</td>
                                <td class="text-center equal-td">{{ \Carbon\Carbon::parse($yabs1_data->output_date)->diffForHumans(\Carbon\Carbon::parse($yabs2_data->output_date)) }}</td>
                                <td class="text-center">{{ date_format(new DateTime($yabs2_data->output_date), 'M j, Y g:ia') }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Server</td>
                                <td class="text-center">{{ $yabs1_data->server->hostname }}</td>
                                <td class="text-center equal-td">—</td>
                                <td class="text-center">{{ $yabs2_data->server->hostname }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">CPU Cores</td>
                                <td class="text-center">{{ $yabs1_data->cpu_cores }}</td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->cpu_cores, $yabs2_data->cpu_cores, ' cores') !!}
                                <td class="text-center">{{ $yabs2_data->cpu_cores }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">CPU Frequency</td>
                                <td class="text-center">{{ $yabs1_data->cpu_freq }}<span class="data-type">MHz</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->cpu_freq, $yabs2_data->cpu_freq, 'MHz') !!}
                                <td class="text-center">{{ $yabs2_data->cpu_freq }}<span class="data-type">MHz</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">RAM</td>
                                <td class="text-center">{{ $yabs1_data->ram_mb }}<span class="data-type">MB</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->ram_mb, $yabs2_data->ram_mb, 'MB') !!}
                                <td class="text-center">{{ $yabs2_data->ram_mb }}<span class="data-type">MB</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Disk</td>
                                <td class="text-center">{{ $yabs1_data->disk_gb }}<span class="data-type">GB</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->disk_gb, $yabs2_data->disk_gb, 'GB') !!}
                                <td class="text-center">{{ $yabs2_data->disk_gb }}<span class="data-type">GB</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">GB5 Single</td>
                                <td class="text-center">{{ $yabs1_data->gb5_single ?? '—' }}</td>
                                @if($yabs1_data->gb5_single !== null && $yabs2_data->gb5_single !== null)
                                    {!! \App\Models\Server::tableRowCompare($yabs1_data->gb5_single, $yabs2_data->gb5_single, '') !!}
                                @else
                                    <td class="text-center equal-td">—</td>
                                @endif
                                <td class="text-center">{{ $yabs2_data->gb5_single ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">GB5 Multi</td>
                                <td class="text-center">{{ $yabs1_data->gb5_multi ?? '—' }}</td>
                                @if($yabs1_data->gb5_multi !== null && $yabs2_data->gb5_multi !== null)
                                    {!! \App\Models\Server::tableRowCompare($yabs1_data->gb5_multi, $yabs2_data->gb5_multi, '') !!}
                                @else
                                    <td class="text-center equal-td">—</td>
                                @endif
                                <td class="text-center">{{ $yabs2_data->gb5_multi ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">4K Disk Speed</td>
                                <td class="text-center">{{ $yabs1_data->disk_speed->d_4k_as_mbps }}<span class="data-type">MB/s</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->disk_speed->d_4k_as_mbps, $yabs2_data->disk_speed->d_4k_as_mbps, 'MB/s') !!}
                                <td class="text-center">{{ $yabs2_data->disk_speed->d_4k_as_mbps }}<span class="data-type">MB/s</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">64K Disk Speed</td>
                                <td class="text-center">{{ $yabs1_data->disk_speed->d_64k_as_mbps }}<span class="data-type">MB/s</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->disk_speed->d_64k_as_mbps, $yabs2_data->disk_speed->d_64k_as_mbps, 'MB/s') !!}
                                <td class="text-center">{{ $yabs2_data->disk_speed->d_64k_as_mbps }}<span class="data-type">MB/s</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">512K Disk Speed</td>
                                <td class="text-center">{{ $yabs1_data->disk_speed->d_512k_as_mbps }}<span class="data-type">MB/s</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->disk_speed->d_512k_as_mbps, $yabs2_data->disk_speed->d_512k_as_mbps, 'MB/s') !!}
                                <td class="text-center">{{ $yabs2_data->disk_speed->d_512k_as_mbps }}<span class="data-type">MB/s</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">1M Disk Speed</td>
                                <td class="text-center">{{ $yabs1_data->disk_speed->d_1m_as_mbps }}<span class="data-type">MB/s</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->disk_speed->d_1m_as_mbps, $yabs2_data->disk_speed->d_1m_as_mbps, 'MB/s') !!}
                                <td class="text-center">{{ $yabs2_data->disk_speed->d_1m_as_mbps }}<span class="data-type">MB/s</span></td>
                            </tr>
                            @for($i = 0; $i < 6; $i++)
                                @if(isset($yabs1_data->network_speed[$i]) && isset($yabs2_data->network_speed[$i]) && $yabs1_data->network_speed[$i]->location === $yabs2_data->network_speed[$i]->location)
                                    <tr>
                                        <td class="ps-3 fw-medium">{{ $yabs1_data->network_speed[$i]->location }} Send</td>
                                        <td class="text-center">{{ $yabs1_data->network_speed[$i]->send_as_mbps }}<span class="data-type">MB/s</span></td>
                                        {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[$i]->send_as_mbps, $yabs2_data->network_speed[$i]->send_as_mbps, 'MB/s') !!}
                                        <td class="text-center">{{ $yabs2_data->network_speed[$i]->send_as_mbps }}<span class="data-type">MB/s</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-3 fw-medium">{{ $yabs1_data->network_speed[$i]->location }} Receive</td>
                                        <td class="text-center">{{ $yabs1_data->network_speed[$i]->receive_as_mbps }}<span class="data-type">MB/s</span></td>
                                        {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[$i]->receive_as_mbps, $yabs2_data->network_speed[$i]->receive_as_mbps, 'MB/s') !!}
                                        <td class="text-center">{{ $yabs2_data->network_speed[$i]->receive_as_mbps }}<span class="data-type">MB/s</span></td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <x-details-footer></x-details-footer>
    </div>
</x-app-layout>
