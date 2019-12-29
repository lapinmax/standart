@extends ('layouts.app')

@section ('content')
    <div class="card">
        <div class="card-header">
            <h3 class="mb-1 float-left">Chats</h3>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-new-tab" data-toggle="pill" href="#pills-new" role="tab"
                       aria-controls="pills-new" aria-selected="true">New</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-archive-tab" data-toggle="pill" href="#pills-archive" role="tab"
                       aria-controls="pills-archive" aria-selected="false">Archive</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name / Email</th>
                            <th scope="col">Message</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($new as $chat)
                            <tr>
                                <th scope="row">{{ is_null($chat->client->name) ? $chat->client->email : $chat->client->name }}</th>
                                <td>{{ $chat->messages->last()->message }}</td>
                                <td>{{ $chat->messages->last()->created_at->format('d.m.Y H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('chats.view', $chat->id) }}">View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="tab-pane fade" id="pills-archive" role="tabpanel" aria-labelledby="pills-archive-tab">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name / Email</th>
                            <th scope="col">Message</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($archive as $chat)
                            <tr>
                                <th scope="row">{{ is_null($chat->client->name) ? $chat->client->email : $chat->client->name }}</th>
                                <td>{{ $chat->messages->last()->message }}</td>
                                <td>{{ $chat->messages->last()->created_at->format('d.m.Y H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('chats.view', $chat->id) }}">View</a>
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
