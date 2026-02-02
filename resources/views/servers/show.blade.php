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

        <div class="card content-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-muted" style="width: 40%;">Type</td>
                                <td class="px-2 py-2">{{ $server_data->serviceServerType($server_data->server_type, false) }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">OS</td>
                                <td class="px-2 py-2">{{ $server_data->os->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Location</td>
                                <td class="px-2 py-2">{{ $server_data->location->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Provider</td>
                                <td class="px-2 py-2">{{ $server_data->provider->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Price</td>
                                <td class="px-2 py-2">
                                    {{ $server_data->price->price }} {{ $server_data->price->currency }}
                                    <small class="text-muted">{{ \App\Process::paymentTermIntToString($server_data->price->term) }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Next Due Date</td>
                                <td class="px-2 py-2">
                                    {{ Carbon\Carbon::parse($server_data->price->next_due_date)->diffForHumans() }}
                                    <small class="text-muted">({{ Carbon\Carbon::parse($server_data->price->next_due_date)->format('d/m/Y') }})</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Was Promo</td>
                                <td class="px-2 py-2">{{ ($server_data->was_promo === 1) ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Owned Since</td>
                                <td class="px-2 py-2">
                                    @if($server_data->owned_since !== null)
                                        {{ date_format(new DateTime($server_data->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-muted" style="width: 40%;">CPU</td>
                                <td class="px-2 py-2">
                                    {{ $server_data->cpu }}
                                    @if($server_data->has_yabs)
                                        <small class="text-muted">@ {{ $server_data->yabs[0]->cpu_freq }} MHz</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">RAM</td>
                                <td class="px-2 py-2">
                                    @if(isset($server_data->yabs[0]->ram))
                                        {{ $server_data->yabs[0]->ram }} {{ $server_data->yabs[0]->ram_type }}
                                    @else
                                        {{ $server_data->ram }} {{ $server_data->ram_type }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Disk</td>
                                <td class="px-2 py-2">
                                    @if(isset($server_data->yabs[0]->disk))
                                        {{ $server_data->yabs[0]->disk }} {{ $server_data->yabs[0]->disk_type }}
                                    @else
                                        {{ $server_data->disk }} {{ $server_data->disk_type }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Bandwidth</td>
                                <td class="px-2 py-2">{{ $server_data->bandwidth }} GB</td>
                            </tr>
                            @foreach($server_data->ips as $ip)
                                <tr>
                                    <td class="px-2 py-2 text-muted">{{ $ip['is_ipv4'] ? 'IPv4' : 'IPv6' }}</td>
                                    <td class="px-2 py-2"><code>{{ $ip['address'] }}</code></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($server_data->has_yabs)
                <hr class="my-3">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <h6 class="text-muted mb-3">YABS Benchmark</h6>
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-muted" style="width: 40%;">GB6 S/M</td>
                                <td class="px-2 py-2">{{ $server_data->yabs[0]->gb6_single ?? '-' }} / {{ $server_data->yabs[0]->gb6_multi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">CPU Model</td>
                                <td class="px-2 py-2">{{ $server_data->yabs[0]->cpu_model }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">AES / VM</td>
                                <td class="px-2 py-2">{{ ($server_data->yabs[0]->aes === 1) ? 'Yes' : 'No' }} / {{ ($server_data->yabs[0]->vm === 1) ? 'Yes' : 'No' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 col-lg-6">
                        <h6 class="text-muted mb-3">Disk Speed</h6>
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-muted" style="width: 40%;">4K</td>
                                <td class="px-2 py-2">{{ $server_data->yabs[0]->disk_speed->d_4k }} <small class="text-muted">{{ $server_data->yabs[0]->disk_speed->d_4k_type }}</small></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">64K</td>
                                <td class="px-2 py-2">{{ $server_data->yabs[0]->disk_speed->d_64k }} <small class="text-muted">{{ $server_data->yabs[0]->disk_speed->d_64k_type }}</small></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">512K</td>
                                <td class="px-2 py-2">{{ $server_data->yabs[0]->disk_speed->d_512k }} <small class="text-muted">{{ $server_data->yabs[0]->disk_speed->d_512k_type }}</small></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">1M</td>
                                <td class="px-2 py-2">{{ $server_data->yabs[0]->disk_speed->d_1m }} <small class="text-muted">{{ $server_data->yabs[0]->disk_speed->d_1m_type }}</small></td>
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
                        @foreach($server_data->yabs[0]->network_speed as $ns)
                            <tr>
                                <td class="px-2 py-2">{{ $ns->location }}</td>
                                <td class="px-2 py-2">{{ $ns->send }} <small class="text-muted">{{ $ns->send_type }}</small></td>
                                <td class="px-2 py-2">{{ $ns->receive }} <small class="text-muted">{{ $ns->receive_type }}</small></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <hr class="my-3">
                <p class="mb-2">Run this command on your server to add YABS benchmark data:</p>
                <code>curl -sL yabs.sh | bash -s -- -s "{{ route('api.store-yabs', [$server_data->id, \Illuminate\Support\Facades\Auth::user()->api_token]) }}"</code>
                @endif

                @if(isset($server_data->note))
                <hr class="my-3">
                <h6 class="text-muted mb-2">Note</h6>
                <p class="mb-0">{{ $server_data->note->note }}</p>
                @endif

                <hr class="my-3">
                <div class="row">
                    <div class="col-12">
                        <small class="text-muted">
                            ID: <code>{{ $server_data->id }}</code> |
                            Created: {{ $server_data->created_at !== null ? date_format(new DateTime($server_data->created_at), 'jS M Y, g:i a') : '-' }} |
                            Updated: {{ $server_data->updated_at !== null ? date_format(new DateTime($server_data->updated_at), 'jS M Y, g:i a') : '-' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        @if($server_data->has_yabs)
        <div class="mt-3">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="showYabsCode()">Show YABS command</button>
            <p id="yabs_code" class="d-none mt-2"><code>curl -sL yabs.sh | bash -s -- -s "{{ route('api.store-yabs', [$server_data->id, \Illuminate\Support\Facades\Auth::user()->api_token]) }}"</code></p>
        </div>
        @endif
    </div>
</x-app-layout>
