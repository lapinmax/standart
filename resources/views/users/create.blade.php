@extends ('layouts.app')

@section ('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-start">
                <div class="mr-3">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-info">Back</a>
                </div>
                <h3>
                    Add user
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form method="post" id="send-form">
                @csrf
                <div class="form-group">
                    <label for="login">Login</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Enter login..."
                           value="{{ old('login') }}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Enter password...">
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="is_admin"
                           name="is_admin" {{ old('is_admin') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_admin">Is admin</label>
                </div>

                <span>OR</span>


                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="horoscopes"
                           name="horoscopes" {{ old('horoscopes') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="horoscopes">Horoscopes</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="clients"
                           name="clients" {{ old('clients') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="clients">Clients</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chats"
                           name="chats" {{ old('chats') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="chats">Chats</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="templates"
                           name="templates" {{ old('templates') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="templates">Templates</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="users"
                           name="users" {{ old('users') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="users">Users</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="rules"
                           name="rules" {{ old('rules') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="rules">Rules</label>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end w-100">
                <button type="submit" form="send-form" class="btn btn-sm btn-outline-success">Create</button>
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
