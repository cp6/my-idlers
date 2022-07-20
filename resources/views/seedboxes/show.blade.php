@section('title') {{$seedbox_data->title}} {{'Seed box'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Seed box details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $seedbox_data->title }}</h2>
                    @foreach($seedbox_data->labels as $label)
                        <span class="badge bg-primary mx-1">{{$label->label->label}}</span>
                    @endforeach
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $seedbox_data->id }}</h6>
                    @if($seedbox_data->active !== 1)
                        <h6 class="text-danger pe-lg-4">not active</h6>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="'col-12 col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Type</td>
                                <td>{{ $seedbox_data->seed_box_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Hostname</td>
                                <td><code>{{ $seedbox_data->hostname }}</code></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Location</td>
                                <td>{{ $seedbox_data->location->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Provider</td>
                                <td>{{ $seedbox_data->provider->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Price</td>
                                <td>{{ $seedbox_data->price->price }} {{ $seedbox_data->price->currency }}
                                    <small>{{\App\Process::paymentTermIntToString($seedbox_data->price->term)}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Was promo</td>
                                <td>{{ ($seedbox_data->was_promo === 1) ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Owned since</td>
                                <td>
                                    @if(!is_null($seedbox_data->owned_since))
                                        {{ date_format(new DateTime($seedbox_data->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Next due date</td>
                                <td>{{Carbon\Carbon::parse($seedbox_data->price->next_due_date)->diffForHumans()}}
                                    ({{Carbon\Carbon::parse($seedbox_data->price->next_due_date)->format('d/m/Y')}})
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Inserted</td>
                                <td>
                                    @if(!is_null($seedbox_data->created_at))
                                        {{ date_format(new DateTime($seedbox_data->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($seedbox_data->updated_at))
                                        {{ date_format(new DateTime($seedbox_data->updated_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="'col-12 col-lg-6">
                    <table class="table table-borderless">
                        <tbody>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Disk</td>
                            <td>
                                @if($seedbox_data->disk_as_gb >= 1000)
                                    {{ number_format($seedbox_data->disk_as_gb / 1000,1) }} <small>TB</small>
                                @else
                                    {{ $seedbox_data->disk_as_gb }} <small>GB</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Bandwidth</td>
                            <td>
                                @if($seedbox_data->bandwidth >= 1000)
                                    {{ number_format($seedbox_data->bandwidth / 1000,1) }} <small>TB</small>
                                @else
                                    {{ $seedbox_data->bandwidth }} <small>GB</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Port speed</td>
                            <td>
                                @if($seedbox_data->port_speed >= 1000)
                                    {{ number_format($seedbox_data->port_speed / 1000,1) }} <small>Gbps</small>
                                @else
                                    {{ $seedbox_data->port_speed }} <small>Mbps</small>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <x-back-btn>
                <x-slot name="route">{{ route('seedboxes.index') }}</x-slot>
            </x-back-btn>
            <x-edit-btn>
                <x-slot name="route">{{ route('seedboxes.edit', $seedbox_data->id) }}</x-slot>
            </x-edit-btn>
        </x-card>
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>
                    Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}
                    )</small>
            </p>
        @endif
    </div>
</x-app-layout>
