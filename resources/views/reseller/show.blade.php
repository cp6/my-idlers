@section("title", "{$reseller->main_domain} reseller hosting")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $reseller->main_domain }}</h2>
                <div class="mt-2">
                    @foreach($reseller->labels as $label)
                        <span class="badge bg-primary">{{$label->label->label}}</span>
                    @endforeach
                    @if($reseller->active !== 1)
                        <span class="badge bg-danger">Not Active</span>
                    @endif
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('reseller.index') }}" class="btn btn-outline-secondary">Back to reseller</a>
                <a href="{{ route('reseller.edit', $reseller->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="card content-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-muted" style="width: 40%;">Type</td>
                                <td class="px-2 py-2">{{ $reseller->reseller_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Main Domain</td>
                                <td class="px-2 py-2">
                                    <a href="https://{{ $reseller->main_domain }}" class="text-decoration-none">{{ $reseller->main_domain }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Location</td>
                                <td class="px-2 py-2">{{ $reseller->location->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Provider</td>
                                <td class="px-2 py-2">{{ $reseller->provider->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Price</td>
                                <td class="px-2 py-2">
                                    {{ $reseller->price->price }} {{ $reseller->price->currency }}
                                    <small class="text-muted">{{ \App\Process::paymentTermIntToString($reseller->price->term) }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Next Due Date</td>
                                <td class="px-2 py-2">
                                    {{ Carbon\Carbon::parse($reseller->price->next_due_date)->diffForHumans() }}
                                    <small class="text-muted">({{ Carbon\Carbon::parse($reseller->price->next_due_date)->format('d/m/Y') }})</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Owned Since</td>
                                <td class="px-2 py-2">
                                    @if($reseller->owned_since !== null)
                                        {{ date_format(new DateTime($reseller->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-muted" style="width: 40%;">Disk</td>
                                <td class="px-2 py-2">{{ $reseller->disk_as_gb }} GB</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Bandwidth</td>
                                <td class="px-2 py-2">{{ $reseller->bandwidth }} GB</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Accounts</td>
                                <td class="px-2 py-2">{{ $reseller->accounts }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Domains Limit</td>
                                <td class="px-2 py-2">{{ $reseller->domains_limit }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Subdomains Limit</td>
                                <td class="px-2 py-2">{{ $reseller->subdomains_limit }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Email Limit</td>
                                <td class="px-2 py-2">{{ $reseller->email_limit }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">DB / FTP Limit</td>
                                <td class="px-2 py-2">{{ $reseller->db_limit }} / {{ $reseller->ftp_limit }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Dedicated IP</td>
                                <td class="px-2 py-2">
                                    @if(isset($reseller->ips[0]->address))
                                        <code>{{ $reseller->ips[0]->address }}</code>
                                    @else
                                        No
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if(isset($reseller->note))
                <hr class="my-3">
                <h6 class="text-muted mb-2">Note</h6>
                <p class="mb-0">{{ $reseller->note->note }}</p>
                @endif

                <hr class="my-3">
                <small class="text-muted">
                    ID: <code>{{ $reseller->id }}</code> |
                    Created: {{ $reseller->created_at !== null ? date_format(new DateTime($reseller->created_at), 'jS M Y, g:i a') : '-' }} |
                    Updated: {{ $reseller->updated_at !== null ? date_format(new DateTime($reseller->updated_at), 'jS M Y, g:i a') : '-' }}
                </small>
            </div>
        </div>
    </div>
</x-app-layout>
