@extends ('layouts.app')

@section ('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-start">
                <div class="mr-3">
                    <a href="{{ route('templates.index') }}" class="btn btn-sm btn-outline-info">Back</a>
                </div>
                <h3>
                    Update template
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form method="post" id="send-form">
                @csrf
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" placeholder="Enter message..." rows="3" name="message"
                              id="message">{{ old("message") ?? $template->message }}</textarea>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between w-100">
                <a href="{{ route('templates.push.delete', $template->id) }}"
                   class="btn btn-sm btn-outline-danger">Delete</a>
                <button type="submit" form="send-form" class="btn btn-sm btn-outline-success">Update</button>
            </div>
        </div>
    </div>
@endsection
