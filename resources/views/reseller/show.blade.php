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
                                    <span class="detail-value">{{ $reseller->reseller_type }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Location</span>
                                    <span class="detail-value">{{ $reseller->location->name }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Provider</span>
                                    <span class="detail-value">{{ $reseller->provider->name }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Price</span>
                                    <span class="detail-value">{{ $reseller->price->price }} {{ $reseller->price->currency }} <span class="text-muted">{{ \App\Process::paymentTermIntToString($reseller->price->term) }}</span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Next Due</span>
                                    <span class="detail-value">{{ Carbon\Carbon::parse($reseller->price->next_due_date)->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Owned Since</span>
                                    <span class="detail-value">{{ $reseller->owned_since !== null ? date_format(new DateTime($reseller->owned_since), 'jS M Y') : '-' }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">Main Domain</span>
                                    <span class="detail-value"><a href="https://{{ $reseller->main_domain }}">{{ $reseller->main_domain }}</a></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Dedicated IP</span>
                                    <span class="detail-value">@if(isset($reseller->ips[0]->address))<code>{{ $reseller->ips[0]->address }}</code>@else No @endif</span>
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
                                    <span class="detail-value">{{ $reseller->disk_as_gb }} GB</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Bandwidth</span>
                                    <span class="detail-value">{{ $reseller->bandwidth }} GB</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Accounts</span>
                                    <span class="detail-value">{{ $reseller->accounts }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Domains</span>
                                    <span class="detail-value">{{ $reseller->domains_limit }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Subdomains</span>
                                    <span class="detail-value">{{ $reseller->subdomains_limit }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Email</span>
                                    <span class="detail-value">{{ $reseller->email_limit }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Databases</span>
                                    <span class="detail-value">{{ $reseller->db_limit }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">FTP</span>
                                    <span class="detail-value">{{ $reseller->ftp_limit }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($reseller->note))
            <div class="detail-section">
                <div class="detail-section-header">
                    <h6 class="detail-section-title">Note</h6>
                </div>
                <div class="detail-note">{{ $reseller->note->note }}</div>
            </div>
            @endif

            <div class="detail-footer">
                ID: <code>{{ $reseller->id }}</code> &middot;
                Created: {{ $reseller->created_at !== null ? date_format(new DateTime($reseller->created_at), 'jS M Y, g:i a') : '-' }} &middot;
                Updated: {{ $reseller->updated_at !== null ? date_format(new DateTime($reseller->updated_at), 'jS M Y, g:i a') : '-' }}
            </div>
        </div>
    </div>
</x-app-layout>
