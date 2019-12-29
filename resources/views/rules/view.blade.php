@extends ('layouts.app')

@section ('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-start">
                <div class="mr-3">
                    <a href="{{ route('rules.index') }}" class="btn btn-sm btn-outline-info">Back</a>
                </div>
                <h3>
                    View rule
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form method="post" id="send-form">
                @csrf
                <div class="form-group">
                    <label for="name">Title</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter title..."
                           value="{{ old('name') ?? $rule->name }}">
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" placeholder="Enter message..." rows="3" name="message"
                              id="message">{{ old("message") ?? $rule->message }}</textarea>
                </div>
                <div class="form-group">
                    <label for="days">Days</label>
                    <input type="text" class="form-control" id="days" name="days" placeholder="Enter days..."
                           value="{{ old('days') ?? $rule->days }}">
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input pointer" id="active" name="active"
                        {{ old('active') ? 'checked' : ($rule->active ? 'checked' : '') }}>
                    <label class="custom-control-label pointer" for="active">Active</label>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between w-100">
                <button type="submit" form="send-form" class="btn btn-sm btn-outline-success">Save</button>
            </div>
        </div>
    </div>
@endsection
