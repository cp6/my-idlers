@section('title') {{ $domain->domain }}.{{$domain->extension}} {{'domain'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Domain details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $domain->domain }}.{{$domain->extension}}</h2>
                    <code>@foreach($labels as $label)
                            @if($loop->last)
                                {{$label->label}}
                            @else
                                {{$label->label}},
                            @endif
                        @endforeach</code>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $domain->id }}</h6>
                    @if($domain->active !== 1)
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
                                <td class="px-2 py-2 font-bold text-muted">Domain</td>
                                <td><a href="https://{{ $domain->domain }}.{{$domain->extension}}" class="text-decoration-none">{{ $domain->domain }}.{{$domain->extension}}</a></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Provider</td>
                                <td>{{ $service_extras[0]->provider_name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Price</td>
                                <td>{{ $service_extras[0]->price }} {{ $service_extras[0]->currency }}
                                    <small>{{\App\Process::paymentTermIntToString($service_extras[0]->term)}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">NS1</td>
                                <td>{{ $domain->ns1 }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">NS2</td>
                                <td>{{ $domain->ns2 }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">NS3</td>
                                <td>{{ $domain->ns3 }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Owned since</td>
                                <td>
                                    @if(!is_null($domain->owned_since))
                                        {{ date_format(new DateTime($domain->owned_since), 'jS F Y') }}
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
                                    @if(!is_null($domain->created_at))
                                        {{ date_format(new DateTime($domain->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($domain->updated_at))
                                        {{ date_format(new DateTime($domain->updated_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{ route('domains.index') }}"
               class="btn btn-success btn-sm mx-2">
                Go back
            </a>
            <a href="{{ route('domains.edit', $domain->id) }}"
               class="btn btn-primary btn-sm mx-2">
                Edit
            </a>
        </x-card>
    </div>
</x-app-layout>
