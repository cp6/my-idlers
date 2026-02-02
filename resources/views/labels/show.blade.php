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

        <div class="row g-4">
            <!-- Services with this label -->
            <div class="col-12">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Services with this label</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            @forelse($labels as $item)
                                <tr>
                                    <td class="px-3 py-2 text-muted" style="width: 20%;">
                                        @if($item->service_type === 1)
                                            Server
                                        @elseif($item->service_type === 2)
                                            Shared
                                        @elseif($item->service_type === 3)
                                            Reseller
                                        @elseif($item->service_type === 4)
                                            Domain
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @if($item->service_type === 1)
                                            <a href="{{ route('servers.show', $item->service_id) }}" class="text-decoration-none">{{ $item->hostname }}</a>
                                        @elseif($item->service_type === 2)
                                            <a href="{{ route('shared.show', $item->service_id) }}" class="text-decoration-none">{{ $item->shared }}</a>
                                        @elseif($item->service_type === 3)
                                            <a href="{{ route('reseller.show', $item->service_id) }}" class="text-decoration-none">{{ $item->reseller }}</a>
                                        @elseif($item->service_type === 4)
                                            <a href="{{ route('domains.show', $item->service_id) }}" class="text-decoration-none">{{ $item->domain }}.{{ $item->extension }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-3 py-2 text-muted" colspan="2">No services found with this label</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Record Info -->
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
                                <td class="px-3 py-2"><code>{{ $label->id }}</code></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
