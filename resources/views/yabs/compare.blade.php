@section("title", "Compare YABS")
@section('style')
    <style>
        .td-nowrap {
            white-space: nowrap;
        }

        .plus-td {
            background: #71ed7136 !important;
        }

        .neg-td {
            background: #ed827136 !important;
        }

        .equal-td {
            background: #6189ff26 !important;
        }

        .objects-table th:first-child, .objects-table td:first-child, .compare-table th:first-child, .compare-table td:first-child {
            position: sticky;
            left: 0;
            background-color: #f6f6f6;
            text-align: left;
        }

        .data-type {
            color: #212529b3;
            padding-left: .05rem;
            font-size: 85%;
        }
    </style>
@endsection
<x-app-layout>
    <div class="container" id="app">
        <div class="card shadow mt-3">
            <div class="card-body">
                <a href="{{ route('yabs.compare-choose') }}" class="btn btn-primary mb-3">Choose others</a>
                <div class="table-responsive">
                    <table class="table compare-table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>{{ $yabs1_data->id }}</th>
                            <th>DIF</th>
                            <th>{{ $yabs2_data->id}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="td-nowrap">Date</td>
                            <td class="td-nowrap">{{ date_format(new DateTime($yabs1_data->output_date), 'g:ia D jS F Y') }}</td>
                            <td class="td-nowrap equal-td">
                                {{\Carbon\Carbon::parse($yabs1_data->output_date)->diffForHumans(\Carbon\Carbon::parse($yabs2_data->output_date))}}
                            </td>
                            <td class="td-nowrap">{{ date_format(new DateTime($yabs2_data->output_date), 'g:ia D jS F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">Server</td>
                            <td class="td-nowrap">{{$yabs1_data->server->hostname}}</td>
                            <td class="td-nowrap equal-td"></td>
                            <td class="td-nowrap">{{$yabs2_data->server->hostname}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">CPU count</td>
                            <td class="td-nowrap">{{$yabs1_data->cpu_cores}}</td>
                            {!! \App\Models\Server::tableRowCompare($yabs1_data->cpu_cores, $yabs2_data->cpu_cores, ' cores') !!}
                            <td class="td-nowrap">{{$yabs2_data->cpu_cores}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">CPU freq</td>
                            <td class="td-nowrap">{{$yabs1_data->cpu_freq}}<span class="data-type">Mhz</span></td>
                            {!! \App\Models\Server::tableRowCompare($yabs1_data->cpu_freq, $yabs2_data->cpu_freq, 'Mhz') !!}
                            <td class="td-nowrap">{{$yabs2_data->cpu_freq}}<span class="data-type">Mhz</span></td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">RAM</td>
                            <td class="td-nowrap">{{$yabs1_data->ram_mb}}<span class="data-type">MB</span></td>
                            {!! \App\Models\Server::tableRowCompare($yabs1_data->ram_mb, $yabs2_data->ram_mb, 'MB') !!}
                            <td class="td-nowrap">{{$yabs2_data->ram_mb}}<span class="data-type">MB</span></td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">Disk</td>
                            <td class="td-nowrap">{{$yabs1_data->disk_gb}}<span class="data-type">GB</span></td>
                            {!! \App\Models\Server::tableRowCompare($yabs1_data->disk_gb, $yabs2_data->disk_gb, 'GB') !!}
                            <td class="td-nowrap">{{$yabs2_data->disk_gb}}<span class="data-type">GB</span></td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">GB5 single</td>
                            <td class="td-nowrap">{{$yabs1_data->gb5_single}}</td>
                            @if(!is_null($yabs1_data->gb5_single) && !is_null($yabs2_data->gb5_single))
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->gb5_single, $yabs2_data->gb5_single, '') !!}
                            @else
                                <td>-</td>
                            @endif
                            <td class="td-nowrap">{{$yabs2_data->gb5_single}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">GB5 multi</td>
                            <td class="td-nowrap">{{$yabs1_data->gb5_multi}}</td>
                            @if(!is_null($yabs1_data->gb5_multi) && !is_null($yabs2_data->gb5_multi))
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->gb5_multi, $yabs2_data->gb5_multi, '') !!}
                            @else
                                <td>-</td>
                            @endif
                            <td class="td-nowrap">{{$yabs2_data->gb5_multi}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">4k disk</td>
                            <td class="td-nowrap">{{$yabs1_data->disk_speed->d_4k_as_mbps}}<span class="data-type">MB/s</span>
                            </td>
                            {!! \App\Models\Server::tableRowCompare($yabs1_data->disk_speed->d_4k_as_mbps, $yabs2_data->disk_speed->d_4k_as_mbps, 'MB/s') !!}
                            <td class="td-nowrap">{{$yabs2_data->disk_speed->d_4k_as_mbps}}<span class="data-type">MB/s</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">64k disk</td>
                            <td class="td-nowrap">{{$yabs1_data->disk_speed->d_64k_as_mbps}}<span class="data-type">MB/s</span>
                            </td>
                            {!! \App\Models\Server::tableRowCompare($yabs1_data->disk_speed->d_64k_as_mbps, $yabs2_data->disk_speed->d_64k_as_mbps, 'MB/s') !!}
                            <td class="td-nowrap">{{$yabs2_data->disk_speed->d_64k_as_mbps}}<span class="data-type">MB/s</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">512k disk</td>
                            <td class="td-nowrap">{{$yabs1_data->disk_speed->d_512k_as_mbps}}<span
                                    class="data-type">MB/s</span></td>
                            {!! \App\Models\Server::tableRowCompare($yabs1_data->disk_speed->d_512k_as_mbps, $yabs2_data->disk_speed->d_512k_as_mbps, 'MB/s') !!}
                            <td class="td-nowrap">{{$yabs2_data->disk_speed->d_512k_as_mbps}}<span
                                    class="data-type">MB/s</span></td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">1m disk</td>
                            <td class="td-nowrap">{{$yabs1_data->disk_speed->d_1m_as_mbps}}<span class="data-type">MB/s</span>
                            </td>
                            {!! \App\Models\Server::tableRowCompare($yabs1_data->disk_speed->d_1m_as_mbps, $yabs2_data->disk_speed->d_1m_as_mbps, 'MB/s') !!}
                            <td class="td-nowrap">{{$yabs2_data->disk_speed->d_1m_as_mbps}}<span class="data-type">MB/s</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">{{$yabs1_data->network_speed[0]->location}} send</td>
                            <td class="td-nowrap">{{$yabs1_data->network_speed[0]->send_as_mbps}}<span
                                    class="data-type">MBps</span></td>
                            {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[0]->send_as_mbps, $yabs2_data->network_speed[0]->send_as_mbps, 'MBps') !!}
                            <td class="td-nowrap">{{$yabs2_data->network_speed[0]->send_as_mbps}}<span
                                    class="data-type">MBps</span></td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">{{$yabs1_data->network_speed[0]->location}} receive</td>
                            <td class="td-nowrap">{{$yabs1_data->network_speed[0]->receive_as_mbps}}<span
                                    class="data-type">MBps</span></td>
                            {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[0]->receive_as_mbps, $yabs2_data->network_speed[0]->receive_as_mbps, 'MBps') !!}
                            <td class="td-nowrap">{{$yabs2_data->network_speed[0]->receive_as_mbps}}<span
                                    class="data-type">MBps</span></td>
                        </tr>
                        @if($yabs1_data->network_speed[1]->location === $yabs2_data->network_speed[1]->location)
                            <tr>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[1]->location}} send</td>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[1]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[1]->send_as_mbps, $yabs2_data->network_speed[1]->send_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$yabs2_data->network_speed[1]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                            </tr>
                            <tr>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[1]->location}} receive</td>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[1]->receive_as_mbps}}<span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[1]->receive_as_mbps, $yabs2_data->network_speed[1]->receive_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$yabs2_data->network_speed[1]->receive_as_mbps}}<span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        @if($yabs1_data->network_speed[2]->location === $yabs2_data->network_speed[2]->location)
                            <tr>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[2]->location}} send</td>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[2]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[2]->send_as_mbps, $yabs2_data->network_speed[2]->send_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$yabs2_data->network_speed[2]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                            </tr>
                            <tr>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[2]->location}} receive</td>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[2]->receive_as_mbps}}<span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[2]->receive_as_mbps, $yabs2_data->network_speed[2]->receive_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$yabs2_data->network_speed[2]->receive_as_mbps}}<span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        @if(isset($yabs1_data->network_speed[3]) && $yabs1_data->network_speed[3]->location === $yabs2_data->network_speed[3]->location)
                            <tr>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[3]->location}} send</td>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[3]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[3]->send_as_mbps, $yabs2_data->network_speed[3]->send_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$yabs2_data->network_speed[3]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                            </tr>
                            <tr>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[3]->location}} receive</td>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[3]->receive_as_mbps}}<span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[3]->receive_as_mbps, $yabs2_data->network_speed[3]->receive_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$yabs2_data->network_speed[3]->receive_as_mbps}}<span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        @if(isset($yabs1_data->network_speed[4]) && $yabs1_data->network_speed[4]->location === $yabs2_data->network_speed[4]->location)
                            <tr>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[4]->location}} send</td>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[4]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[4]->send_as_mbps, $yabs2_data->network_speed[4]->send_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$yabs2_data->network_speed[4]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                            </tr>
                            <tr>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[4]->location}} receive</td>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[4]->receive_as_mbps}}<span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[4]->receive_as_mbps, $yabs2_data->network_speed[4]->receive_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$yabs2_data->network_speed[4]->receive_as_mbps}}<span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        @if(isset($yabs1_data->network_speed[4]) && $yabs1_data->network_speed[4]->location === $yabs2_data->network_speed[5]->location)
                            <tr>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[4]->location}} send</td>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[4]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[4]->send_as_mbps, $yabs2_data->network_speed[5]->send_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$yabs2_data->network_speed[5]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                            </tr>
                            <tr>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[4]->location}} receive</td>
                                <td class="td-nowrap">{{$yabs1_data->network_speed[4]->receive_as_mbps}}<span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($yabs1_data->network_speed[4]->receive_as_mbps, $yabs2_data->network_speed[5]->receive_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$yabs2_data->network_speed[5]->receive_as_mbps}}<span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
