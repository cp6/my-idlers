@section("title", "{$server_data->hostname} server")
@section('scripts')
    <script>
        function showYabsCode() {
            const el = document.querySelector('#yabs_code');
            el.classList.toggle("d-none");
        }
    </script>
@endsection
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $server_data->hostname }}</h2>
                <div class="mt-2">
                    @foreach($server_data->labels as $label)
                        <span class="badge bg-primary">{{$label->label->label}}</span>
                    @endforeach
                    @if($server_data->active !== 1)
                        <span class="badge bg-danger">Not Active</span>
                    @endif
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('servers.index') }}" class="btn btn-outline-secondary">Back to servers</a>
                <a href="{{ route('servers.edit', $server_data->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="detail-card">
            <!-- Server & Specs Section -->
            <div class="detail-section">
                <div class="detail-grid">
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Server Details</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Type</span>
                                    <span class="detail-value">{{ $server_data->serviceServerType($server_data->server_type, false) }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">OS</span>
                                    <span class="detail-value">{{ $server_data->os->name }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Location</span>
                                    <span class="detail-value">{{ $server_data->location->name }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Provider</span>
                                    <span class="detail-value">{{ $server_data->provider->name }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Price</span>
                                    <span class="detail-value">{{ $server_data->price->price }} {{ $server_data->price->currency }} <span class="text-muted">{{ \App\Process::paymentTermIntToString($server_data->price->term) }}</span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Next Due</span>
                                    <span class="detail-value">{{ Carbon\Carbon::parse($server_data->price->next_due_date)->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Was Promo</span>
                                    <span class="detail-value">{{ ($server_data->was_promo === 1) ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Owned Since</span>
                                    <span class="detail-value">{{ $server_data->owned_since !== null ? date_format(new DateTime($server_data->owned_since), 'jS M Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Specifications</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">CPU</span>
                                    <span class="detail-value">{{ $server_data->cpu }} @if($server_data->has_yabs)<span class="text-muted">@ {{ $server_data->yabs[0]->cpu_freq }} MHz</span>@endif</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">RAM</span>
                                    <span class="detail-value">@if(isset($server_data->yabs[0]->ram)){{ $server_data->yabs[0]->ram }} {{ $server_data->yabs[0]->ram_type }}@else{{ $server_data->ram }} {{ $server_data->ram_type }}@endif</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Disk</span>
                                    <span class="detail-value">@if(isset($server_data->yabs[0]->disk)){{ $server_data->yabs[0]->disk }} {{ $server_data->yabs[0]->disk_type }}@else{{ $server_data->disk }} {{ $server_data->disk_type }}@endif</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Bandwidth</span>
                                    <span class="detail-value">{{ $server_data->bandwidth }} GB</span>
                                </div>
                            </div>
                            @foreach($server_data->ips as $ip)
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">{{ $ip['is_ipv4'] ? 'IPv4' : 'IPv6' }}</span>
                                    <span class="detail-value"><code>{{ $ip['address'] }}</code></span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @if($server_data->has_yabs)
            <!-- YABS Section -->
            <div class="detail-section">
                <div class="detail-grid">
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">YABS Benchmark</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">GB6 Single</span>
                                    <span class="detail-value">{{ $server_data->yabs[0]->gb6_single ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">GB6 Multi</span>
                                    <span class="detail-value">{{ $server_data->yabs[0]->gb6_multi ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">CPU Model</span>
                                    <span class="detail-value">{{ $server_data->yabs[0]->cpu_model }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">AES</span>
                                    <span class="detail-value">{{ ($server_data->yabs[0]->aes === 1) ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">VM</span>
                                    <span class="detail-value">{{ ($server_data->yabs[0]->vm === 1) ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Disk Speed</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">4K</span>
                                    <span class="detail-value">{{ $server_data->yabs[0]->disk_speed->d_4k }} <span class="text-muted">{{ $server_data->yabs[0]->disk_speed->d_4k_type }}</span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">64K</span>
                                    <span class="detail-value">{{ $server_data->yabs[0]->disk_speed->d_64k }} <span class="text-muted">{{ $server_data->yabs[0]->disk_speed->d_64k_type }}</span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">512K</span>
                                    <span class="detail-value">{{ $server_data->yabs[0]->disk_speed->d_512k }} <span class="text-muted">{{ $server_data->yabs[0]->disk_speed->d_512k_type }}</span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">1M</span>
                                    <span class="detail-value">{{ $server_data->yabs[0]->disk_speed->d_1m }} <span class="text-muted">{{ $server_data->yabs[0]->disk_speed->d_1m_type }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Network Speed Section -->
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
                    @foreach($server_data->yabs[0]->network_speed as $ns)
                        <tr>
                            <td>{{ $ns->location }}</td>
                            <td>{{ $ns->send }} <span class="text-muted">{{ $ns->send_type }}</span></td>
                            <td>{{ $ns->receive }} <span class="text-muted">{{ $ns->receive_type }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <!-- Add YABS Section -->
            <div class="detail-section">
                <div class="detail-section-header">
                    <h6 class="detail-section-title">YABS Benchmark</h6>
                </div>
                <p class="mb-3">Run this command on your server to add YABS benchmark data:</p>
                <div class="yabs-command">
                    <code>curl -sL yabs.sh | bash -s -- -s "{{ route('api.store-yabs', [$server_data->id, \Illuminate\Support\Facades\Auth::user()->api_token]) }}"</code>
                </div>
            </div>
            @endif

            @if(isset($server_data->note))
            <!-- Note Section -->
            <div class="detail-section">
                <div class="detail-section-header">
                    <h6 class="detail-section-title">Note</h6>
                </div>
                <div class="detail-note">{{ $server_data->note->note }}</div>
            </div>
            @endif

            <!-- Footer -->
            <div class="detail-footer">
                ID: <code>{{ $server_data->id }}</code> &middot;
                Created: {{ $server_data->created_at !== null ? date_format(new DateTime($server_data->created_at), 'jS M Y, g:i a') : '-' }} &middot;
                Updated: {{ $server_data->updated_at !== null ? date_format(new DateTime($server_data->updated_at), 'jS M Y, g:i a') : '-' }}
            </div>
        </div>

        @if($server_data->has_yabs)
        <div class="mt-3">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="showYabsCode()">Show YABS command</button>
            <div id="yabs_code" class="d-none mt-2 yabs-command">
                <code>curl -sL yabs.sh | bash -s -- -s "{{ route('api.store-yabs', [$server_data->id, \Illuminate\Support\Facades\Auth::user()->api_token]) }}"</code>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
