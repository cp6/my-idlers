@section('title') {{$seedbox->title}} {{'Seed box'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Seed box details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $seedbox->title }}</h2>
                    <code>@foreach($labels as $label)
                            @if($loop->last)
                                {{$label->label}}
                            @else
                                {{$label->label}},
                            @endif
                        @endforeach</code>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $seedbox->id }}</h6>
                    @if($seedbox->active !== 1)
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
                                <td>{{ $seedbox->seed_box_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Hostname</td>
                                <td><code>{{ $seedbox_extras[0]->hostname }}</code></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Location</td>
                                <td>{{ $seedbox_extras[0]->location }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Provider</td>
                                <td>{{ $seedbox_extras[0]->provider_name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Price</td>
                                <td>{{ $seedbox_extras[0]->price }} {{ $seedbox_extras[0]->currency }}
                                    <small>{{\App\Process::paymentTermIntToString($seedbox_extras[0]->term)}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Was promo</td>
                                <td>{{ ($seedbox_extras[0]->was_promo === 1) ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Owned since</td>
                                <td>
                                    @if(!is_null($seedbox->owned_since))
                                        {{ date_format(new DateTime($seedbox->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Next due date</td>
                                <td>{{Carbon\Carbon::parse($seedbox_extras[0]->next_due_date)->diffForHumans()}}
                                    ({{Carbon\Carbon::parse($seedbox_extras[0]->next_due_date)->format('d/m/Y')}})
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Inserted</td>
                                <td>
                                    @if(!is_null($seedbox->created_at))
                                        {{ date_format(new DateTime($seedbox->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($seedbox->updated_at))
                                        {{ date_format(new DateTime($seedbox->updated_at), 'jS M y g:i a') }}
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
                                @if($seedbox->disk_as_gb >= 1000)
                                    {{ number_format($seedbox->disk_as_gb / 1000,1) }} <small>TB</small>
                                @else
                                    {{ $seedbox->disk_as_gb }} <small>GB</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Bandwidth</td>
                            <td>
                                @if($seedbox->bandwidth >= 1000)
                                    {{ number_format($seedbox->bandwidth / 1000,1) }} <small>TB</small>
                                @else
                                    {{ $seedbox->bandwidth }} <small>GB</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Port speed</td>
                            <td>
                                @if($seedbox->port_speed >= 1000)
                                    {{ number_format($seedbox->port_speed / 1000,1) }} <small>Gbps</small>
                                @else
                                    {{ $seedbox->port_speed }} <small>Mbps</small>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <a href="{{ route('seedboxes.index') }}"
               class="btn btn-success btn-sm mx-2">
                Go back
            </a>
            <a href="{{ route('seedboxes.edit', $seedbox->id) }}"
               class="btn btn-primary btn-sm mx-2">
                Edit
            </a>
        </x-card>
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>
                    Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}
                    )</small>
            </p>
        @endif
    </div>
</x-app-layout>
