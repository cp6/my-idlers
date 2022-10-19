@section("title", "{$domain_info->domain }.{$domain_info->extension} domain")
<x-app-layout>
    <x-slot name="header">
        {{ __('Domain details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $domain_info->domain }}.{{$domain_info->extension}}</h2>
                    @foreach($domain_info->labels as $label)
                        <span class="badge bg-primary mx-1">{{$label->label->label}}</span>
                    @endforeach
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $domain_info->id }}</h6>
                    @if($domain_info->active !== 1)
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
                                <td><a href="https://{{ $domain_info->domain }}.{{$domain_info->extension}}"
                                       class="text-decoration-none">{{ $domain_info->domain }}
                                        .{{$domain_info->extension}}</a></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Provider</td>
                                <td>{{ $domain_info->provider->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Price</td>
                                <td>{{ $domain_info->price->price }} {{ $domain_info->price->currency }}
                                    <small>{{\App\Process::paymentTermIntToString($domain_info->price->term)}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">NS1</td>
                                <td>{{ $domain_info->ns1 }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">NS2</td>
                                <td>{{ $domain_info->ns2 }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">NS3</td>
                                <td>{{ $domain_info->ns3 }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Owned since</td>
                                <td>
                                    @if(!is_null($domain_info->owned_since))
                                        {{ date_format(new DateTime($domain_info->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Next due date</td>
                                <td>{{Carbon\Carbon::parse($domain_info->price->next_due_date)->diffForHumans()}}
                                    ({{Carbon\Carbon::parse($domain_info->price->next_due_date)->format('d/m/Y')}})
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Inserted</td>
                                <td>
                                    @if(!is_null($domain_info->created_at))
                                        {{ date_format(new DateTime($domain_info->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($domain_info->updated_at))
                                        {{ date_format(new DateTime($domain_info->updated_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <x-back-btn>
                <x-slot name="route">{{ route('domains.index') }}</x-slot>
            </x-back-btn>
            <x-edit-btn>
                <x-slot name="route">{{ route('domains.edit', $domain_info->id) }}</x-slot>
            </x-edit-btn>
        </x-card>
    </div>
</x-app-layout>
