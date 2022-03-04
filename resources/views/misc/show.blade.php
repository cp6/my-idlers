@section('title') {{ $service_extras[0]->name }} {{'service'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Misc details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $service_extras[0]->name}}</h2>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $service_extras[0]->service_id }}</h6>
                    @if($service_extras[0]->active !== 1)
                        <h6 class="text-danger pe-lg-4">not active</h6>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Service</td>
                                <td>{{ $service_extras[0]->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Price</td>
                                <td>{{ $service_extras[0]->price }} {{ $service_extras[0]->currency }}
                                    <small>{{\App\Process::paymentTermIntToString($service_extras[0]->term)}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Owned since</td>
                                <td>
                                    @if(!is_null($service_extras[0]->owned_since))
                                        {{ date_format(new DateTime($service_extras[0]->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Next due date</td>
                                <td>{{Carbon\Carbon::parse($service_extras[0]->next_due_date)->diffForHumans()}}
                                    ({{Carbon\Carbon::parse($service_extras[0]->next_due_date)->format('d/m/Y')}})
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Inserted</td>
                                <td>
                                    @if(!is_null($service_extras[0]->created_at))
                                        {{ date_format(new DateTime($service_extras[0]->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($service_extras[0]->updated_at))
                                        {{ date_format(new DateTime($service_extras[0]->updated_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{ route('misc.index') }}"
               class="btn btn-success btn-sm mx-2">
                Go back
            </a>
            <a href="{{ route('misc.edit', $service_extras[0]->service_id) }}"
               class="btn btn-primary btn-sm mx-2">
                Edit
            </a>
        </x-card>
    </div>
</x-app-layout>
