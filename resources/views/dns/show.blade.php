@section("title", "{$dns->hostname} {$dns->dns_type} DNS")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $dns->hostname }}</h2>
                <div class="mt-2">
                    @foreach($labels as $label)
                        <span class="badge bg-primary">{{ $label->label }}</span>
                    @endforeach
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('dns.index') }}" class="btn btn-outline-secondary">Back to DNS</a>
                <a href="{{ route('dns.edit', $dns->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="detail-card">
            <div class="detail-section">
                <div class="detail-grid">
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">DNS Details</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Type</span>
                                    <span class="detail-value">{{ $dns->dns_type }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Name</span>
                                    <span class="detail-value">{{ $dns->hostname }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">Address</span>
                                    <span class="detail-value"><code>{{ $dns->address }}</code></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Linked Services</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Server</span>
                                    <span class="detail-value">@if(isset($dns->server_id))<a href="{{ route('servers.show', $dns->server_id) }}">{{ $dns->server_id }}</a>@else - @endif</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Shared</span>
                                    <span class="detail-value">@if(isset($dns->shared_id))<a href="{{ route('shared.show', $dns->shared_id) }}">{{ $dns->shared_id }}</a>@else - @endif</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Reseller</span>
                                    <span class="detail-value">@if(isset($dns->reseller_id))<a href="{{ route('reseller.show', $dns->reseller_id) }}">{{ $dns->reseller_id }}</a>@else - @endif</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Domain</span>
                                    <span class="detail-value">@if(isset($dns->domain_id))<a href="{{ route('domains.show', $dns->domain_id) }}">{{ $dns->domain_id }}</a>@else - @endif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($dns->note))
            <div class="detail-section">
                <div class="detail-section-header">
                    <h6 class="detail-section-title">Note</h6>
                </div>
                <div class="detail-note">{{ $dns->note->note }}</div>
            </div>
            @endif

            <div class="detail-footer">
                ID: <code>{{ $dns->id }}</code> &middot;
                Created: {{ $dns->created_at !== null ? date_format(new DateTime($dns->created_at), 'jS M Y, g:i a') : '-' }} &middot;
                Updated: {{ $dns->updated_at !== null ? date_format(new DateTime($dns->updated_at), 'jS M Y, g:i a') : '-' }}
            </div>
        </div>
    </div>
</x-app-layout>
