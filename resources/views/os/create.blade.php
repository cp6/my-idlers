@section("title", "Insert operating system")
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a new OS') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">Operating system name</h4>
            <x-back-button>
                <x-slot name="href">{{ route('os.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-response-alerts></x-response-alerts>
                <form action="{{ route('os.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">OS</span></div>
                                <input type="text"
                                       class="form-control"
                                       name="os_name" minlength="2" maxlength="255" required>
                                @error('os') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <x-submit-button>Create Operating system</x-submit-button>
                        </div>
                    </div>
                </form>
        </x-card>
    </div>
</x-app-layout>
