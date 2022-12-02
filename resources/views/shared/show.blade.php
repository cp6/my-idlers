@section("title", "{$shared->main_domain} shared")
<x-app-layout>
    <x-slot name="header">
        {{ __('Share hosting details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $shared->main_domain }}</h2>
                    @foreach($shared->labels as $label)
                        <span class="badge bg-primary mx-1">{{$label->label->label}}</span>
                    @endforeach
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $shared->id }}</h6>
                    @if($shared->active !== 1)
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
                                <td class="px-2 py-2 font-bold text-muted">Type</td>
                                <td>{{ $shared->shared_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Location</td>
                                <td>{{ $shared->location->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Provider</td>
                                <td>{{ $shared->provider->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Price</td>
                                <td>{{ $shared->price->price }} {{ $shared->price->currency }}
                                    <small>{{\App\Process::paymentTermIntToString($shared->price->term)}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Was promo</td>
                                <td>{{ ($shared->was_promo === 1) ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Has dedicated IP?</td>
                                <td>
                                    @if(isset($shared->ips[0]->address))
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">IP</td>
                                <td><code>@if(isset($shared->ips[0]->address))
                                            {{$shared->ips[0]->address}}
                                        @endif
                                    </code></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Owned since</td>
                                <td>
                                    @if(!is_null($shared->owned_since))
                                        {{ date_format(new DateTime($shared->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Next due date</td>
                                <td>{{Carbon\Carbon::parse($shared->price->next_due_date)->diffForHumans()}}
                                    ({{Carbon\Carbon::parse($shared->price->next_due_date)->format('d/m/Y')}})
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Inserted</td>
                                <td>
                                    @if(!is_null($shared->created_at))
                                        {{ date_format(new DateTime($shared->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($shared->updated_at))
                                        {{ date_format(new DateTime($shared->updated_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <table class="table table-borderless">
                        <tbody>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Disk GB</td>
                            <td>{{$shared->disk_as_gb}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Bandwidth GB</td>
                            <td>{{$shared->bandwidth}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Domains Limit</td>
                            <td>{{$shared->domains_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Subdomains Limit</td>
                            <td>{{$shared->subdomains_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Email Limit</td>
                            <td>{{$shared->email_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">DB Limit</td>
                            <td>{{$shared->db_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">FTP Limit</td>
                            <td>{{$shared->ftp_limit}}</td>
                        </tr>
                        @if(isset($shared->note))
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Note:</td>
                            <td>{{$shared->note->note}}</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
            <x-back-btn>
                <x-slot name="route">{{ route('shared.index') }}</x-slot>
            </x-back-btn>
            <x-edit-btn>
                <x-slot name="route">{{ route('shared.edit', $shared->id) }}</x-slot>
            </x-edit-btn>
        </x-card>
              <x-details-footer></x-details-footer>
    </div>
</x-app-layout>
