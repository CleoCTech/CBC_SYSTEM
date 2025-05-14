@extends('layouts.master')
@section('page_title', 'SMS')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Manage SMS </h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">


        <div class="tab-content">
            <div class="tab-pane fade show active" id="all-sms">
                <table class="table datatable-button-html5-columns">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Receiver</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Response Status</th>
                            <th>Response Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $message->receiver }}</td>
                                <td>{{ $message->message }}</td>
                                <td>{{ ucwords($message->status) }}</td>
                                <td>{{ $message->response_status }}</td>
                                <td>{{ ucwords($message->response_message) }}</td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-left">
                                                {{-- Edit --}}
                                                <a href="{{ route('sms.edit', $message->id) }}"
                                                    class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                {{-- Delete --}}
                                                <a id="{{ $message->id }}" onclick="confirmDelete(this.id)"
                                                    href="#" class="dropdown-item"><i class="icon-trash"></i>
                                                    Delete</a>
                                                <form method="post" id="item-delete-{{ $message->id }}"
                                                    action="{{ route('sms.destroy', $message->id) }}"
                                                    class="hidden">@csrf @method('delete')</form>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
