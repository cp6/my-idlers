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

        <div class="detail-card">
            <div class="detail-section">
                <div class="detail-grid">
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Hosting Details</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Type</span>
                                    <span class="detail-value">{{ $shared->shared_type }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Location</span>
                                    <span class="detail-value">{{ $shared->location->name }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Provider</span>
                                    <span class="detail-value">{{ $shared->provider->name }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Price</span>
                                    <span class="detail-value">{{ $shared->price->price }} {{ $shared->price->currency }} <span class="text-muted">{{ \App\Process::paymentTermIntToString($shared->price->term) }}</span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Next Due</span>
                                    <span class="detail-value">{{ Carbon\Carbon::parse($shared->price->next_due_date)->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Was Promo</span>
                                    <span class="detail-value">{{ ($shared->was_promo === 1) ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Owned Since</span>
                                    <span class="detail-value">{{ $shared->owned_since !== null ? date_format(new DateTime($shared->owned_since), 'jS M Y') : '-' }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Dedicated IP</span>
                                    <span class="detail-value">@if(isset($shared->ips[0]->address))<code>{{ $shared->ips[0]->address }}</code>@else No @endif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Specifications</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Disk</span>
                                    <span class="detail-value">{{ $shared->disk_as_gb }} GB</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Bandwidth</span>
                                    <span class="detail-value">{{ $shared->bandwidth }} GB</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Domains</span>
                                    <span class="detail-value">{{ $shared->domains_limit }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Subdomains</span>
                                    <span class="detail-value">{{ $shared->subdomains_limit }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Email</span>
                                    <span class="detail-value">{{ $shared->email_limit }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Databases</span>
                                    <span class="detail-value">{{ $shared->db_limit }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">FTP</span>
                                    <span class="detail-value">{{ $shared->ftp_limit }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($shared->note))
            <div class="detail-section">
                <div class="detail-section-header">
                    <h6 class="detail-section-title">Note</h6>
                </div>
                <div class="detail-note">{{ $shared->note->note }}</div>
            </div>
            @endif

            <div class="detail-footer">
                ID: <code>{{ $shared->id }}</code> &middot;
                Created: {{ $shared->created_at !== null ? date_format(new DateTime($shared->created_at), 'jS M Y, g:i a') : '-' }} &middot;
                Updated: {{ $shared->updated_at !== null ? date_format(new DateTime($shared->updated_at), 'jS M Y, g:i a') : '-' }}
            </div>
        </div>
    </div>
</x-app-layout>
