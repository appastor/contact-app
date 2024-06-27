@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Activity Logs</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Subject Type</th>
                    <th>Subject ID</th>
                    <th>Causer Type</th>
                    <th>Causer ID</th>
                    <th>Properties</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activityLogs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->subject_type }}</td>
                        <td>{{ $log->subject_id }}</td>
                        <td>{{ $log->causer_type }}</td>
                        <td>{{ $log->causer_id }}</td>
                        <td>{{ json_encode($log->properties) }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $activityLogs->links() }}
    </div>
@endsection