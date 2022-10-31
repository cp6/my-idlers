@section("title", "Add label")
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a new label') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">Label information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('labels.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-response-alerts></x-response-alerts>
                <form action="{{ route('labels.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-4">
                            <x-text-input title="Label" name="label"></x-text-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <x-submit-button>Create label</x-submit-button>
                        </div>
                    </div>
                </form>
        </x-card>
    </div>
</x-app-layout>
