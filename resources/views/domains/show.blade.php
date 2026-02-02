@section("title", "{$domain_info->domain}.{$domain_info->extension} domain")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $domain_info->domain }}.{{ $domain_info->extension }}</h2>
                <div class="mt-2">
                    @foreach($domain_info->labels as $label)
                        <span class="badge bg-primary">{{$label->label->label}}</span>
                    @endforeach
                    @if($domain_info->active !== 1)
                        <span class="badge bg-danger">Not Active</span>
                    @endif
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('domains.index') }}" class="btn btn-outline-secondary">Back to domains</a>
                <a href="{{ route('domains.edit', $domain_info->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="detail-card">
            <div class="detail-section">
                <div class="detail-grid">
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Domain Details</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">Domain</span>
                                    <span class="detail-value"><a href="https://{{ $domain_info->domain }}.{{ $domain_info->extension }}">{{ $domain_info->domain }}.{{ $domain_info->extension }}</a></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Provider</span>
                                    <span class="detail-value">{{ $domain_info->provider->name }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Price</span>
                                    <span class="detail-value">{{ $domain_info->price->price }} {{ $domain_info->price->currency }} <span class="text-muted">{{ \App\Process::paymentTermIntToString($domain_info->price->term) }}</span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Next Due</span>
                                    <span class="detail-value">{{ Carbon\Carbon::parse($domain_info->price->next_due_date)->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Owned Since</span>
                                    <span class="detail-value">{{ $domain_info->owned_since !== null ? date_format(new DateTime($domain_info->owned_since), 'jS M Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Nameservers</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">NS1</span>
                                    <span class="detail-value">{{ $domain_info->ns1 ?: '-' }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">NS2</span>
                                    <span class="detail-value">{{ $domain_info->ns2 ?: '-' }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">NS3</span>
                                    <span class="detail-value">{{ $domain_info->ns3 ?: '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($domain_info->note))
            <div class="detail-section">
                <div class="detail-section-header">
                    <h6 class="detail-section-title">Note</h6>
                </div>
                <div class="detail-note">{{ $domain_info->note->note }}</div>
            </div>
            @endif

            <div class="detail-footer">
                ID: <code>{{ $domain_info->id }}</code> &middot;
                Created: {{ $domain_info->created_at !== null ? date_format(new DateTime($domain_info->created_at), 'jS M Y, g:i a') : '-' }} &middot;
                Updated: {{ $domain_info->updated_at !== null ? date_format(new DateTime($domain_info->updated_at), 'jS M Y, g:i a') : '-' }}
            </div>
        </div>
    </div>
</x-app-layout>
