@section("title", "{$yabs->hostname} {$yabs->id} YABS")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">YABS: {{ $yabs->server->hostname }}</h2>
            </div>
            <div class="page-actions">
                <a href="{{ route('yabs.index') }}" class="btn btn-outline-secondary">Back to YABS</a>
                <a href="{{ route('servers.show', $yabs->server_id) }}" class="btn btn-primary">View Server</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="card content-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-muted" style="width: 40%;">Server</td>
                                <td class="px-2 py-2">
                                    <a href="{{ route('servers.show', $yabs->server_id) }}" class="text-decoration-none">{{ $yabs->server->hostname }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Uptime</td>
                                <td class="px-2 py-2">{{ $yabs->uptime }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Distro</td>
                                <td class="px-2 py-2">{{ $yabs->distro }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">CPU</td>
                                <td class="px-2 py-2">{{ $yabs->cpu_cores }} @ {{ $yabs->cpu_freq }} MHz</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">CPU Model</td>
                                <td class="px-2 py-2">{{ $yabs->cpu_model }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">RAM</td>
                                <td class="px-2 py-2">{{ $yabs->ram }} {{ $yabs->ram_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Swap</td>
                                <td class="px-2 py-2">{{ $yabs->swap }} {{ $yabs->swap_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Disk</td>
                                <td class="px-2 py-2">{{ $yabs->disk }} {{ $yabs->disk_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Has IPv6</td>
                                <td class="px-2 py-2">{{ $yabs->has_ipv6 === 1 ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">AES / VM</td>
                                <td class="px-2 py-2">{{ $yabs->aes === 1 ? 'Yes' : 'No' }} / {{ $yabs->vm === 1 ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Test Ran</td>
                                <td class="px-2 py-2">
                                    @if($yabs->output_date !== null)
                                        {{ date_format(new DateTime($yabs->output_date), 'g:ia D jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 col-lg-6">
                        <h6 class="text-muted mb-3">Geekbench 5</h6>
                        <table class="table table-borderless mb-3">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-muted" style="width: 40%;">Single Core</td>
                                <td class="px-2 py-2">
                                    @if($yabs->gb5_id)
                                        <a href="https://browser.geekbench.com/v5/cpu/{{ $yabs->gb5_id }}" class="text-decoration-none">{{ $yabs->gb5_single }}</a>
                                    @else
                                        {{ $yabs->gb5_single }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Multi Core</td>
                                <td class="px-2 py-2">
                                    @if($yabs->gb5_id)
                                        <a href="https://browser.geekbench.com/v5/cpu/{{ $yabs->gb5_id }}" class="text-decoration-none">{{ $yabs->gb5_multi }}</a>
                                    @else
                                        {{ $yabs->gb5_multi }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <h6 class="text-muted mb-3">Disk Speed</h6>
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-muted" style="width: 40%;">4K</td>
                                <td class="px-2 py-2">{{ $yabs->disk_speed->d_4k }} <small class="text-muted">{{ $yabs->disk_speed->d_4k_type }}</small></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">64K</td>
                                <td class="px-2 py-2">{{ $yabs->disk_speed->d_64k }} <small class="text-muted">{{ $yabs->disk_speed->d_64k_type }}</small></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">512K</td>
                                <td class="px-2 py-2">{{ $yabs->disk_speed->d_512k }} <small class="text-muted">{{ $yabs->disk_speed->d_512k_type }}</small></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">1M</td>
                                <td class="px-2 py-2">{{ $yabs->disk_speed->d_1m }} <small class="text-muted">{{ $yabs->disk_speed->d_1m_type }}</small></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="my-3">
                <h6 class="text-muted mb-3">Network Speed</h6>
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th class="px-2 py-2 text-muted">Location</th>
                                <th class="px-2 py-2 text-muted">Send</th>
                                <th class="px-2 py-2 text-muted">Receive</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($yabs->network_speed as $speed_test)
                            <tr>
                                <td class="px-2 py-2">{{ $speed_test->location }}</td>
                                <td class="px-2 py-2">{{ $speed_test->send }} <small class="text-muted">{{ $speed_test->send_type }}</small></td>
                                <td class="px-2 py-2">{{ $speed_test->receive }} <small class="text-muted">{{ $speed_test->receive_type }}</small></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
