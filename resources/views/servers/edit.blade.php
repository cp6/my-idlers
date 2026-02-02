@section("title", "{$server_data->hostname} edit")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Edit {{ $server_data->hostname }}</h2>
            <div class="page-actions">
                <a href="{{ route('servers.index') }}" class="btn btn-outline-secondary">Back to servers</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('servers.update', $server_data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Hostname</label>
                            <input type="text" class="form-control" name="hostname" value="{{ $server_data->hostname }}">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Server Type</label>
                            <select class="form-select" name="server_type">
                                <option value="1" {{ $server_data->server_type === 1 ? 'selected' : '' }}>KVM</option>
                                <option value="2" {{ $server_data->server_type === 2 ? 'selected' : '' }}>OVZ</option>
                                <option value="3" {{ $server_data->server_type === 3 ? 'selected' : '' }}>DEDI</option>
                                <option value="4" {{ $server_data->server_type === 4 ? 'selected' : '' }}>LXC</option>
                                <option value="5" {{ $server_data->server_type === 5 ? 'selected' : '' }}>SEMI-DEDI</option>
                                <option value="6" {{ $server_data->server_type === 6 ? 'selected' : '' }}>VMware</option>
                                <option value="7" {{ $server_data->server_type === 7 ? 'selected' : '' }}>NAT</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Operating System</label>
                            <select class="form-select" name="os_id">
                                @foreach (App\Models\OS::all() as $os)
                                    <option value="{{ $os->id }}" {{ $server_data->os_id == $os->id ? 'selected' : '' }}>{{ $os->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Network -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Network</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">NS1</label>
                            <input type="text" class="form-control" name="ns1" value="{{ $server_data->ns1 }}" maxlength="255">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">NS2</label>
                            <input type="text" class="form-control" name="ns2" value="{{ $server_data->ns2 }}" maxlength="255">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">SSH Port</label>
                            <input type="number" class="form-control" name="ssh_port" value="{{ $server_data->ssh }}" min="1" max="65535">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Bandwidth (GB)</label>
                            <input type="number" class="form-control" name="bandwidth" value="{{ $server_data->bandwidth }}" min="0" max="999999">
                        </div>
                    </div>
                    @if(count($server_data->ips) > 0)
                    <div class="row g-3 mt-1">
                        @foreach($server_data->ips as $ip)
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">IP {{ $loop->iteration }}</label>
                            <input type="text" class="form-control" name="ip{{ $loop->iteration }}" value="{{ $ip['address'] }}" maxlength="255">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Specifications -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Specifications</h5>
                    <span class="text-muted small">YABS output will overwrite these values</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">CPU Cores</label>
                            <input type="number" class="form-control" name="cpu" value="{{ $server_data->cpu }}" min="1" max="128">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">RAM</label>
                            <input type="number" class="form-control" name="ram" value="{{ $server_data->ram }}" min="1" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">RAM Type</label>
                            <select class="form-select" name="ram_type">
                                <option value="MB" {{ $server_data->ram_type === 'MB' ? 'selected' : '' }}>MB</option>
                                <option value="GB" {{ $server_data->ram_type === 'GB' ? 'selected' : '' }}>GB</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Disk</label>
                            <input type="number" class="form-control" name="disk" value="{{ $server_data->disk }}" min="0" max="999999" step="0.1">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Disk Type</label>
                            <select class="form-select" name="disk_type">
                                <option value="GB" {{ $server_data->disk_type === 'GB' ? 'selected' : '' }}>GB</option>
                                <option value="TB" {{ $server_data->disk_type === 'TB' ? 'selected' : '' }}>TB</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4 col-lg-2">
                            <label class="form-label">Location</label>
                            <select class="form-select" name="location_id">
                                @foreach (App\Models\Locations::all() as $location)
                                    <option value="{{ $location->id }}" {{ $server_data->location_id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Billing</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Provider</label>
                            <select class="form-select" name="provider_id">
                                @foreach (App\Models\Providers::all() as $provider)
                                    <option value="{{ $provider->id }}" {{ $server_data->provider_id == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" value="{{ $server_data->price->price }}" min="0" max="99999" step="0.01" required>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Currency</label>
                            <select class="form-select" name="currency">
                                @foreach (App\Models\Pricing::getCurrencyList() as $currency)
                                    <option value="{{ $currency }}" {{ $server_data->price->currency == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label">Term</label>
                            <select class="form-select" name="payment_term">
                                <option value="1" {{ $server_data->price->term == 1 ? 'selected' : '' }}>Monthly</option>
                                <option value="2" {{ $server_data->price->term == 2 ? 'selected' : '' }}>Quarterly</option>
                                <option value="3" {{ $server_data->price->term == 3 ? 'selected' : '' }}>Half annual</option>
                                <option value="4" {{ $server_data->price->term == 4 ? 'selected' : '' }}>Annual</option>
                                <option value="5" {{ $server_data->price->term == 5 ? 'selected' : '' }}>Biennial</option>
                                <option value="6" {{ $server_data->price->term == 6 ? 'selected' : '' }}>Triennial</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Promo Price</label>
                            <select class="form-select" name="was_promo">
                                <option value="0" {{ $server_data->was_promo == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $server_data->was_promo == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Owned Since</label>
                            <input type="date" class="form-control" name="owned_since" value="{{ $server_data->owned_since }}">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Next Due Date</label>
                            <input type="date" class="form-control" name="next_due_date" value="{{ $server_data->price->next_due_date ?? Carbon\Carbon::now()->addMonth()->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Labels -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Labels</h5>
                    <span class="text-muted small">Optional</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @php $labels = App\Models\Labels::all(); @endphp
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 1</label>
                            <select class="form-select" name="label1">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ isset($server_data->labels[0]->label->id) && $server_data->labels[0]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 2</label>
                            <select class="form-select" name="label2">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ isset($server_data->labels[1]->label->id) && $server_data->labels[1]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 3</label>
                            <select class="form-select" name="label3">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ isset($server_data->labels[2]->label->id) && $server_data->labels[2]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 4</label>
                            <select class="form-select" name="label4">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ isset($server_data->labels[3]->label->id) && $server_data->labels[3]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options & Submit -->
            <div class="row mb-3">
                <div class="col-12 col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $server_data->active === 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">I still have this server</label>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="show_public" id="show_public" value="1" {{ $server_data->show_public === 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_public">Allow some of this data to be public</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Update Server</button>
        </form>
    </div>
</x-app-layout>
