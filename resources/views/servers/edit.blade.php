@section("title", "{$server_data->hostname} edit")
<x-app-layout>
    <x-slot name="header">
        Edit {{ $server_data->hostname }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">Server information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('servers.index') }}</x-slot>
                Back to servers
            </x-back-button>
            <x-response-alerts></x-response-alerts>
            <form action="{{ route('servers.update', $server_data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mt-3">
                    <div class="col-12 col-lg-6 mb-4">
                        <x-text-input title="Hostname" name="hostname" value="{{ $server_data->hostname }}"></x-text-input>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Server type</span></div>
                            <select class="form-control" name="server_type">
                                <option value="1" {{ ($server_data->server_type === 1) ? 'selected' : '' }}>KVM
                                </option>
                                <option value="2" {{ ($server_data->server_type === 2) ? 'selected' : '' }}>OVZ
                                </option>
                                <option value="3" {{ ($server_data->server_type === 3) ? 'selected' : '' }}>DEDI
                                </option>
                                <option value="4" {{ ($server_data->server_type === 4) ? 'selected' : '' }}>LXC
                                </option>
                                <option value="5" {{ ($server_data->server_type === 5) ? 'selected' : '' }}>
                                    SEMI-DEDI
                                </option>
                                <option value="6" {{ ($server_data->server_type === 6) ? 'selected' : '' }}>
                                    VMware
                                </option>
                                <option value="7" {{ ($server_data->server_type === 7) ? 'selected' : '' }}>
                                    NAT
                                </option>
                                <option value="7" {{ ($server_data->server_type === 8) ? 'selected' : '' }}>
                                    COLO
                                </option>
                            </select></div>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-os-select>
                            <x-slot name="current">{{$server_data->os_id}}</x-slot>
                        </x-os-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-2 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS1</x-slot>
                            <x-slot name="name">ns1</x-slot>
                            <x-slot name="max">255</x-slot>
                            <x-slot name="value">{{ $server_data->ns1 }}</x-slot>
                        </x-text-input>
                    </div>
                    <div class="col-12 col-lg-2 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS2</x-slot>
                            <x-slot name="name">ns2</x-slot>
                            <x-slot name="max">255</x-slot>
                            <x-slot name="value">{{ $server_data->ns2 }}</x-slot>
                        </x-text-input>
                    </div>
                    <div class="col-12 col-lg-2 mb-4">
                        <x-number-input>
                            <x-slot name="title">SSH</x-slot>
                            <x-slot name="name">ssh_port</x-slot>
                            <x-slot name="value">22</x-slot>
                            <x-slot name="max">999999</x-slot>
                            <x-slot name="step">1</x-slot>
                            <x-slot name="value">{{ $server_data->ssh }}</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-number-input>
                            <x-slot name="title">Bandwidth GB</x-slot>
                            <x-slot name="name">bandwidth</x-slot>
                            <x-slot name="value">1000</x-slot>
                            <x-slot name="max">99999</x-slot>
                            <x-slot name="step">1</x-slot>
                            <x-slot name="value">{{ $server_data->bandwidth }}</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-12 col-lg-2 mb-4">
                        <x-yes-no-select>
                            <x-slot name="title">Promo price</x-slot>
                            <x-slot name="name">was_promo</x-slot>
                            <x-slot name="value">{{ $server_data->was_promo }}</x-slot>
                        </x-yes-no-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <x-providers-select>
                            <x-slot name="current">{{$server_data->provider_id}}</x-slot>
                        </x-providers-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-number-input>
                            <x-slot name="title">Price</x-slot>
                            <x-slot name="name">price</x-slot>
                            <x-slot name="value">{{$server_data->price->price}}</x-slot>
                            <x-slot name="max">9999</x-slot>
                            <x-slot name="step">0.01</x-slot>
                            <x-slot name="required"></x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-term-select>
                            <x-slot name="current">{{$server_data->price->term}}</x-slot>
                        </x-term-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-currency-select>
                            <x-slot name="current">{{$server_data->price->currency}}</x-slot>
                        </x-currency-select>
                    </div>
                </div>
                <div class="row">
                    <p class="text-muted">Note adding a YABS output will overwrite RAM, disk and CPU.</p>
                    <div class="col-12 col-md-2 mb-3">
                        <x-number-input>
                            <x-slot name="title">CPU</x-slot>
                            <x-slot name="name">cpu</x-slot>
                            <x-slot name="value">{{$server_data->cpu}}</x-slot>
                            <x-slot name="max">64</x-slot>
                            <x-slot name="step">1</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-md-2 mb-3">
                        <x-number-input>
                            <x-slot name="title">RAM</x-slot>
                            <x-slot name="name">ram</x-slot>
                            <x-slot name="value">{{$server_data->ram}}</x-slot>
                            <x-slot name="max">100000</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-md-2 mb-3">
                        <x-ram-type-select>
                            <x-slot name="title">RAM type</x-slot>
                            <x-slot name="name">ram_type</x-slot>
                            <x-slot name="value">{{$server_data->ram_type}}</x-slot>
                        </x-ram-type-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-number-input>
                            <x-slot name="title">Disk</x-slot>
                            <x-slot name="name">disk</x-slot>
                            <x-slot name="value">{{$server_data->disk}}</x-slot>
                            <x-slot name="max">99999</x-slot>
                            <x-slot name="step">0.1</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-disk-type-select>
                            <x-slot name="title">Disk type</x-slot>
                            <x-slot name="name">disk_type</x-slot>
                            <x-slot name="value">{{$server_data->disk_type}}</x-slot>
                        </x-disk-type-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <x-locations-select>
                            <x-slot name="current">{{$server_data->location_id}}</x-slot>
                        </x-locations-select>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <x-date-input>
                            <x-slot name="title">Owned since</x-slot>
                            <x-slot name="name">owned_since</x-slot>
                            <x-slot name="value">{{$server_data->owned_since }}</x-slot>
                        </x-date-input>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <x-date-input>
                            <x-slot name="title">Next due date</x-slot>
                            <x-slot name="name">next_due_date</x-slot>
                            <x-slot name="value">
                                @if(isset($server_data->price->next_due_date))
                                    {{$server_data->price->next_due_date}}
                                @else
                                    {{\Carbon\Carbon::now()->addMonth(1)->format('Y-m-d')}}
                                @endif
                            </x-slot>
                        </x-date-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label1</x-slot>
                            @if(isset($server_data->labels[0]->label->id))
                                <x-slot name="current">{{$server_data->labels[0]->label->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label2</x-slot>
                            @if(isset($server_data->labels[1]->label->id))
                                <x-slot name="current">{{$server_data->labels[1]->label->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label3</x-slot>
                            @if(isset($server_data->labels[2]->label->id))
                                <x-slot name="current">{{$server_data->labels[2]->label->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label4</x-slot>
                            @if(isset($server_data->labels[3]->label->id))
                                <x-slot name="current">{{$server_data->labels[3]->label->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                </div>
                <div class="row">
                    @foreach($server_data->ips as $ip)
                        <div class="col-12 col-lg-3 mb-4">
                            <x-text-input>
                                <x-slot name="title">IP</x-slot>
                                <x-slot name="name">ip{{{$loop->iteration}}}</x-slot>
                                <x-slot name="max">255</x-slot>
                                <x-slot name="value">{{ $ip['address'] }}</x-slot>
                            </x-text-input>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-lg-6 mb-4">
                        <x-form-check text="I still have this server" name="is_active"
                                      checked="{{$server_data->active}}"></x-form-check>
                    </div>
                    <div class="col-12 col-lg-6 mb-4">
                        <x-form-check text="Allow some of this data to be public" name="show_public"
                                      checked="{{$server_data->show_public}}"></x-form-check>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Update server</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
