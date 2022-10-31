@section("title", "Edit settings")
<x-app-layout>
    <x-slot name="header">
        Edit Settings
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <x-response-alerts></x-response-alerts>
            <x-back-button>
                <x-slot name="href">{{ route('/') }}</x-slot>
                Back to home
            </x-back-button>
            <form action="{{ route('settings.update', 1) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mt-2">
                    <div class="col-12 col-md-6 mb-3">
                        <x-yes-no-select title="Use dark mode" name="dark_mode" value="{{ $setting->dark_mode }}"></x-yes-no-select>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-yes-no-select title="Show versions footer" name="show_versions_footer" value="{{ $setting->show_versions_footer }}"></x-yes-no-select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <x-os-select>
                            <x-slot name="title">Default server OS</x-slot>
                            <x-slot name="name">default_server_os</x-slot>
                            <x-slot name="current">{{$setting->default_server_os}}</x-slot>
                        </x-os-select>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-currency-select>
                            <x-slot name="title">Default currency</x-slot>
                            <x-slot name="name">default_currency</x-slot>
                            <x-slot name="current">{{$setting->default_currency}}</x-slot>
                        </x-currency-select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <x-number-input>
                            <x-slot name="title">Due soon amount to show</x-slot>
                            <x-slot name="name">due_soon_amount</x-slot>
                            <x-slot name="step">1</x-slot>
                            <x-slot name="min">0</x-slot>
                            <x-slot name="max">12</x-slot>
                            <x-slot name="value">{{$setting->due_soon_amount}}</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-number-input>
                            <x-slot name="title">Recently added amount to show</x-slot>
                            <x-slot name="name">recently_added_amount</x-slot>
                            <x-slot name="step">1</x-slot>
                            <x-slot name="min">0</x-slot>
                            <x-slot name="max">12</x-slot>
                            <x-slot name="value">{{$setting->recently_added_amount}}</x-slot>
                        </x-number-input>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <x-yes-no-select title="Show servers to public" name="show_servers_public" value="{{ $setting->show_servers_public }}"></x-yes-no-select>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-currency-select>
                            <x-slot name="title">Home page currency</x-slot>
                            <x-slot name="current">{{$setting->dashboard_currency}}</x-slot>
                        </x-currency-select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <x-yes-no-select title="Save YABs input to txt" name="save_yabs_as_txt" value="{{ $setting->save_yabs_as_txt }}"></x-yes-no-select>
                    </div>
                </div>
                <p>Only if <i>Show servers to public</i> is <b>YES</b> do these apply:</p>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <x-yes-no-select title="Show servers IP's" name="show_server_value_ip" value="{{ $setting->show_server_value_ip }}"></x-yes-no-select>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-yes-no-select title="Show servers hostname" name="show_server_value_hostname" value="{{ $setting->show_server_value_hostname }}"></x-yes-no-select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <x-yes-no-select title="Show servers provider" name="show_server_value_provider" value="{{ $setting->show_server_value_provider }}"></x-yes-no-select>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-yes-no-select title="Show servers location" name="show_server_value_location" value="{{ $setting->show_server_value_location }}"></x-yes-no-select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <x-yes-no-select title="Show servers price" name="show_server_value_price" value="{{ $setting->show_server_value_price }}"></x-yes-no-select>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-yes-no-select title="Show servers YABS" name="show_server_value_yabs" value="{{ $setting->show_server_value_yabs }}"></x-yes-no-select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">Default order by</span></div>
                            <select class="form-control" name="sort_on">
                                <option
                                    value="1" {{ ($setting->sort_on === 1) ? 'selected' : '' }}>
                                    created_at ASC
                                </option>
                                <option
                                    value="2" {{ ($setting->sort_on === 2) ? 'selected' : '' }}>
                                    created_at DESC
                                </option>
                                <option
                                    value="3" {{ ($setting->sort_on === 3) ? 'selected' : '' }}>
                                    next_due_date ASC
                                </option>
                                <option
                                    value="4" {{ ($setting->sort_on === 4) ? 'selected' : '' }}>
                                    next_due_date DESC
                                </option>
                                <option
                                    value="5" {{ ($setting->sort_on === 5) ? 'selected' : '' }}>
                                    as_usd ASC
                                </option>
                                <option
                                    value="6" {{ ($setting->sort_on === 6) ? 'selected' : '' }}>
                                    as_usd DESC
                                </option>
                                <option
                                    value="7" {{ ($setting->sort_on === 7) ? 'selected' : '' }}>
                                    owned_since ASC
                                </option>
                                <option
                                    value="8" {{ ($setting->sort_on === 8) ? 'selected' : '' }}>
                                    owned_since DESC
                                </option>
                                <option
                                    value="9" {{ ($setting->sort_on === 9) ? 'selected' : '' }}>
                                    updated_at ASC
                                </option>
                                <option
                                    value="10" {{ ($setting->sort_on === 10) ? 'selected' : '' }}>
                                    updated_at DESC
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Update settings</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
        <x-details-footer></x-details-footer>
    </div>
</x-app-layout>
