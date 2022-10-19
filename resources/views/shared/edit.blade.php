@section("title", "{$shared->main_domain} edit")
<x-app-layout>
    <x-slot name="header">
        Edit {{ $shared->main_domain }}
    </x-slot>

    <div class="container">
        <div class="card mt-3 shadow">
            <div class="card-body">
                <a href="{{ route('shared.index') }}"
                   class="btn btn-primary px-4 py-1">
                    Back to shared hosting
                </a>
                <x-auth-validation-errors></x-auth-validation-errors>
                <form action="{{ route('shared.update', $shared->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mt-3">
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Domain</span></div>
                                <input type="text"
                                       class="form-control"
                                       name="domain" value="{{$shared->main_domain}}">
                                @error('name') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <input type="hidden" name="id" value="{{$shared->id}}">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Type</span></div>
                                <select class="form-control" id="shared_type" name="shared_type">
                                    <option
                                        value="ApisCP" {{ ($shared->shared_type === 'ApisCP') ? 'selected' : '' }}>
                                        ApisCP
                                    </option>
                                    <option
                                        value="Centos" {{ ($shared->shared_type === 'Centos') ? 'selected' : '' }}>
                                        Centos
                                    </option>
                                    <option
                                        value="cPanel" {{ ($shared->shared_type === 'cPanel') ? 'selected' : '' }}>
                                        cPanel
                                    </option>
                                    <option
                                        value="Direct Admin" {{ ($shared->shared_type === 'Direct Admin') ? 'selected' : '' }}>
                                        Direct Admin
                                    </option>
                                    <option
                                        value="Webmin" {{ ($shared->shared_type === 'Webmin') ? 'selected' : '' }}>
                                        Webmin
                                    </option>
                                    <option value="Moss" {{ ($shared->shared_type === 'Moss') ? 'selected' : '' }}>
                                        Moss
                                    </option>
                                    <option value="Other" {{ ($shared->shared_type === 'Other') ? 'selected' : '' }}>
                                        Other
                                    </option>
                                    <option value="Plesk" {{ ($shared->shared_type === 'Plesk') ? 'selected' : '' }}>
                                        Plesk
                                    </option>
                                    <option
                                        value="Run cloud" {{ ($shared->shared_type === 'Run cloud') ? 'selected' : '' }}>
                                        Run cloud
                                    </option>
                                    <option
                                        value="Vesta CP" {{ ($shared->shared_type === 'Vesta CP') ? 'selected' : '' }}>
                                        Vesta CP
                                    </option>
                                    <option
                                        value="Virtual min" {{ ($shared->shared_type === 'Virtual min') ? 'selected' : '' }}>
                                        Virtual min
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-text-input>
                                <x-slot name="title">Dedicated IP</x-slot>
                                <x-slot name="name">dedicated_ip</x-slot>
                                <x-slot name="max">255</x-slot>
                                <x-slot name="value">@if(isset($shared->ips[0]->address)) {{$shared->ips[0]->address}}@endif</x-slot>
                            </x-text-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <x-providers-select>
                                <x-slot name="current">{{$shared->provider->id}}</x-slot>
                            </x-providers-select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <x-number-input>
                                <x-slot name="title">Price</x-slot>
                                <x-slot name="name">price</x-slot>
                                <x-slot name="value">{{$shared->price->price}}</x-slot>
                                <x-slot name="max">9999</x-slot>
                                <x-slot name="step">0.01</x-slot>
                                <x-slot name="required"></x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-md-3 mb-3">
                            <x-term-select>
                                <x-slot name="current">{{$shared->price->term}}</x-slot>
                            </x-term-select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <x-currency-select>
                                <x-slot name="current">{{$shared->price->currency}}</x-slot>
                            </x-currency-select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-md-3 mb-3">
                            <x-locations-select>
                                <x-slot name="current">{{$shared->location->id}}</x-slot>
                            </x-locations-select>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <x-yes-no-select>
                                <x-slot name="title">Promo price</x-slot>
                                <x-slot name="name">was_promo</x-slot>
                                <x-slot name="value">{{ $shared->was_promo }}</x-slot>
                            </x-yes-no-select>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <x-date-input>
                                <x-slot name="title">Owned since</x-slot>
                                <x-slot name="name">owned_since</x-slot>
                                <x-slot name="value">{{$shared->owned_since }}</x-slot>
                            </x-date-input>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <x-date-input>
                                <x-slot name="title">Next due date</x-slot>
                                <x-slot name="name">next_due_date</x-slot>
                                <x-slot name="value">{{$shared->price->next_due_date }}</x-slot>
                            </x-date-input>
                        </div>
                    </div>
                    <div class="row">
                        <p class="text-muted"><b>Limits</b></p>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Domains</x-slot>
                                <x-slot name="name">domains</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">{{$shared->domains_limit}}</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Sub domains</x-slot>
                                <x-slot name="name">sub_domains</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">{{$shared->subdomains_limit}}</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Disk GB</x-slot>
                                <x-slot name="name">disk</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">{{$shared->disk_as_gb}}</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Email</x-slot>
                                <x-slot name="name">email</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">{{$shared->email_limit}}</x-slot>
                            </x-number-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Bandwidth GB</x-slot>
                                <x-slot name="name">bandwidth</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">{{$shared->bandwidth}}</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">FTP</x-slot>
                                <x-slot name="name">ftp</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">{{$shared->ftp_limit}}</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">DB</x-slot>
                                <x-slot name="name">db</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">{{$shared->db_limit}}</x-slot>
                            </x-number-input>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-lg-3 mb-4">
                            <x-labels-select>
                                <x-slot name="title">label</x-slot>
                                <x-slot name="name">label1</x-slot>
                                @if(isset($shared->labels[0]->label->id))
                                    <x-slot name="current">{{$shared->labels[0]->label->id}}</x-slot>
                                @endif
                            </x-labels-select>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-labels-select>
                                <x-slot name="title">label</x-slot>
                                <x-slot name="name">label2</x-slot>
                                @if(isset($shared->labels[1]->label->id))
                                    <x-slot name="current">{{$shared->labels[1]->label->id}}</x-slot>
                                @endif
                            </x-labels-select>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-labels-select>
                                <x-slot name="title">label</x-slot>
                                <x-slot name="name">label3</x-slot>
                                @if(isset($shared->labels[2]->label->id))
                                    <x-slot name="current">{{$shared->labels[2]->label->id}}</x-slot>
                                @endif
                            </x-labels-select>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-labels-select>
                                <x-slot name="title">label</x-slot>
                                <x-slot name="name">label4</x-slot>
                                @if(isset($shared->labels[3]->label->id))
                                    <x-slot name="current">{{$shared->labels[3]->label->id}}</x-slot>
                                @endif
                            </x-labels-select>
                        </div>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" name="is_active" type="checkbox"
                               value="1" {{ ($shared->active === 1) ? 'checked' : '' }}>
                        <label class="form-check-label">
                            I still have this server
                        </label>
                    </div>
                    <div>
                        <button type="submit"
                                class="btn btn-success px-4 py-1 mt-3">
                            Update shared hosting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
