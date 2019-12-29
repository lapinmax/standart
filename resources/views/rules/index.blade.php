@extends ('layouts.app')

@section ('content')
    <div class="card">
        <div class="card-header">
            <h3 class="mb-1 float-left">Rules</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Message</th>
                    <th scope="col">Days</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rules as $rule)
                    <tr>
                        <td>{{ $rule->name }}</td>
                        <td>{{ $rule->message }}</td>
                        <td>{{ $rule->days }}</td>
                        <td>
                            @if($rule->active)
                                <span class="badge badge-success">Enabled</span>
                            @else
                                <span class="badge badge-danger">Disabled</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('rules.view', $rule->id) }}">View</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
