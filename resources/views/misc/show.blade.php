@section('title') {{ $service_extras[0]->name }} {{'service'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Misc details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <x-back-button>
                <x-slot name="href">{{ route('misc.index') }}</x-slot>
                Go back
            </x-back-button>
            <div class="table-responsive">
                <table class="table table-borderless text-nowrap">
                    <tbody>
                    <tr>
                        <td class="px-4 py-2 font-bold">Service</td>
                        <td>{{ $service_extras[0]->name }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Price</td>
                        <td>{{ $service_extras[0]->price }} {{ $service_extras[0]->currency }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Term</td>
                        <td>{{ \App\Process::paymentTermIntToString($service_extras[0]->term) }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Owned since</td>
                        <td>
                            @if(!is_null($service_extras[0]->owned_since))
                                {{ date_format(new DateTime($service_extras[0]->owned_since), 'jS F Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Next due date</td>
                        <td>
                            @if(!is_null($service_extras[0]->next_due_date))
                                {{ date_format(new DateTime($service_extras[0]->next_due_date), 'jS F Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Created on</td>
                        <td>
                            @if(!is_null($service_extras[0]->created_at))
                                {{ date_format(new DateTime($service_extras[0]->created_at), 'jS F Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Last updated</td>
                        <td>
                            @if(!is_null($service_extras[0]->updated_at))
                                {{ date_format(new DateTime($service_extras[0]->updated_at), 'jS F Y') }}
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</x-app-layout>
