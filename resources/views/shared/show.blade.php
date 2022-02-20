@section('title') {{$shared->main_domain}} {{'shared'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Share hosting details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $shared->main_domain }}</h2>
                    <code>@foreach($labels as $label)
                            @if($loop->last)
                                {{$label->label}}
                            @else
                                {{$label->label}},
                            @endif
                        @endforeach</code>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $shared->id }}</h6>
                    @if($shared->active !== 1)
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
                                <td>{{ $shared->shared_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Location</td>
                                <td>{{ $shared_extras[0]->location }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Provider</td>
                                <td>{{ $shared_extras[0]->provider_name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Price</td>
                                <td>{{ $shared_extras[0]->price }} {{ $shared_extras[0]->currency }}
                                    <small>{{\App\Process::paymentTermIntToString($shared_extras[0]->term)}}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Was promo</td>
                                <td>{{ ($shared_extras[0]->was_promo === 1) ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Has dedicated IP?</td>
                                <td>{{ ($shared->has_dedicated_ip)? 'Yes': 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">IP</td>
                                <td>{{ $shared->ip }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Owned since</td>
                                <td>
                                    @if(!is_null($shared->owned_since))
                                        {{ date_format(new DateTime($shared->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Next due date</td>
                                <td>{{Carbon\Carbon::parse($shared_extras[0]->next_due_date)->diffForHumans()}}
                                    ({{Carbon\Carbon::parse($shared_extras[0]->next_due_date)->format('d/m/Y')}})
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Inserted</td>
                                <td>
                                    @if(!is_null($shared->created_at))
                                        {{ date_format(new DateTime($shared->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($shared->updated_at))
                                        {{ date_format(new DateTime($shared->updated_at), 'jS M y g:i a') }}
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
                            <td class="px-2 py-2 font-bold text-muted">Disk GB</td>
                            <td>{{$shared->disk_as_gb}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Bandwidth GB</td>
                            <td>{{$shared->bandwidth}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Domains Limit</td>
                            <td>{{$shared->domains_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Subdomains Limit</td>
                            <td>{{$shared->subdomains_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">Email Limit</td>
                            <td>{{$shared->email_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">DB Limit</td>
                            <td>{{$shared->db_limit}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 font-bold text-muted">FTP Limit</td>
                            <td>{{$shared->ftp_limit}}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <a href="{{ route('shared.index') }}"
               class="btn btn-success btn-sm mx-2">
                Go back
            </a>
            <a href="{{ route('shared.edit', $shared->id) }}"
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
