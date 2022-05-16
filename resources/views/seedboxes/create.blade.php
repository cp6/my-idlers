@section('title') {{'Enter new seed box'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a new seed box') }}
    </x-slot>
    <div class="container">
        <div class="card shadow mt-3">
            <div class="card-body">
                <h4 class="mb-3">Seed box information</h4>
                <x-auth-validation-errors></x-auth-validation-errors>
                <a href="{{ route('shared.index') }}"
                   class="btn btn-primary py-0 px-4 mb-4">
                    Go back
                </a>
                <form action="{{ route('seedboxes.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-4 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Title</span></div>
                                <input type="text"
                                       class="form-control"
                                       name="title">
                                @error('title') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Hostname</span></div>
                                <input type="text"
                                       class="form-control"
                                       name="hostname">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Type</span></div>
                                <select class="form-control" id="seed_box_type" name="seed_box_type">
                                    <option value="uTorrent" selected="">uTorrent</option>
                                    <option value="BitTorrent">BitTorrent</option>
                                    <option value="ruTorrent">ruTorrent</option>
                                    <option value="Transmission">Transmission</option>
                                    <option value="qBitTorrent">qBitTorrent</option>
                                    <option value="Zona">Zona</option>
                                    <option value="Deluge">Deluge</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <x-providers-select>
                                <x-slot name="current">10</x-slot>
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
                            <x-currency-select>
                                <x-slot name="current">{{Session::get('default_currency')}}</x-slot>
                            </x-currency-select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-md-3 mb-3">
                            <x-locations-select>
                                <x-slot name="current">1</x-slot>
                            </x-locations-select>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <x-yes-no-select>
                                <x-slot name="title">Was promo</x-slot>
                                <x-slot name="name">was_promo</x-slot>
                                <x-slot name="value">0</x-slot>
                            </x-yes-no-select>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <x-date-input>
                                <x-slot name="title">Owned since</x-slot>
                                <x-slot name="name">owned_since</x-slot>
                                <x-slot name="value">{{Carbon\Carbon::now()->format('Y-m-d') }}</x-slot>
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
                    <div class="row">
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Disk GB</x-slot>
                                <x-slot name="name">disk</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">500</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Bandwidth GB</x-slot>
                                <x-slot name="name">bandwidth</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">1000</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Port speed Mbps</x-slot>
                                <x-slot name="name">port_speed</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">1000</x-slot>
                            </x-number-input>
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
                    <div>
                        <button type="submit"
                                class="btn btn-success py-0 px-4 mt-2">
                            Insert Seed box
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
