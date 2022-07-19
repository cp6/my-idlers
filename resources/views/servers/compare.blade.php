@section('title')
    {{'Compare servers'}}
@endsection
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
                <a href="{{ route('servers-compare-choose') }}" class="btn btn-primary mb-3">Choose others</a>
                <div class="table-responsive">
                    <table class="table compare-table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>{{$server1_data[0]->hostname}}</th>
                            <th>DIF</th>
                            <th>{{$server2_data[0]->hostname}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="td-nowrap">CPU count</td>
                            <td class="td-nowrap">{{$server1_data[0]->yabs[0]->cpu_cores}}</td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->cpu_cores, $server2_data[0]->yabs[0]->cpu_cores, ' cores') !!}
                            <td class="td-nowrap">{{$server2_data[0]->yabs[0]->cpu_cores}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">CPU freq</td>
                            <td class="td-nowrap">{{$server1_data[0]->yabs[0]->cpu_freq}}<span
                                    class="data-type">Mhz</span></td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->cpu_freq, $server2_data[0]->yabs[0]->cpu_freq, 'Mhz') !!}
                            <td class="td-nowrap">{{$server2_data[0]->yabs[0]->cpu_freq}}<span
                                    class="data-type">Mhz</span></td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">Ram</td>
                            <td class="td-nowrap">{{$server1_data[0]->yabs[0]->ram_mb}}<span class="data-type">MB</span>
                            </td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->ram_mb, $server2_data[0]->yabs[0]->ram_mb, 'MB') !!}
                            <td class="td-nowrap">{{$server2_data[0]->yabs[0]->ram_mb}}<span class="data-type">MB</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">Disk</td>
                            <td class="td-nowrap">{{$server1_data[0]->yabs[0]->disk_gb}}<span
                                    class="data-type">GB</span></td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_gb, $server2_data[0]->yabs[0]->disk_gb, 'GB') !!}
                            <td class="td-nowrap">{{$server2_data[0]->yabs[0]->disk_gb}}<span
                                    class="data-type">GB</span></td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">GB5 single</td>
                            <td class="td-nowrap">{{$server1_data[0]->yabs[0]->gb5_single}}</td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->gb5_single, $server2_data[0]->yabs[0]->gb5_single, '') !!}
                            <td class="td-nowrap">{{$server2_data[0]->yabs[0]->gb5_single}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">GB5 multi</td>
                            <td class="td-nowrap">{{$server1_data[0]->yabs[0]->gb5_multi}}</td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->gb5_multi, $server2_data[0]->yabs[0]->gb5_multi, '') !!}
                            <td class="td-nowrap">{{$server2_data[0]->yabs[0]->gb5_multi}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">4k disk</td>
                            <td class="td-nowrap">{{$server1_data[0]->yabs[0]->disk_speed->d_4k_as_mbps}}<span
                                    class="data-type">MB/s</span>
                            </td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_speed->d_4k_as_mbps, $server2_data[0]->yabs[0]->disk_speed->d_4k_as_mbps, 'MB/s') !!}
                            <td class="td-nowrap">{{$server2_data[0]->yabs[0]->disk_speed->d_4k_as_mbps}}<span
                                    class="data-type">MB/s</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">64k disk</td>
                            <td class="td-nowrap">{{$server1_data[0]->yabs[0]->disk_speed->d_64k_as_mbps}}<span
                                    class="data-type">MB/s</span>
                            </td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_speed->d_64k_as_mbps, $server2_data[0]->yabs[0]->disk_speed->d_64k_as_mbps, 'MB/s') !!}
                            <td class="td-nowrap">{{$server2_data[0]->yabs[0]->disk_speed->d_64k_as_mbps}}<span
                                    class="data-type">MB/s</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">512k disk</td>
                            <td class="td-nowrap">{{$server1_data[0]->yabs[0]->disk_speed->d_512k_as_mbps}}<span
                                    class="data-type">MB/s</span></td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_speed->d_512k_as_mbps, $server2_data[0]->yabs[0]->disk_speed->d_512k_as_mbps, 'MB/s') !!}
                            <td class="td-nowrap">{{$server2_data[0]->yabs[0]->disk_speed->d_512k_as_mbps}}<span
                                    class="data-type">MB/s</span></td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">1m disk</td>
                            <td class="td-nowrap">{{$server1_data[0]->yabs[0]->disk_speed->d_1m_as_mbps}}<span
                                    class="data-type">MB/s</span>
                            </td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_speed->d_1m_as_mbps, $server2_data[0]->yabs[0]->disk_speed->d_1m_as_mbps, 'MB/s') !!}
                            <td class="td-nowrap">{{$server2_data[0]->yabs[0]->disk_speed->d_1m_as_mbps}}<span
                                    class="data-type">MB/s</span>
                            </td>
                        </tr>
                        @if($server1_data[0]->yabs[0]->network_speed[0]->location === $server2_data[0]->yabs[0]->network_speed[0]->location)
                            <tr>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[0]->location}} send
                                </td>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[0]->send_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[0]->send_as_mbps, $server2_data[0]->yabs[0]->network_speed[0]->send_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$server2_data[0]->yabs[0]->network_speed[0]->send_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        @if($server1_data[0]->yabs[0]->network_speed[0]->location === $server2_data[0]->yabs[0]->network_speed[0]->location)
                            <tr>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[0]->location}} receive
                                </td>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[0]->receive_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[0]->receive_as_mbps, $server2_data[0]->yabs[0]->network_speed[0]->receive_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$server2_data[0]->yabs[0]->network_speed[0]->receive_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        @if($server1_data[0]->yabs[0]->network_speed[1]->location === $server2_data[0]->yabs[0]->network_speed[1]->location)
                            <tr>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[1]->location}} send
                                </td>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[1]->send_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[1]->send_as_mbps, $server2_data[0]->yabs[0]->network_speed[1]->send_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$server2_data[0]->yabs[0]->network_speed[1]->send_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        @if($server1_data[0]->yabs[0]->network_speed[1]->location === $server2_data[0]->yabs[0]->network_speed[1]->location)
                            <tr>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[1]->location}} receive
                                </td>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[1]->receive_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[1]->receive_as_mbps, $server2_data[0]->yabs[0]->network_speed[1]->receive_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$server2_data[0]->yabs[0]->network_speed[1]->receive_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        @if($server1_data[0]->yabs[0]->network_speed[2]->location === $server2_data[0]->yabs[0]->network_speed[2]->location)
                            <tr>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[2]->location}} send
                                </td>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[2]->send_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[2]->send_as_mbps, $server2_data[0]->yabs[0]->network_speed[2]->send_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$server2_data[0]->yabs[0]->network_speed[2]->send_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        @if($server1_data[0]->yabs[0]->network_speed[2]->location === $server2_data[0]->yabs[0]->network_speed[2]->location)
                            <tr>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[2]->location}} receive
                                </td>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[2]->receive_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[2]->receive_as_mbps, $server2_data[0]->yabs[0]->network_speed[2]->receive_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$server2_data[0]->yabs[0]->network_speed[2]->receive_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        @if($server1_data[0]->yabs[0]->network_speed[3]->location === $server2_data[0]->yabs[0]->network_speed[3]->location)
                            <tr>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[3]->location}} send
                                </td>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[3]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[3]->send_as_mbps, $server2_data[0]->yabs[0]->network_speed[3]->send_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$server2_data[0]->yabs[0]->network_speed[3]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                            </tr>
                        @endif
                        @if($server1_data[0]->yabs[0]->network_speed[3]->location === $server2_data[0]->yabs[0]->network_speed[3]->location)
                            <tr>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[3]->location}} receive
                                </td>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[3]->receive_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[3]->receive_as_mbps, $server2_data[0]->yabs[0]->network_speed[3]->receive_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$server2_data[0]->yabs[0]->network_speed[3]->receive_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        @if($server1_data[0]->yabs[0]->network_speed[4]->location === $server2_data[0]->yabs[0]->network_speed[4]->location)
                            <tr>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[4]->location}} send
                                </td>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[4]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[4]->send_as_mbps, $server2_data[0]->yabs[0]->network_speed[4]->send_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$server2_data[0]->yabs[0]->network_speed[4]->send_as_mbps}}<span
                                        class="data-type">MBps</span></td>
                            </tr>
                        @endif
                        @if($server1_data[0]->yabs[0]->network_speed[4]->location === $server2_data[0]->yabs[0]->network_speed[4]->location)
                            <tr>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[4]->location}} receive
                                </td>
                                <td class="td-nowrap">{{$server1_data[0]->yabs[0]->network_speed[4]->receive_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                                {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->network_speed[4]->receive_as_mbps, $server2_data[0]->yabs[0]->network_speed[4]->receive_as_mbps, 'MBps') !!}
                                <td class="td-nowrap">{{$server2_data[0]->yabs[0]->network_speed[4]->receive_as_mbps}}
                                    <span class="data-type">MBps</span>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="td-nowrap">USD p/m</td>
                            <td class="td-nowrap">{{$server1_data[0]->price->usd_per_month}}<span
                                    class="data-type">p/m</span>
                            </td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->price->usd_per_month, $server2_data[0]->price->usd_per_month, 'p/m') !!}
                            <td class="td-nowrap">{{$server2_data[0]->price->usd_per_month}}<span
                                    class="data-type">p/m</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">Actual price</td>
                            <td class="td-nowrap">{{$server1_data[0]->price->price}}<span
                                    class="data-type">{{$server1_data[0]->currency}}</span> {{\App\Process::paymentTermIntToString($server1_data[0]->price->term)}}
                            </td>
                            <td class="td-nowrap equal-td"></td>
                            <td class="td-nowrap">{{$server2_data[0]->price->price}}<span
                                    class="data-type">{{$server2_data[0]->price->currency}}</span> {{\App\Process::paymentTermIntToString($server2_data[0]->price->term)}}
                            </td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">CPU per USD</td>
                            <td class="td-nowrap">{{number_format($server1_data[0]->yabs[0]->cpu_cores / $server1_data[0]->price->usd_per_month,2)}}</td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->cpu_cores / $server1_data[0]->price->usd_per_month, $server2_data[0]->yabs[0]->cpu_cores / $server2_data[0]->price->usd_per_month, '') !!}
                            <td class="td-nowrap">{{number_format($server2_data[0]->yabs[0]->cpu_cores / $server2_data[0]->price->usd_per_month,2)}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">Disk GB per USD</td>
                            <td class="td-nowrap">{{number_format($server1_data[0]->yabs[0]->disk_gb / $server1_data[0]->price->usd_per_month,2)}}</td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->disk_gb / $server1_data[0]->price->usd_per_month, $server2_data[0]->yabs[0]->disk_gb / $server2_data[0]->price->usd_per_month, '') !!}
                            <td class="td-nowrap">{{number_format($server2_data[0]->yabs[0]->disk_gb / $server2_data[0]->price->usd_per_month,2)}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">Ram MB per USD</td>
                            <td class="td-nowrap">{{number_format($server1_data[0]->yabs[0]->ram_mb / $server1_data[0]->price->usd_per_month,2)}}</td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->ram_mb / $server1_data[0]->price->usd_per_month, $server2_data[0]->yabs[0]->ram_mb / $server2_data[0]->price->usd_per_month, '') !!}
                            <td class="td-nowrap">{{number_format($server2_data[0]->yabs[0]->ram_mb / $server2_data[0]->price->usd_per_month,2)}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">GB5 single per USD</td>
                            <td class="td-nowrap">{{number_format($server1_data[0]->yabs[0]->gb5_single / $server1_data[0]->price->usd_per_month,2)}}</td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->gb5_single / $server1_data[0]->price->usd_per_month, $server2_data[0]->yabs[0]->gb5_single / $server2_data[0]->price->usd_per_month, '') !!}
                            <td class="td-nowrap">{{number_format($server2_data[0]->yabs[0]->gb5_single / $server2_data[0]->price->usd_per_month,2)}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">GB5 multi per USD</td>
                            <td class="td-nowrap">{{number_format($server1_data[0]->yabs[0]->gb5_multi / $server1_data[0]->price->usd_per_month,2)}}</td>
                            {!! \App\Models\Server::tableRowCompare($server1_data[0]->yabs[0]->gb5_multi / $server1_data[0]->price->usd_per_month, $server2_data[0]->yabs[0]->gb5_multi / $server2_data[0]->price->usd_per_month, '') !!}
                            <td class="td-nowrap">{{number_format($server2_data[0]->yabs[0]->gb5_multi / $server2_data[0]->price->usd_per_month,2)}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">Location</td>
                            <td class="td-nowrap">{{$server1_data[0]->location->name}}</td>
                            <td class="td-nowrap equal-td"></td>
                            <td class="td-nowrap">{{$server2_data[0]->location->name}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">Provider</td>
                            <td class="td-nowrap">{{$server1_data[0]->provider->name}}</td>
                            <td class="td-nowrap equal-td"></td>
                            <td class="td-nowrap">{{$server2_data[0]->provider->name}}</td>
                        </tr>
                        <tr>
                            <td class="td-nowrap">Owned since</td>
                            <td class="td-nowrap">{{ date_format(new DateTime($server1_data[0]->owned_since), 'F Y') }}</td>
                            <td class="td-nowrap equal-td">
                                {{\Carbon\Carbon::parse($server1_data[0]->owned_since)->diffForHumans(\Carbon\Carbon::parse($server2_data[0]->owned_since))}}
                            </td>
                            <td class="td-nowrap">{{ date_format(new DateTime($server2_data[0]->owned_since), 'F Y') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
