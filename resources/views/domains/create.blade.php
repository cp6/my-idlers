@section('title') {{'Insert domain'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a new domain') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">Domain information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('domains.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-errors-alert></x-errors-alert>
            <form action="{{ route('domains.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-lg-6 mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Domain</span></div>
                            <input type="text"
                                   class="form-control"
                                   name="domain"
                                   placeholder="Enter domain name without extension">
                            @error('name') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 mb-3">
                        <x-text-input>
                            <x-slot name="title">extension</x-slot>
                            <x-slot name="name">extension</x-slot>
                            <x-slot name="max">255</x-slot>
                            <x-slot name="value">com</x-slot>
                        </x-text-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS1</x-slot>
                            <x-slot name="name">ns1</x-slot>
                            <x-slot name="max">255</x-slot>
                        </x-text-input>
                    </div>
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS2</x-slot>
                            <x-slot name="name">ns2</x-slot>
                            <x-slot name="max">255</x-slot>
                        </x-text-input>
                    </div>
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS3</x-slot>
                            <x-slot name="name">ns3</x-slot>
                            <x-slot name="max">255</x-slot>
                        </x-text-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <x-providers-select>
                            <x-slot name="current">1</x-slot>
                        </x-providers-select>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
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
                        <x-term-select>
                            <x-slot name="current">4</x-slot>
                        </x-term-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-currency-select>
                            <x-slot name="current">USD</x-slot>
                        </x-currency-select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-md-4 mb-3">
                        <x-date-input>
                            <x-slot name="title">Owned since</x-slot>
                            <x-slot name="name">owned_since</x-slot>
                            <x-slot name="value">{{Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}</x-slot>
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
                <div class="row mb-2">
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
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Insert domain</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
