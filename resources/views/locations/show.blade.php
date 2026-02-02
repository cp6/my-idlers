@section("title", "{$location->name} location")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $location->name }}</h2>
            </div>
            <div class="page-actions">
                <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary">Back to locations</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="row g-4">
            <!-- Services at this location -->
            <div class="col-12">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Services at this location</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td class="px-3 py-2 text-muted" style="width: 20%;">
                                        @if(isset($item->hostname))
                                            Server
                                        @elseif(isset($item->main_domain_shared))
                                            Shared
                                        @elseif(isset($item->main_domain_reseller))
                                            Reseller
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @if(isset($item->hostname))
                                            <a href="{{ route('servers.show', $item->id) }}" class="text-decoration-none">{{ $item->hostname }}</a>
                                        @elseif(isset($item->main_domain_shared))
                                            <a href="{{ route('shared.show', $item->id) }}" class="text-decoration-none">{{ $item->main_domain_shared }}</a>
                                        @elseif(isset($item->main_domain_reseller))
                                            <a href="{{ route('reseller.show', $item->id) }}" class="text-decoration-none">{{ $item->main_domain_reseller }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-3 py-2 text-muted" colspan="2">No services found at {{ $location->name }}</td>
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
                                <td class="px-3 py-2"><code>{{ $location->id }}</code></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
