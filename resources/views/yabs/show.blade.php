@section('title') {{$yab[0]->hostname}} {{$yab[0]->id}} {{'YABs'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('YABs details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <x-back-button>
                <x-slot name="href">{{ route('yabs.index') }}</x-slot>
                Go back
            </x-back-button>
                <div class="row">
                    <div class="'col-12 col-lg-6">
                        <div class="table-responsive">
                            <table class="table table-borderless text-nowrap">
                                <tbody>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Server</td>
                                    <td><a href="{{route('servers.show', ['server' => $yab[0]->server_id])}}" class="text-decoration-none">{{ $yab[0]->hostname }}</a></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">CPU</td>
                                    <td>{{ $yab[0]->cpu_cores }} @ {{$yab[0]->cpu_freq}} Ghz</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">CPU type</td>
                                    <td>{{ $yab[0]->cpu }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Ram</td>
                                    <td>{{ $yab[0]->ram }} {{$yab[0]->ram_type}}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Disk</td>
                                    <td>{{ $yab[0]->disk }} {{$yab[0]->disk_type}}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Has IPv6</td>
                                    <td>
                                        @if($yab[0]->has_ipv6 === 1)
                                            <span class="text-success">Yes</span>
                                        @else
                                            <span class="text-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">AES</td>
                                    <td>
                                        @if($yab[0]->aes === 1)
                                            <span class="text-success">Yes</span>
                                        @else
                                            <span class="text-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">VM</td>
                                    <td>
                                        @if($yab[0]->vm === 1)
                                            <span class="text-success">Yes</span>
                                        @else
                                            <span class="text-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">GB5 Single</td>
                                    <td><a href="https://browser.geekbench.com/v5/cpu/{{$yab[0]->gb5_id}}"
                                           class="text-decoration-none">{{ $yab[0]->gb5_single }}</a></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">GB5 Multi</td>
                                    <td><a href="https://browser.geekbench.com/v5/cpu/{{$yab[0]->gb5_id}}"
                                           class="text-decoration-none">{{ $yab[0]->gb5_multi }}</a></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Tested</td>
                                    <td>
                                        @if(!is_null($yab[0]->output_date))
                                            {{date_format(new DateTime($yab[0]->output_date), 'jS F Y')}}
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
                                <td class="px-4 py-2"><b>4k</b> {{$yab[0]->d_4k}}
                                    <small>{{$yab[0]->d_4k_type}}</small></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2"><b>64k</b> {{$yab[0]->d_64k}}
                                    <small>{{$yab[0]->d_64k_type}}</small></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2"><b>512k</b> {{$yab[0]->d_512k}}
                                    <small>{{$yab[0]->d_512k_type}}</small></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2"><b>1m</b> {{$yab[0]->d_1m}} <small>{{$yab[0]->d_1m_type}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2">Network speed (location|send|receive):</td>
                            </tr>
                            @foreach($network as $speed_test)
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
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>
                    Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}
                    )</small>
            </p>
        @endif
    </div>
</x-app-layout>
