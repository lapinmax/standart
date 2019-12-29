@extends ('layouts.app')

@section ('content')
    <div class="card">
        <div class="card-header">
            <h3 class="mb-1 float-left">Users</h3>
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-success float-right">Add user
            </a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Login</th>
                    <th scope="col">Sections</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->login }}</td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge badge-success">Admin</span>
                            @else
                                @if($user->horoscopes)
                                    <span class="badge badge-primary">Horoscopes</span>
                                @endif
                                @if($user->clients)
                                    <span class="badge badge-primary">Clients</span>
                                @endif
                                @if($user->chats)
                                    <span class="badge badge-primary">Chats</span>
                                @endif
                                @if($user->templates)
                                    <span class="badge badge-primary">Templates</span>
                                @endif
                                @if($user->users)
                                    <span class="badge badge-primary">Users</span>
                                @endif
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d.m.Y H:i:s') }}</td>
                        <td>
                            <a href="{{ route('users.update', $user->id) }}">Update</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
