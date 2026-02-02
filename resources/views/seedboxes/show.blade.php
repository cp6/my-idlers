@section("title", "{$seedbox_data->title} seed box")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $seedbox_data->title }}</h2>
                <div class="mt-2">
                    @foreach($seedbox_data->labels as $label)
                        <span class="badge bg-primary">{{$label->label->label}}</span>
                    @endforeach
                    @if($seedbox_data->active !== 1)
                        <span class="badge bg-danger">Not Active</span>
                    @endif
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('seedboxes.index') }}" class="btn btn-outline-secondary">Back to seedboxes</a>
                <a href="{{ route('seedboxes.edit', $seedbox_data->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="row g-4">
            <!-- Seedbox Details -->
            <div class="col-12 col-lg-6">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Seedbox Details</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-3 py-2 text-muted" style="width: 40%;">Type</td>
                                <td class="px-3 py-2">{{ $seedbox_data->seed_box_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Hostname</td>
                                <td class="px-3 py-2"><code>{{ $seedbox_data->hostname }}</code></td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Location</td>
                                <td class="px-3 py-2">{{ $seedbox_data->location->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Provider</td>
                                <td class="px-3 py-2">{{ $seedbox_data->provider->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Price</td>
                                <td class="px-3 py-2">
                                    {{ $seedbox_data->price->price }} {{ $seedbox_data->price->currency }}
                                    <small class="text-muted">{{ \App\Process::paymentTermIntToString($seedbox_data->price->term) }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Next Due Date</td>
                                <td class="px-3 py-2">
                                    {{ Carbon\Carbon::parse($seedbox_data->price->next_due_date)->diffForHumans() }}
                                    <small class="text-muted">({{ Carbon\Carbon::parse($seedbox_data->price->next_due_date)->format('d/m/Y') }})</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Was Promo</td>
                                <td class="px-3 py-2">{{ ($seedbox_data->was_promo === 1) ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Owned Since</td>
                                <td class="px-3 py-2">
                                    @if($seedbox_data->owned_since !== null)
                                        {{ date_format(new DateTime($seedbox_data->owned_since), 'jS F Y') }}
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
                                <td class="px-3 py-2">
                                    @if($seedbox_data->disk_as_gb >= 1000)
                                        {{ number_format($seedbox_data->disk_as_gb / 1000, 1) }} TB
                                    @else
                                        {{ $seedbox_data->disk_as_gb }} GB
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Bandwidth</td>
                                <td class="px-3 py-2">
                                    @if($seedbox_data->bandwidth >= 1000)
                                        {{ number_format($seedbox_data->bandwidth / 1000, 1) }} TB
                                    @else
                                        {{ $seedbox_data->bandwidth }} GB
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Port Speed</td>
                                <td class="px-3 py-2">
                                    @if($seedbox_data->port_speed >= 1000)
                                        {{ number_format($seedbox_data->port_speed / 1000, 1) }} Gbps
                                    @else
                                        {{ $seedbox_data->port_speed }} Mbps
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

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
                                <td class="px-3 py-2"><code>{{ $seedbox_data->id }}</code></td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Created</td>
                                <td class="px-3 py-2">
                                    @if($seedbox_data->created_at !== null)
                                        {{ date_format(new DateTime($seedbox_data->created_at), 'jS M Y, g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Updated</td>
                                <td class="px-3 py-2">
                                    @if($seedbox_data->updated_at !== null)
                                        {{ date_format(new DateTime($seedbox_data->updated_at), 'jS M Y, g:i a') }}
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
