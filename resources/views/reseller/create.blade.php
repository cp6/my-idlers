@section('title') {{'Enter new reseller hosting'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a new reseller hosting') }}
    </x-slot>
    <div class="container">
        <div class="card shadow mt-3">
            <div class="card-body">
                <h4 class="mb-3">Reseller hosting information</h4>
                <x-auth-validation-errors></x-auth-validation-errors>
                <a href="{{ route('reseller.index') }}"
                   class="btn btn-primary py-0 px-4 mb-4">
                    Go back
                </a>
                <form action="{{ route('reseller.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Domain</span></div>
                                <input type="text"
                                       class="form-control"
                                       name="domain">
                                @error('name') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Type</span></div>
                                <select class="form-control" name="reseller_type">
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
                        <div class="col-12 col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Has dedicated IP</span></div>
                                <select class="form-control" name="has_dedicated_ip">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select></div>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Dedicated IP</span></div>
                                <input type="text" name="dedicated_ip" class="form-control"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Provider</span></div>
                                <select class="form-control" name="provider_id">
                                    @foreach ($Providers as $provider)
                                        <option value="{{ $provider['id'] }}">
                                            {{ $provider['name'] }}
                                        </option>
                                    @endforeach
                                </select></div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Price</span></div>
                                <input type="number" id="price" name="price" class="form-control" min="0" max="999"
                                       step="0.01" required="" value="2.50"></div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Term</span></div>
                                <select class="form-control" id="payment_term" name="payment_term">
                                    <option value="1" selected="">Monthly</option>
                                    <option value="2">Quarterly</option>
                                    <option value="3">Half annual (half year)</option>
                                    <option value="4">Annual (yearly)</option>
                                    <option value="5">Biennial (2 years)</option>
                                    <option value="6">Triennial (3 years)</option>
                                </select></div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Currency</span></div>
                                <select class="form-control" id="currency" name="currency">
                                    <option value="AUD">AUD</option>
                                    <option value="USD" selected="">USD</option>
                                    <option value="GBP">GBP</option>
                                    <option value="EUR">EUR</option>
                                    <option value="NZD">NZD</option>
                                    <option value="JPY">JPY</option>
                                    <option value="CAD">CAD</option>
                                </select></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Location</span>
                                </div>
                                <select class="form-control" name="location_id">
                                    @foreach ($Locations as $location)
                                        <option value="{{ $location['id'] }}">
                                            {{ $location['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Was promo</span></div>
                                <select class="form-control" name="was_promo">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select></div>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Owned since</span>
                                </div>
                                <input type="date" class="form-control" id="owned_since" name="owned_since" value="{{Carbon\Carbon::now()->subYear(1)->format('Y-m-d') }}"></div>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Next due date</span>
                                </div>
                                <input type="date" class="form-control next-dd" id="next_due_date" name="next_due_date" value="{{Carbon\Carbon::now()->addMonth(1)->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <p>Limits:</p>
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Accounts</span></div>
                                <input type="number" name="accounts" class="form-control" value="10" min="1" max="9999">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Domains</span></div>
                                <input type="number" name="domains" class="form-control" value="10" min="1" max="9999">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Sub domains</span></div>
                                <input type="number" name="sub_domains" class="form-control" value="10" min="1" max="9999">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Disk</span></div>
                                <input type="number" name="disk" class="form-control" value="20" min="1" max="99999">
                                <div class="input-group-append"><span class="input-group-text">GB</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Email</span></div>
                                <input type="number" name="email" class="form-control" value="20" min="1" max="99999">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Bandwidth</span>
                                </div>
                                <input type="number" name="bandwidth" class="form-control" value="999" min="1"
                                       max="99999">
                                <div class="input-group-append"><span class="input-group-text">GB</span></div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">FTP</span></div>
                                <input type="number" name="ftp" class="form-control" value="99" min="1" max="99999">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">DB</span></div>
                                <input type="number" name="db" class="form-control" value="20" min="1" max="99999">
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                                class="btn btn-success py-0 px-4 mt-2">
                            Insert Reseller hosting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
