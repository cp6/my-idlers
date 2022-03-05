@section('title') {{'Insert location'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a new location') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">Location information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('locations.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-errors-alert></x-errors-alert>
                <form action="{{ route('locations.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Location</span></div>
                                <input type="text"
                                       class="form-control"
                                       name="location_name" minlength="2" maxlength="255" required>
                                @error('locations') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <x-submit-button>Create location</x-submit-button>
                        </div>
                    </div>
                </form>
        </x-card>
    </div>
</x-app-layout>
