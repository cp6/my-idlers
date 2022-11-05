@section("title", "{$yabs->hostname} {$yabs->id} YABS")
<x-app-layout>
    <x-slot name="header">
        {{ __('YABS details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <x-back-btn>
                <x-slot name="route">{{ route('yabs.index') }}</x-slot>
            </x-back-btn>
                <div class="row">
                    <div class="'col-12 col-lg-6">
                        <div class="table-responsive">
                            <table class="table table-borderless text-nowrap">
                                <tbody>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Server</td>
                                    <td><a href="{{route('servers.show', ['server' => $yabs->server_id])}}" class="text-decoration-none">{{ $yabs->server->hostname }}</a></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Uptime</td>
                                    <td>{{ $yabs->uptime }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Distro</td>
                                    <td>{{ $yabs->distro }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">CPU</td>
                                    <td>{{ $yabs->cpu_cores }} @ {{$yabs->cpu_freq}} Mhz</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">CPU type</td>
                                    <td>{{ $yabs->cpu_model }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">RAM</td>
                                    <td>{{ $yabs->ram }} {{$yabs->ram_type}}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Swap</td>
                                    <td>{{ $yabs->swap }} {{$yabs->swap_type}}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Disk</td>
                                    <td>{{ $yabs->disk }} {{$yabs->disk_type}}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Has IPv6</td>
                                    <td>
                                        @if($yabs->has_ipv6 === 1)
                                            <span class="text-success">Yes</span>
                                        @else
                                            <span class="text-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">AES</td>
                                    <td>
                                        @if($yabs->aes === 1)
                                            <span class="text-success">Yes</span>
                                        @else
                                            <span class="text-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">VM</td>
                                    <td>
                                        @if($yabs->vm === 1)
                                            <span class="text-success">Yes</span>
                                        @else
                                            <span class="text-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">GB5 Single</td>
                                    <td><a href="https://browser.geekbench.com/v5/cpu/{{$yabs->gb5_id}}"
                                           class="text-decoration-none">{{ $yabs->gb5_single }}</a></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">GB5 Multi</td>
                                    <td><a href="https://browser.geekbench.com/v5/cpu/{{$yabs->gb5_id}}"
                                           class="text-decoration-none">{{ $yabs->gb5_multi }}</a></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Test ran</td>
                                    <td>
                                        @if(!is_null($yabs->output_date))
                                            {{date_format(new DateTime($yabs->output_date), 'g:ia D jS F Y')}}
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="'col-12 col-lg-6">
                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <td class="py-2">Disk speeds:</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2"><b>4k</b> {{$yabs->disk_speed->d_4k}}
                                    <small>{{$yabs->disk_speed->d_4k_type}}</small></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2"><b>64k</b> {{$yabs->disk_speed->d_64k}}
                                    <small>{{$yabs->disk_speed->d_64k_type}}</small></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2"><b>512k</b> {{$yabs->disk_speed->d_512k}}
                                    <small>{{$yabs->d_512k_type}}</small></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2"><b>1m</b> {{$yabs->disk_speed->d_1m}} <small>{{$yabs->disk_speed->d_1m_type}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2">Network speed (location|send|receive):</td>
                            </tr>
                            @foreach($yabs->network_speed as $speed_test)
                                <tr>
                                    <td class="px-4 py-2 text-nowrap">
                                        <b>{{$speed_test->location}}</b> {{$speed_test->send}}
                                        <small>{{$speed_test->send_type}}</small>, {{$speed_test->receive}}
                                        <small>{{$speed_test->receive_type}}</small></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </x-card>
              <x-details-footer></x-details-footer>
    </div>
</x-app-layout>
