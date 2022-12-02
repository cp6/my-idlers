@section("title", "Add a shared hosting")
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a new shared hosting') }}
    </x-slot>
    <div class="container">
        <div class="card shadow mt-3">
            <div class="card-body">
                <h4 class="mb-3">Shared hosting information</h4>
                <x-auth-validation-errors></x-auth-validation-errors>
                <a href="{{ route('shared.index') }}"
                   class="btn btn-primary py-0 px-4 mb-4">
                    Go back
                </a>
                <form action="{{ route('shared.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-3 mb-4">
                            <x-text-input title="Domain" name="domain"></x-text-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Type</span></div>
                                <select class="form-control" id="shared_type" name="shared_type">
                                    <option value="ApisCP">ApisCP</option>
                                    <option value="Centos">Centos</option>
                                    <option value="cPanel" selected="">cPanel</option>
                                    <option value="Direct Admin">Direct Admin</option>
                                    <option value="Webmin">Webmin</option>
                                    <option value="Moss">Moss</option>
                                    <option value="Other">Other</option>
                                    <option value="Plesk">Plesk</option>
                                    <option value="Run cloud">Run cloud</option>
                                    <option value="Vesta CP">Vesta CP</option>
                                    <option value="Virtual min">Virtual min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-text-input>
                                <x-slot name="title">Dedicated IP</x-slot>
                                <x-slot name="name">dedicated_ip</x-slot>
                                <x-slot name="max">255</x-slot>
                            </x-text-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <x-providers-select>
                                <x-slot name="current">{{random_int(1,98)}}</x-slot>
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
                                <x-slot name="value">1</x-slot>
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
                        <p class="text-muted"><b>Limits</b></p>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Domains</x-slot>
                                <x-slot name="name">domains</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">10</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Sub domains</x-slot>
                                <x-slot name="name">sub_domains</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">20</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Disk GB</x-slot>
                                <x-slot name="name">disk</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">50</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Email</x-slot>
                                <x-slot name="name">email</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">100</x-slot>
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
                                <x-slot name="value">500</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">FTP</x-slot>
                                <x-slot name="name">ftp</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">100</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">DB</x-slot>
                                <x-slot name="name">db</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">100</x-slot>
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
                            Insert Shared hosting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
