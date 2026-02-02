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

        <div class="detail-card">
            <div class="detail-section">
                <div class="detail-grid">
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">System Info</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">Server</span>
                                    <span class="detail-value"><a href="{{ route('servers.show', $yabs->server_id) }}">{{ $yabs->server->hostname }}</a></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Uptime</span>
                                    <span class="detail-value">{{ $yabs->uptime }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Distro</span>
                                    <span class="detail-value">{{ $yabs->distro }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">CPU Model</span>
                                    <span class="detail-value">{{ $yabs->cpu_model }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">CPU</span>
                                    <span class="detail-value">{{ $yabs->cpu_cores }} @ {{ $yabs->cpu_freq }} MHz</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">RAM</span>
                                    <span class="detail-value">{{ $yabs->ram }} {{ $yabs->ram_type }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Swap</span>
                                    <span class="detail-value">{{ $yabs->swap }} {{ $yabs->swap_type }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Disk</span>
                                    <span class="detail-value">{{ $yabs->disk }} {{ $yabs->disk_type }}</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="detail-item">
                                    <span class="detail-label">IPv6</span>
                                    <span class="detail-value">{{ $yabs->has_ipv6 === 1 ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="detail-item">
                                    <span class="detail-label">AES</span>
                                    <span class="detail-value">{{ $yabs->aes === 1 ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="detail-item">
                                    <span class="detail-label">VM</span>
                                    <span class="detail-value">{{ $yabs->vm === 1 ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Geekbench 5</h6>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Single Core</span>
                                    <span class="detail-value">@if($yabs->gb5_id)<a href="https://browser.geekbench.com/v5/cpu/{{ $yabs->gb5_id }}">{{ $yabs->gb5_single }}</a>@else {{ $yabs->gb5_single }} @endif</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Multi Core</span>
                                    <span class="detail-value">@if($yabs->gb5_id)<a href="https://browser.geekbench.com/v5/cpu/{{ $yabs->gb5_id }}">{{ $yabs->gb5_multi }}</a>@else {{ $yabs->gb5_multi }} @endif</span>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Disk Speed</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">4K</span>
                                    <span class="detail-value">{{ $yabs->disk_speed->d_4k }} <span class="text-muted">{{ $yabs->disk_speed->d_4k_type }}</span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">64K</span>
                                    <span class="detail-value">{{ $yabs->disk_speed->d_64k }} <span class="text-muted">{{ $yabs->disk_speed->d_64k_type }}</span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">512K</span>
                                    <span class="detail-value">{{ $yabs->disk_speed->d_512k }} <span class="text-muted">{{ $yabs->disk_speed->d_512k_type }}</span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">1M</span>
                                    <span class="detail-value">{{ $yabs->disk_speed->d_1m }} <span class="text-muted">{{ $yabs->disk_speed->d_1m_type }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-section-header">
                    <h6 class="detail-section-title">Network Speed</h6>
                </div>
                <table class="network-table">
                    <thead>
                        <tr>
                            <th>Location</th>
                            <th>Send</th>
                            <th>Receive</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($yabs->network_speed as $speed_test)
                        <tr>
                            <td>{{ $speed_test->location }}</td>
                            <td>{{ $speed_test->send }} <span class="text-muted">{{ $speed_test->send_type }}</span></td>
                            <td>{{ $speed_test->receive }} <span class="text-muted">{{ $speed_test->receive_type }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="detail-footer">
                Test ran: {{ $yabs->output_date !== null ? date_format(new DateTime($yabs->output_date), 'g:ia D jS F Y') : '-' }}
            </div>
        </div>
    </div>
</x-app-layout>
