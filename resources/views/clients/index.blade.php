@extends('layouts.app')

@section('content')
    <h5>
        Export clients to Excel
    </h5>
    <a href="{{ route('clients.export') }}" class="btn btn-lg btn-success w-100 mt-4">Download Excel</a>
@endsection
