@section("title", "{$provider->name} provider")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $provider->name }}</h2>
            </div>
            <div class="page-actions">
                <a href="{{ route('providers.index') }}" class="btn btn-outline-secondary">Back to providers</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="detail-card">
            <div class="detail-section">
                <div class="detail-section-header">
                    <h6 class="detail-section-title">Services from this provider</h6>
                </div>
                @if(count($data) > 0)
                <div class="row g-3">
                    @foreach($data as $item)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="detail-item">
                            <span class="detail-label">
                                @if(isset($item->hostname)) Server
                                @elseif(isset($item->main_domain_shared)) Shared
                                @elseif(isset($item->main_domain_reseller)) Reseller
                                @endif
                            </span>
                            <span class="detail-value">
                                @if(isset($item->hostname))
                                    <a href="{{ route('servers.show', $item->id) }}">{{ $item->hostname }}</a>
                                @elseif(isset($item->main_domain_shared))
                                    <a href="{{ route('shared.show', $item->id) }}">{{ $item->main_domain_shared }}</a>
                                @elseif(isset($item->main_domain_reseller))
                                    <a href="{{ route('reseller.show', $item->id) }}">{{ $item->main_domain_reseller }}</a>
                                @endif
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted mb-0">No services found from {{ $provider->name }}</p>
                @endif
            </div>

            <div class="detail-footer">
                ID: <code>{{ $provider->id }}</code>
            </div>
        </div>
    </div>
</x-app-layout>
