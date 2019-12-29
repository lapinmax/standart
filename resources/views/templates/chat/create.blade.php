@extends ('layouts.app')

@section ('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-start">
                <div class="mr-3">
                    <a href="{{ route('templates.index') }}" class="btn btn-sm btn-outline-info">Back</a>
                </div>
                <h3>
                    Add template
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form method="post" id="send-form">
                @csrf
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" placeholder="Enter message..." rows="3" name="message"
                              id="message">{{ old("message") }}</textarea>
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
