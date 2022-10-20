@section("title", "Edit account")
<x-app-layout>
    <x-slot name="header">
        Edit account
    </x-slot>

    <div class="container">
        <x-card class="shadow mt-3">
            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <p class="my-1">{{ $message }}</p>
                </div>
            @endif
            <form action="{{ route('account.update',Auth::user()->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mt-2">
                    <div class="col-12 col-md-4 mb-3">
                        <x-text-input>
                            <x-slot name="title">Name</x-slot>
                            <x-slot name="name">name</x-slot>
                            <x-slot name="max">255</x-slot>
                            <x-slot name="value">{{Auth::user()->name}}</x-slot>
                        </x-text-input>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-md-4 mb-3">
                        <x-text-input>
                            <x-slot name="title">Email</x-slot>
                            <x-slot name="name">email</x-slot>
                            <x-slot name="max">255</x-slot>
                            <x-slot name="value">{{Auth::user()->email}}</x-slot>
                        </x-text-input>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-12 col-md-8">
                        API key: <code>{{ Auth::user()->api_token }}</code>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Update account</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
        <x-details-footer></x-details-footer>
    </div>
</x-app-layout>
