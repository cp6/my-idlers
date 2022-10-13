@section("title", "{$misc_data->name} service")
<x-app-layout>
    <x-slot name="header">
        {{ __('Misc details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $misc_data->name}}</h2>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $misc_data->id }}</h6>
                    @if($misc_data->active !== 1)
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
                                <td>{{ $misc_data->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Price</td>
                                <td>{{ $misc_data->price->price }} {{ $misc_data->price->currency }}
                                    <small>{{\App\Process::paymentTermIntToString($misc_data->price->term)}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Owned since</td>
                                <td>
                                    @if(!is_null($misc_data->owned_since))
                                        {{ date_format(new DateTime($misc_data->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Next due date</td>
                                <td>{{Carbon\Carbon::parse($misc_data->price->next_due_date)->diffForHumans()}}
                                    ({{Carbon\Carbon::parse($misc_data->price->next_due_date)->format('d/m/Y')}})
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Inserted</td>
                                <td>
                                    @if(!is_null($misc_data->created_at))
                                        {{ date_format(new DateTime($misc_data->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($misc_data->updated_at))
                                        {{ date_format(new DateTime($misc_data->updated_at), 'jS M y g:i a') }}
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
            <a href="{{ route('misc.edit', $misc_data->id) }}"
               class="btn btn-primary btn-sm mx-2">
                Edit
            </a>
        </x-card>
    </div>
</x-app-layout>
