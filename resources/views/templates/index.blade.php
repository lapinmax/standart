@extends ('layouts.app')

@section ('content')
    <div class="card">
        <div class="card-header">
            {{--            <h3 class="mb-1 float-left">Templates</h3>--}}
            <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-chat-tab" data-toggle="pill" href="#pills-chat" role="tab"
                       aria-controls="pills-chat" aria-selected="false">Chat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-push-tab" data-toggle="pill" href="#pills-push" role="tab"
                       aria-controls="pills-push" aria-selected="true">Push</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-chat" role="tabpanel" aria-labelledby="pills-chat-tab">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Message</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                            <th style="width: 10px">
                                <a href="{{ route('templates.chat.create') }}" class="btn btn-sm btn-outline-success">Add</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="sortable" data-type="chat">
                        @foreach($chat as $item)
                            <tr class="pointer" data-id="{{ $item->id }}">
                                <td>{{ $item->message }}</td>
                                <td>{{ $item->created_at->format('d.m.Y H:i:s') }}</td>
                                <td colspan="2">
                                    <a href="{{ route('templates.chat.update', $item->id) }}">Update</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="pills-push" role="tabpanel" aria-labelledby="pills-push-tab">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Message</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                            <th style="width: 10px">
                                <a href="{{ route('templates.push.create') }}" class="btn btn-sm btn-outline-success">Add</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="sortable" data-type="push">
                        @foreach($push as $item)
                            <tr class="pointer" data-id="{{ $item->id }}">
                                <td>{{ $item->message }}</td>
                                <td>{{ $item->created_at->format('d.m.Y H:i:s') }}</td>
                                <td colspan="2">
                                    <a href="{{ route('templates.push.update', $item->id) }}">Update</a>
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

@section('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('.sortable').sortable({
                update: function (event, ui) {
                    var main = $(event.target);
                    var url;
                    var ids = [];

                    main.find('tr').each(function (index, el) {
                        ids.push($(el).data('id'));
                    });

                    if (main.data('type') == 'push') {
                        url = @json(route('templates.push.sort'));
                    } else if (main.data('type') == 'chat') {
                        url = @json(route('templates.chat.sort'));
                    }

                    ajax({
                        url: url,
                        method: 'post',
                        data: {ids: ids}
                    });
                }
            });
        })
    </script>
@endsection
