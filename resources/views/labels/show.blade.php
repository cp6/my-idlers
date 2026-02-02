@section("title", "{$label->label} label")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $label->label }}</h2>
            </div>
            <div class="page-actions">
                <a href="{{ route('labels.index') }}" class="btn btn-outline-secondary">Back to labels</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="detail-card">
            <div class="detail-section">
                <div class="detail-section-header">
                    <h6 class="detail-section-title">Services with this label</h6>
                </div>
                @if(count($labels) > 0)
                <div class="row g-3">
                    @foreach($labels as $item)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="detail-item">
                            <span class="detail-label">
                                @if($item->service_type === 1) Server
                                @elseif($item->service_type === 2) Shared
                                @elseif($item->service_type === 3) Reseller
                                @elseif($item->service_type === 4) Domain
                                @endif
                            </span>
                            <span class="detail-value">
                                @if($item->service_type === 1)
                                    <a href="{{ route('servers.show', $item->service_id) }}">{{ $item->hostname }}</a>
                                @elseif($item->service_type === 2)
                                    <a href="{{ route('shared.show', $item->service_id) }}">{{ $item->shared }}</a>
                                @elseif($item->service_type === 3)
                                    <a href="{{ route('reseller.show', $item->service_id) }}">{{ $item->reseller }}</a>
                                @elseif($item->service_type === 4)
                                    <a href="{{ route('domains.show', $item->service_id) }}">{{ $item->domain }}.{{ $item->extension }}</a>
                                @endif
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted mb-0">No services found with this label</p>
                @endif
            </div>

            <div class="detail-footer">
                ID: <code>{{ $label->id }}</code>
            </div>
        </div>
    </div>
</x-app-layout>
