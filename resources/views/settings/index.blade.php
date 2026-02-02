@section("title", "Settings")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Settings</h2>
            <div class="page-actions">
                <a href="{{ route('/') }}" class="btn btn-outline-secondary">Back to home</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('settings.update', 1) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Appearance -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Appearance</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Dark Mode</label>
                            <select class="form-select" name="dark_mode">
                                <option value="1" {{ $setting->dark_mode === 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $setting->dark_mode === 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Show Versions Footer</label>
                            <select class="form-select" name="show_versions_footer">
                                <option value="1" {{ $setting->show_versions_footer === 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $setting->show_versions_footer === 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Custom Favicon</label>
                            <input type="file" name="favicon" class="form-control" id="favicon" accept=".ico,.png,.jpg">
                            <small class="text-muted">.ico, .png, .jpg (max 40KB)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Defaults -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Defaults</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Default Server OS</label>
                            <select class="form-select" name="default_server_os">
                                @foreach (App\Models\OS::all() as $os)
                                    <option value="{{ $os->id }}" {{ $setting->default_server_os == $os->id ? 'selected' : '' }}>
                                        {{ $os->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Default Currency</label>
                            <select class="form-select" name="default_currency">
                                @foreach (App\Models\Pricing::getCurrencyList() as $currency)
                                    <option value="{{ $currency }}" {{ $setting->default_currency === $currency ? 'selected' : '' }}>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Dashboard Currency</label>
                            <select class="form-select" name="dashboard_currency">
                                @foreach (App\Models\Pricing::getCurrencyList() as $currency)
                                    <option value="{{ $currency }}" {{ $setting->dashboard_currency === $currency ? 'selected' : '' }}>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Default Sort Order</label>
                            <select class="form-select" name="sort_on">
                                <option value="1" {{ $setting->sort_on === 1 ? 'selected' : '' }}>Created (oldest)</option>
                                <option value="2" {{ $setting->sort_on === 2 ? 'selected' : '' }}>Created (newest)</option>
                                <option value="3" {{ $setting->sort_on === 3 ? 'selected' : '' }}>Due date (soonest)</option>
                                <option value="4" {{ $setting->sort_on === 4 ? 'selected' : '' }}>Due date (latest)</option>
                                <option value="5" {{ $setting->sort_on === 5 ? 'selected' : '' }}>Price (lowest)</option>
                                <option value="6" {{ $setting->sort_on === 6 ? 'selected' : '' }}>Price (highest)</option>
                                <option value="7" {{ $setting->sort_on === 7 ? 'selected' : '' }}>Owned since (oldest)</option>
                                <option value="8" {{ $setting->sort_on === 8 ? 'selected' : '' }}>Owned since (newest)</option>
                                <option value="9" {{ $setting->sort_on === 9 ? 'selected' : '' }}>Updated (oldest)</option>
                                <option value="10" {{ $setting->sort_on === 10 ? 'selected' : '' }}>Updated (newest)</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Servers Index View</label>
                            <select class="form-select" name="servers_index_cards">
                                <option value="0" {{ ($setting->servers_index_cards ?? 0) == 0 ? 'selected' : '' }}>Table</option>
                                <option value="1" {{ ($setting->servers_index_cards ?? 0) == 1 ? 'selected' : '' }}>Cards</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Dashboard</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Due Soon Amount</label>
                            <input type="number" class="form-control" name="due_soon_amount" 
                                   value="{{ $setting->due_soon_amount }}" min="0" max="12" step="1">
                            <small class="text-muted">Items to show in due soon section</small>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Recently Added Amount</label>
                            <input type="number" class="form-control" name="recently_added_amount" 
                                   value="{{ $setting->recently_added_amount }}" min="0" max="12" step="1">
                            <small class="text-muted">Items to show in recently added section</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Public Server Listing -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Public Server Listing</h5>
                    <span class="text-muted small">Configure what's visible at /servers/public</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Enable Public Listing</label>
                            <select class="form-select" name="show_servers_public">
                                <option value="1" {{ $setting->show_servers_public === 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $setting->show_servers_public === 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    <p class="text-muted mb-3">Choose which fields to display publicly (only applies when public listing is enabled):</p>
                    
                    <div class="row g-3">
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Show IP</label>
                            <select class="form-select" name="show_server_value_ip">
                                <option value="1" {{ $setting->show_server_value_ip === 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $setting->show_server_value_ip === 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Show Hostname</label>
                            <select class="form-select" name="show_server_value_hostname">
                                <option value="1" {{ $setting->show_server_value_hostname === 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $setting->show_server_value_hostname === 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Show Provider</label>
                            <select class="form-select" name="show_server_value_provider">
                                <option value="1" {{ $setting->show_server_value_provider === 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $setting->show_server_value_provider === 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Show Location</label>
                            <select class="form-select" name="show_server_value_location">
                                <option value="1" {{ $setting->show_server_value_location === 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $setting->show_server_value_location === 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Show Price</label>
                            <select class="form-select" name="show_server_value_price">
                                <option value="1" {{ $setting->show_server_value_price === 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $setting->show_server_value_price === 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Show YABS</label>
                            <select class="form-select" name="show_server_value_yabs">
                                <option value="1" {{ $setting->show_server_value_yabs === 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $setting->show_server_value_yabs === 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-4">Update Settings</button>
        </form>
    </div>
</x-app-layout>
