@section("title", "{$misc_data->name} edit")
<x-app-layout>
    <x-slot name="header">
        Edit {{ $misc_data->name }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">Service information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('misc.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-response-alerts></x-response-alerts>
            <form action="{{ route('misc.update', $misc_data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input title="Name" name="name" value="{{$misc_data->name}}"></x-text-input>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-number-input>
                            <x-slot name="title">Price</x-slot>
                            <x-slot name="name">price</x-slot>
                            <x-slot name="step">0.01</x-slot>
                            <x-slot name="value">{{ $misc_data->price->price }}</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-term-select>
                            <x-slot name="current">{{$misc_data->price->term}}</x-slot>
                        </x-term-select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <x-currency-select>
                            <x-slot name="current">{{$misc_data->price->currency}}</x-slot>
                        </x-currency-select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-md-4 mb-3">
                        <x-date-input>
                            <x-slot name="title">Owned since</x-slot>
                            <x-slot name="name">owned_since</x-slot>
                            <x-slot name="value">{{$misc_data->owned_since }}</x-slot>
                        </x-date-input>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <x-date-input>
                            <x-slot name="title">Next due date</x-slot>
                            <x-slot name="name">next_due_date</x-slot>
                            <x-slot name="value">{{$misc_data->price->next_due_date}}</x-slot>
                        </x-date-input>
                    </div>
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" name="is_active" type="checkbox"
                           value="1" {{ ($misc_data->active === 1) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        I still have this service
                    </label>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Update misc service</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
