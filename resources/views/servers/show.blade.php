@section('title') {{$server->hostname}} {{'server'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Server details') }}
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
                                    <td>{{ $server->id }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Name</td>
                                    <td>{{ $server->hostname }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">OS</td>
                                    <td>{{ $server->osIdAsString((string)$server->os_id) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Location</td>
                                    <td>{{ $server_extras[0]->location }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Provider</td>
                                    <td>{{ $server_extras[0]->provider_name }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Ipv4</td>
                                    <td><code>{{ $server->ipv4 }}</code></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Ipv6</td>
                                    <td><code>{{ $server->ipv6 }}</code></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Price</td>
                                    <td>{{ $server_extras[0]->price }} {{ $server_extras[0]->currency }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Term</td>
                                    <td>{{ $server_extras[0]->term }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">NS1</td>
                                    <td>{{ $server->ns1 }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">NS2</td>
                                    <td>{{ $server->ns2 }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Server type</td>
                                    <td>{{ $server->serviceServerType($server->server_type) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Owned since</td>
                                    <td>
                                        @if(!is_null($server->owned_since))
                                            {{ date_format(new DateTime($server->owned_since), 'jS F Y') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Next due date</td>
                                    <td>
                                        @if(!is_null($server_extras[0]->next_due_date))
                                            {{ date_format(new DateTime($server_extras[0]->next_due_date), 'jS F Y') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Created on</td>
                                    <td>{{ date_format($server->created_at, 'jS F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Last updated</td>
                                    <td>{{ date_format($server->updated_at, 'jS F Y') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="'col-12 col-lg-6">
                        <!--
                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <td class="px-4 py-2 font-bold">CPU</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">Disk</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">Ram</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">Bandwidth</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">GB5 single / multi</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">GB5 id</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Disk speeds:</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">4k</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">64k</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">512k</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-bold">1m</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Network speed (location|send|receive):</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">London 984<small>MBps</small> 652<small>MBps</small></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">New York 984<small>MBps</small> 652<small>MBps</small></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Los Angeles 984<small>MBps</small> 652<small>MBps</small></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Singapore 984<small>MBps</small> 652<small>MBps</small></td>
                            </tr>
                            </tbody>
                        </table>
                        -->
                    </div>
                </div>
                <a href="{{ route('servers.index') }}"
                   class="btn btn-success btn-sm mx-2">
                    Go back
                </a>
                <a href="{{ route('servers.edit', $server->id) }}"
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
