@section('title') {{'Enter new server'}} @endsection
@section('scripts')
    <script src="{{ asset('js/vue.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
@endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a new server') }}
    </x-slot>
    <div class="container" id="app">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">Server information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('servers.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-errors-alert></x-errors-alert>
            <form action="{{ route('servers.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-lg-6 mb-4">
                        <input type="hidden" value="1" name="service_type">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Hostname</span></div>
                            <input type="text"
                                   class="form-control"
                                   name="hostname" id="hostname"
                                   placeholder="Enter server hostname">
                            @error('name') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                            <div class="input-group-append"><span class="input-group-text"><a id="fillIps" href="#"><i
                                            class="fas fa-search py-1" @click="onClk"
                                            title="Auto fill A and AAAA records"></i></a></span></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Type</span></div>
                            <select class="form-control" name="server_type">
                                <option value="1" selected>VPS</option>
                                <option value="2">Dedicated</option>
                                <option value="3">Semi Dedicated</option>
                                <option value="4">NAT</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">OS</span></div>
                            <select class="form-control" name="os_id">
                                @foreach ($Os as $oss)
                                    <option value="{{ $oss['id'] }}">
                                        {{ $oss['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <p class="text-muted">If you need to add more IPs go <a href="{{route('IPs.create')}}" class="text-decoration-none">here</a>.</p>
                    <div class="col-12 col-lg-3 mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">IP</span></div>
                            <input type="text" name="ip1" class="form-control" minlength="4"
                                   maxlength="255" v-model="ipv4_in">
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">IP</span></div>
                            <input type="text" name="ip2" class="form-control" minlength="4"
                                   maxlength="255" v-model="ipv6_in">
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS1</x-slot>
                            <x-slot name="name">ns1</x-slot>
                            <x-slot name="max">255</x-slot>
                        </x-text-input>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS2</x-slot>
                            <x-slot name="name">ns2</x-slot>
                            <x-slot name="max">255</x-slot>
                        </x-text-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-3 mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Virt</span></div>
                            <select class="form-control" name="virt">
                                <option value="1" selected="">KVM</option>
                                <option value="2">OVZ</option>
                                <option value="3">DEDI</option>
                                <option value="4">LXC</option>
                                <option value="5">SEMI-DEDI</option>
                            </select></div>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-number-input>
                            <x-slot name="title">SSH</x-slot>
                            <x-slot name="name">ssh_port</x-slot>
                            <x-slot name="value">22</x-slot>
                            <x-slot name="max">999999</x-slot>
                            <x-slot name="step">1</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-number-input>
                            <x-slot name="title">Bandwidth GB</x-slot>
                            <x-slot name="name">bandwidth</x-slot>
                            <x-slot name="value">1000</x-slot>
                            <x-slot name="max">99999</x-slot>
                            <x-slot name="step">1</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-yes-no-select>
                            <x-slot name="title">Promo price</x-slot>
                            <x-slot name="name">was_promo</x-slot>
                            <x-slot name="value">1</x-slot>
                        </x-yes-no-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <x-providers-select>
                            <x-slot name="current">1</x-slot>
                        </x-providers-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-number-input>
                            <x-slot name="title">Price</x-slot>
                            <x-slot name="name">price</x-slot>
                            <x-slot name="value">2.50</x-slot>
                            <x-slot name="max">9999</x-slot>
                            <x-slot name="step">0.01</x-slot>
                            <x-slot name="required"></x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-term-select></x-term-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-currency-select></x-currency-select>
                    </div>
                </div>
                <div class="row">
                    <p class="text-muted">Note adding a YABs output will overwrite Ram, disk and CPU.</p>
                    <div class="col-md-3 mb-3">
                        <x-number-input>
                            <x-slot name="title">Ram</x-slot>
                            <x-slot name="name">ram</x-slot>
                            <x-slot name="value">2024</x-slot>
                            <x-slot name="max">100000</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-ram-type-select>
                            <x-slot name="title">Ram type</x-slot>
                            <x-slot name="name">ram_type</x-slot>
                        </x-ram-type-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-number-input>
                            <x-slot name="title">Disk</x-slot>
                            <x-slot name="name">disk</x-slot>
                            <x-slot name="value">10</x-slot>
                            <x-slot name="max">99999</x-slot>
                            <x-slot name="step">0.1</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-ram-type-select>
                            <x-slot name="title">Disk type</x-slot>
                            <x-slot name="name">disk_type</x-slot>
                        </x-ram-type-select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-2 mb-3">
                        <x-number-input>
                            <x-slot name="title">CPU</x-slot>
                            <x-slot name="name">cpu</x-slot>
                            <x-slot name="value">2</x-slot>
                            <x-slot name="max">64</x-slot>
                            <x-slot name="step">1</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <x-locations-select>
                            <x-slot name="current">1</x-slot>
                        </x-locations-select>
                    </div>
                    <div class="col-12 col-md-3">
                        <x-date-input>
                            <x-slot name="title">Owned since</x-slot>
                            <x-slot name="name">owned_since</x-slot>
                            <x-slot name="value">{{Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}</x-slot>
                        </x-date-input>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <x-date-input>
                            <x-slot name="title">Next due date</x-slot>
                            <x-slot name="name">next_due_date</x-slot>
                            <x-slot name="value">{{Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}</x-slot>
                        </x-date-input>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label1</x-slot>
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label2</x-slot>
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label3</x-slot>
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label4</x-slot>
                        </x-labels-select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Insert server</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>

    <script>
        axios.defaults.headers.common = {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        };

        let app = new Vue({
            el: "#app",
            data: {
                "ipv4_in": '',
                "ipv6_in": ''
            },
            methods: {
                onClk(event) {
                    var hostname = document.getElementById('hostname').value;

                    if (hostname) {
                        axios
                            .get('/api/dns/' + hostname + '/A', {headers: {'Authorization': 'Bearer ' + document.querySelector('meta[name="api_token"]').getAttribute('content')}})
                            .then(response => (this.ipv4_in = response.data.ip));
                        axios
                            .get('/api/dns/' + hostname + '/AAAA', {headers: {'Authorization': 'Bearer ' + document.querySelector('meta[name="api_token"]').getAttribute('content')}})
                            .then(response => (this.ipv6_in = response.data.ip));
                    }
                }
            }
        });
    </script>
</x-app-layout>
