@section("title", "Add a server")
<x-app-layout>
    <div class="container" id="app">
        <div class="page-header">
            <h2 class="page-title">Add Server</h2>
            <div class="page-actions">
                <a href="{{ route('servers.index') }}" class="btn btn-outline-secondary">Back to servers</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('servers.store') }}" method="POST">
            @csrf

            <!-- Basic Information -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Hostname</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="hostname" id="hostname" 
                                       placeholder="server.example.com">
                                <button type="button" class="btn btn-outline-secondary" @click="fetchDnsRecords" title="Auto fill IPs from DNS">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            @error('hostname') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Server Type</label>
                            <select class="form-select" name="server_type">
                                <option value="1" selected>KVM</option>
                                <option value="2">OVZ</option>
                                <option value="3">DEDI</option>
                                <option value="4">LXC</option>
                                <option value="5">SEMI-DEDI</option>
                                <option value="6">VMware</option>
                                <option value="7">NAT</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Operating System</label>
                            <select class="form-select" name="os_id">
                                @foreach (App\Models\OS::all() as $os)
                                    <option value="{{ $os->id }}" {{ Session::get('default_server_os') == $os->id ? 'selected' : '' }}>
                                        {{ $os->name }}
                                    </option>
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
                    <span class="text-muted small">Additional IPs can be added after creation</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">IP Address 1</label>
                            <input type="text" class="form-control" name="ip1" minlength="4" maxlength="255" 
                                   v-model="ipv4_in" placeholder="IPv4 or IPv6">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">IP Address 2</label>
                            <input type="text" class="form-control" name="ip2" minlength="4" maxlength="255" 
                                   v-model="ipv6_in" placeholder="IPv4 or IPv6">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">NS1</label>
                            <input type="text" class="form-control" name="ns1" maxlength="255">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">NS2</label>
                            <input type="text" class="form-control" name="ns2" maxlength="255">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">SSH Port</label>
                            <input type="number" class="form-control" name="ssh_port" value="22" min="1" max="65535">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Bandwidth (GB)</label>
                            <input type="number" class="form-control" name="bandwidth" value="1000" min="0" max="999999">
                        </div>
                    </div>
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
                            <input type="number" class="form-control" name="cpu" value="2" min="1" max="128">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">RAM (MB)</label>
                            <input type="number" class="form-control" name="ram" value="2048" min="1" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">RAM Type</label>
                            <select class="form-select" name="ram_type">
                                <option value="MB" selected>MB</option>
                                <option value="GB">GB</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Disk</label>
                            <input type="number" class="form-control" name="disk" value="20" min="0" max="999999" step="0.1">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Disk Type</label>
                            <select class="form-select" name="disk_type">
                                <option value="GB" selected>GB</option>
                                <option value="TB">TB</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4 col-lg-2">
                            <label class="form-label">Location</label>
                            <select class="form-select" name="location_id">
                                @foreach (App\Models\Locations::all() as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
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
                                    <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" value="5.00" min="0" max="99999" step="0.01" required>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Currency</label>
                            <select class="form-select" name="currency">
                                @foreach (App\Models\Pricing::getCurrencyList() as $currency)
                                    <option value="{{ $currency }}" {{ Session::get('default_currency') == $currency ? 'selected' : '' }}>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label">Term</label>
                            <select class="form-select" name="payment_term">
                                <option value="1">Monthly</option>
                                <option value="2">Quarterly</option>
                                <option value="3">Half annual</option>
                                <option value="4">Annual</option>
                                <option value="5">Biennial</option>
                                <option value="6">Triennial</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Promo Price</label>
                            <select class="form-select" name="was_promo">
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Owned Since</label>
                            <input type="date" class="form-control" name="owned_since" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Next Due Date</label>
                            <input type="date" class="form-control" name="next_due_date" value="{{ Carbon\Carbon::now()->addMonth()->format('Y-m-d') }}">
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
                                    <option value="{{ $label->id }}">{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 2</label>
                            <select class="form-select" name="label2">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}">{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 3</label>
                            <select class="form-select" name="label3">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}">{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 4</label>
                            <select class="form-select" name="label4">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}">{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options & Submit -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="show_public" id="show_public" value="1">
                <label class="form-check-label" for="show_public">
                    Allow this server to be shown publicly (configure visible fields in settings)
                </label>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Add Server</button>
        </form>
    </div>

    @section('scripts')
    <script>
        window.addEventListener('load', function () {
            axios.defaults.headers.common = {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            };

            let app = new Vue({
                el: "#app",
                data: {
                    ipv4_in: '',
                    ipv6_in: ''
                },
                methods: {
                    fetchDnsRecords(event) {
                        var hostname = document.getElementById('hostname').value;
                        if (hostname) {
                            axios
                                .get('/api/dns/' + hostname + '/A', {
                                    headers: {'Authorization': 'Bearer ' + document.querySelector('meta[name="api_token"]').getAttribute('content')}
                                })
                                .then(response => (this.ipv4_in = response.data.ip));
                            axios
                                .get('/api/dns/' + hostname + '/AAAA', {
                                    headers: {'Authorization': 'Bearer ' + document.querySelector('meta[name="api_token"]').getAttribute('content')}
                                })
                                .then(response => (this.ipv6_in = response.data.ip));
                        }
                    }
                }
            });
        });
    </script>
    @endsection
</x-app-layout>
