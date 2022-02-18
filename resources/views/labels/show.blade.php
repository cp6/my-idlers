@section('title') {{ $label->label }} {{'label'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Label details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <x-back-button>
                <x-slot name="href">{{ route('labels.index') }}</x-slot>
                Go back
            </x-back-button>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap">
                            <tbody>
                            <tr>
                                <td class="px-4 py-2 font-bold">label name</td>
                                <td>{{ $label->label}}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">label id</td>
                                <td><code>{{ $label->id}}</code></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</x-app-layout>
