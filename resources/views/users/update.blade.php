@extends ('layouts.app')

@section ('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-start">
                <div class="mr-3">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-info">Back</a>
                </div>
                <h3>
                    Change {{ $user->login }}
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form method="post" id="send-form">
                @csrf
                <div class="form-group">
                    <label for="login">Login</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Enter login..."
                           value="{{ old('login') ?? $user->login }}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Enter password for change...">
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="is_admin"
                           name="is_admin" {{ old('is_admin') ? 'checked' : ($user->is_admin ? 'checked' : '') }}>
                    <label class="custom-control-label" for="is_admin">Is admin</label>
                </div>

                <span>OR</span>


                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="horoscopes"
                           name="horoscopes" {{ old('horoscopes') ? 'checked' : ($user->horoscopes ? 'checked' : '') }}>
                    <label class="custom-control-label" for="horoscopes">Horoscopes</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="clients"
                           name="clients" {{ old('clients') ? 'checked' : ($user->clients ? 'checked' : '') }}>
                    <label class="custom-control-label" for="clients">Clients</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chats"
                           name="chats" {{ old('chats') ? 'checked' : ($user->chats ? 'checked' : '') }}>
                    <label class="custom-control-label" for="chats">Chats</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="templates"
                           name="templates" {{ old('templates') ? 'checked' : ($user->templates ? 'checked' : '') }}>
                    <label class="custom-control-label" for="templates">Templates</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="users"
                           name="users" {{ old('users') ? 'checked' : ($user->users ? 'checked' : '') }}>
                    <label class="custom-control-label" for="users">Users</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="rules"
                           name="rules" {{ old('rules') ? 'checked' : ($user->rules ? 'checked' : '') }}>
                    <label class="custom-control-label" for="rules">Rules</label>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between w-100">
                <a href="{{ route('users.delete', $user->id) }}"
                   class="btn btn-sm btn-outline-danger {{ $user->is_admin ? 'disabled' : '' }}">Delete</a>
                <button type="submit" form="send-form" class="btn btn-sm btn-outline-success">Update</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            location.href = '#last';
        });
    </script>
@endsection
