@section("title", "{$shared->main_domain} shared")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $shared->main_domain }}</h2>
                <div class="mt-2">
                    @foreach($shared->labels as $label)
                        <span class="badge bg-primary">{{$label->label->label}}</span>
                    @endforeach
                    @if($shared->active !== 1)
                        <span class="badge bg-danger">Not Active</span>
                    @endif
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('shared.index') }}" class="btn btn-outline-secondary">Back to shared</a>
                <a href="{{ route('shared.edit', $shared->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="row g-4">
            <!-- Hosting Details -->
            <div class="col-12 col-lg-6">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Hosting Details</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-3 py-2 text-muted" style="width: 40%;">Type</td>
                                <td class="px-3 py-2">{{ $shared->shared_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Location</td>
                                <td class="px-3 py-2">{{ $shared->location->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Provider</td>
                                <td class="px-3 py-2">{{ $shared->provider->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Price</td>
                                <td class="px-3 py-2">
                                    {{ $shared->price->price }} {{ $shared->price->currency }}
                                    <small class="text-muted">{{ \App\Process::paymentTermIntToString($shared->price->term) }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Next Due Date</td>
                                <td class="px-3 py-2">
                                    {{ Carbon\Carbon::parse($shared->price->next_due_date)->diffForHumans() }}
                                    <small class="text-muted">({{ Carbon\Carbon::parse($shared->price->next_due_date)->format('d/m/Y') }})</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Was Promo</td>
                                <td class="px-3 py-2">{{ ($shared->was_promo === 1) ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Owned Since</td>
                                <td class="px-3 py-2">
                                    @if($shared->owned_since !== null)
                                        {{ date_format(new DateTime($shared->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <div class="col-12 col-lg-6">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Specifications</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-3 py-2 text-muted" style="width: 40%;">Disk</td>
                                <td class="px-3 py-2">{{ $shared->disk_as_gb }} GB</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Bandwidth</td>
                                <td class="px-3 py-2">{{ $shared->bandwidth }} GB</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Domains Limit</td>
                                <td class="px-3 py-2">{{ $shared->domains_limit }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Subdomains Limit</td>
                                <td class="px-3 py-2">{{ $shared->subdomains_limit }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Email Limit</td>
                                <td class="px-3 py-2">{{ $shared->email_limit }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">DB Limit</td>
                                <td class="px-3 py-2">{{ $shared->db_limit }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">FTP Limit</td>
                                <td class="px-3 py-2">{{ $shared->ftp_limit }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Dedicated IP</td>
                                <td class="px-3 py-2">
                                    @if(isset($shared->ips[0]->address))
                                        <code>{{ $shared->ips[0]->address }}</code>
                                    @else
                                        No
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if(isset($shared->note))
            <!-- Note -->
            <div class="col-12">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Note</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $shared->note->note }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Timestamps -->
            <div class="col-12">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Record Info</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-3 py-2 text-muted" style="width: 20%;">ID</td>
                                <td class="px-3 py-2"><code>{{ $shared->id }}</code></td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Created</td>
                                <td class="px-3 py-2">
                                    @if($shared->created_at !== null)
                                        {{ date_format(new DateTime($shared->created_at), 'jS M Y, g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Updated</td>
                                <td class="px-3 py-2">
                                    @if($shared->updated_at !== null)
                                        {{ date_format(new DateTime($shared->updated_at), 'jS M Y, g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
