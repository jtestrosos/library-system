@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Reports</h1>
        <a href="{{ route('reports.date_wise') }}" class="btn btn-primary mb-3">Date-Wise Report</a>
        <a href="{{ route('reports.month_wise') }}" class="btn btn-primary mb-3">Monthly Report</a>
        <a href="{{ route('reports.not_returned') }}" class="btn btn-primary mb-3">Not Returned</a>
    </div>
@endsection