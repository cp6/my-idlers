@section("title", "Insert misc service")
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a new misc service') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">Service information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('misc.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-response-alerts></x-response-alerts>
            <form action="{{ route('misc.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-4 mb-4">
                        <input type="hidden" value="1" name="service_type">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Name</span></div>
                            <input type="text"
                                   class="form-control"
                                   name="name" required maxlength="255">
                            @error('name') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-2 mb-3">
                        <x-number-input>
                            <x-slot name="title">Price</x-slot>
                            <x-slot name="name">price</x-slot>
                            <x-slot name="value">9.99</x-slot>
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
                    <div class="col-12 col-md-4 mb-3">
                        <x-date-input>
                            <x-slot name="title">Owned since</x-slot>
                            <x-slot name="name">owned_since</x-slot>
                            <x-slot name="value">{{Carbon\Carbon::now()->format('Y-m-d') }}</x-slot>
                        </x-date-input>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <x-date-input>
                            <x-slot name="title">Next due date</x-slot>
                            <x-slot name="name">next_due_date</x-slot>
                            <x-slot name="value">{{Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}</x-slot>
                        </x-date-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Insert misc service</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
