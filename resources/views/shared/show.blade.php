@section('title') {{$shared->main_domain}} {{'shared'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Share hosting details') }}
    </x-slot>
    <div class="container">
        <div class="card shadow mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="'col-12 col-lg-6">
                        <div class="table-responsive">
                            <table class="table table-borderless text-nowrap">
                                <tbody>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Labels</td>
                                    <td>
                                        @foreach($labels as $label)
                                            @if($loop->last)
                                                {{$label->label}}
                                            @else
                                                {{$label->label}},
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Id</td>
                                    <td>{{ $shared->id }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Main domain</td>
                                    <td>{{ $shared->main_domain }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Location</td>
                                    <td>{{ $shared_extras[0]->location }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Provider</td>
                                    <td>{{ $shared_extras[0]->provider_name }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Price</td>
                                    <td>{{ $shared_extras[0]->price }} {{ $shared_extras[0]->currency }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Term</td>
                                    <td>{{ \App\Process::paymentTermIntToString($shared_extras[0]->term) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Has dedicated IP?</td>
                                    <td>{{ ($shared->has_dedicated_ip)? 'Yes': 'No' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">IP</td>
                                    <td>{{ $shared->ip }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Owned since</td>
                                    <td>
                                        @if(!is_null($shared->owned_since))
                                            {{ date_format(new DateTime($shared->owned_since), 'jS F Y') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Next due date</td>
                                    <td>
                                        @if(!is_null($shared_extras[0]->next_due_date))
                                            {{ date_format(new DateTime($shared_extras[0]->next_due_date), 'jS F Y') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Created on</td>
                                    <td>{{ date_format($shared->created_at, 'jS F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Last updated</td>
                                    <td>{{ date_format($shared->updated_at, 'jS F Y') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="'col-12 col-lg-6">
                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <td class="px-4 py-2 font-bold">Disk GB</td>
                                <td>{{$shared->disk_as_gb}}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">Bandwidth GB</td>
                                <td>{{$shared->bandwidth}}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">Domains Limit</td>
                                <td>{{$shared->domains_limit}}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">Subdomains Limit</td>
                                <td>{{$shared->subdomains_limit}}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">Email Limit</td>
                                <td>{{$shared->email_limit}}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">DB Limit</td>
                                <td>{{$shared->db_limit}}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">FTP Limit</td>
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
            </div>
        </div>
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>
                    Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}
                    )</small>
            </p>
        @endif
    </div>
</x-app-layout>
