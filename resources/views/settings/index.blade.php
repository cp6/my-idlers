@section('title') {{'Edit settings'}} @endsection
<x-app-layout>
    <x-slot name="header">
        Edit Settings
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <p class="my-1">{{ $message }}</p>
                </div>
            @endif
            <x-back-button>
                <x-slot name="href">{{ route('/') }}</x-slot>
                Back to home
            </x-back-button>
            <form action="{{ route('settings.update', 1) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mt-2">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">Use dark mode</span></div>
                            <select class="form-control" name="dark_mode">
                                <option value="1" {{ ($setting[0]->dark_mode === 1) ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option value="0" {{ ($setting[0]->dark_mode === 0) ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">Show versions footer</span></div>
                            <select class="form-control" name="show_versions_footer">
                                <option value="1" {{ ($setting[0]->show_versions_footer === 1) ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option value="0" {{ ($setting[0]->show_versions_footer === 0) ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <x-os-select>
                            <x-slot name="title">Default server OS</x-slot>
                            <x-slot name="name">default_server_os</x-slot>
                            <x-slot name="current">{{$setting[0]->default_server_os}}</x-slot>
                        </x-os-select>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-currency-select>
                            <x-slot name="title">Default currency</x-slot>
                            <x-slot name="name">default_currency</x-slot>
                            <x-slot name="current">{{$setting[0]->default_currency}}</x-slot>
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
                            <x-slot name="value">{{$setting[0]->due_soon_amount}}</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-number-input>
                            <x-slot name="title">Recently added amount to show</x-slot>
                            <x-slot name="name">recently_added_amount</x-slot>
                            <x-slot name="step">1</x-slot>
                            <x-slot name="min">0</x-slot>
                            <x-slot name="max">12</x-slot>
                            <x-slot name="value">{{$setting[0]->recently_added_amount}}</x-slot>
                        </x-number-input>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">Show servers to public</span></div>
                            <select class="form-control" name="show_servers_public">
                                <option value="1" {{ ($setting[0]->show_servers_public === 1) ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option value="0" {{ ($setting[0]->show_servers_public === 0) ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-currency-select>
                            <x-slot name="title">Home page currency</x-slot>
                            <x-slot name="current">{{$setting[0]->dashboard_currency}}</x-slot>
                        </x-currency-select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">Save YABs input to txt</span></div>
                            <select class="form-control" name="save_yabs_as_txt">
                                <option value="1" {{ ($setting[0]->save_yabs_as_txt === 1) ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option value="0" {{ ($setting[0]->save_yabs_as_txt === 0) ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <p>Only if <i>Show servers to public</i> is <b>YES</b> do these apply:</p>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">Show servers IP's</span></div>
                            <select class="form-control" name="show_server_value_ip">
                                <option value="1" {{ ($setting[0]->show_server_value_ip === 1) ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option value="0" {{ ($setting[0]->show_server_value_ip === 0) ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">Show servers hostname</span></div>
                            <select class="form-control" name="show_server_value_hostname">
                                <option
                                    value="1" {{ ($setting[0]->show_server_value_hostname === 1) ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option
                                    value="0" {{ ($setting[0]->show_server_value_hostname === 0) ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">Show servers provider</span></div>
                            <select class="form-control" name="show_server_value_provider">
                                <option
                                    value="1" {{ ($setting[0]->show_server_value_provider === 1) ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option
                                    value="0" {{ ($setting[0]->show_server_value_provider === 0) ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">Show servers location</span></div>
                            <select class="form-control" name="show_server_value_location">
                                <option
                                    value="1" {{ ($setting[0]->show_server_value_location === 1) ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option
                                    value="0" {{ ($setting[0]->show_server_value_location === 0) ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">Show servers price</span></div>
                            <select class="form-control" name="show_server_value_price">
                                <option
                                    value="1" {{ ($setting[0]->show_server_value_price === 1) ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option
                                    value="0" {{ ($setting[0]->show_server_value_price === 0) ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">Show servers YABs</span></div>
                            <select class="form-control" name="show_server_value_yabs">
                                <option
                                    value="1" {{ ($setting[0]->show_server_value_yabs === 1) ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option
                                    value="0" {{ ($setting[0]->show_server_value_yabs === 0) ? 'selected' : '' }}>
                                    No
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
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>Built on Laravel
                    v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</small></p>
        @endif
    </div>
</x-app-layout>
