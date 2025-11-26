@extends('layouts.app')

@section('content')
    <a href="{{ route('issues.index') }}" class="btn btn-secondary mb-3">
        ← Back to Issues
    </a>

    <div class="card">
        <div class="card-body">

            <h3>#{{ $issue['number'] }} — {{ $issue['title'] }}</h3>

            <small class="text-muted">
                Created: {{ \Carbon\Carbon::parse($issue['created_at'])->format('M d, Y H:i') }}
            </small>

            <hr>

            <div style="white-space: pre-wrap;">
                {{ $issue['body'] ?? 'No description provided.' }}
            </div>

        </div>
    </div>
@endsection