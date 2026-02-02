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

        <div class="detail-card">
            <div class="detail-section">
                <div class="detail-grid">
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Seedbox Details</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Type</span>
                                    <span class="detail-value">{{ $seedbox_data->seed_box_type }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Location</span>
                                    <span class="detail-value">{{ $seedbox_data->location->name }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">Hostname</span>
                                    <span class="detail-value"><code>{{ $seedbox_data->hostname }}</code></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Provider</span>
                                    <span class="detail-value">{{ $seedbox_data->provider->name }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Price</span>
                                    <span class="detail-value">{{ $seedbox_data->price->price }} {{ $seedbox_data->price->currency }} <span class="text-muted">{{ \App\Process::paymentTermIntToString($seedbox_data->price->term) }}</span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Next Due</span>
                                    <span class="detail-value">{{ Carbon\Carbon::parse($seedbox_data->price->next_due_date)->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Was Promo</span>
                                    <span class="detail-value">{{ ($seedbox_data->was_promo === 1) ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="detail-label">Owned Since</span>
                                    <span class="detail-value">{{ $seedbox_data->owned_since !== null ? date_format(new DateTime($seedbox_data->owned_since), 'jS M Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-section-header">
                            <h6 class="detail-section-title">Specifications</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">Disk</span>
                                    <span class="detail-value">@if($seedbox_data->disk_as_gb >= 1000){{ number_format($seedbox_data->disk_as_gb / 1000, 1) }} TB @else {{ $seedbox_data->disk_as_gb }} GB @endif</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">Bandwidth</span>
                                    <span class="detail-value">@if($seedbox_data->bandwidth >= 1000){{ number_format($seedbox_data->bandwidth / 1000, 1) }} TB @else {{ $seedbox_data->bandwidth }} GB @endif</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">Port Speed</span>
                                    <span class="detail-value">@if($seedbox_data->port_speed >= 1000){{ number_format($seedbox_data->port_speed / 1000, 1) }} Gbps @else {{ $seedbox_data->port_speed }} Mbps @endif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-footer">
                ID: <code>{{ $seedbox_data->id }}</code> &middot;
                Created: {{ $seedbox_data->created_at !== null ? date_format(new DateTime($seedbox_data->created_at), 'jS M Y, g:i a') : '-' }} &middot;
                Updated: {{ $seedbox_data->updated_at !== null ? date_format(new DateTime($seedbox_data->updated_at), 'jS M Y, g:i a') : '-' }}
            </div>
        </div>
    </div>
</x-app-layout>
