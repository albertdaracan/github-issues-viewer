@extends('layouts.app')

@section('content')
    <a href="{{ route('issues.index') }}" class="btn btn-secondary mb-3">
        ← Back to Issues
    </a>

    <div class="card">
        <div class="card-body">
            <?php 
            echo "<pre>";
            var_dump($issue);
            echo "</pre>";
            ?>
            <h3>#{{ $issue['number'] }} — {{ $issue['title'] }}</h3>

            <small class="text-muted">
                Created: {{ \Carbon\Carbon::parse($issue['created_at'])->format('M d, Y H:i') }}
            </small>

            <hr>

            <div style="white-space: pre-wrap;">
                <form method="POST" action="/updateIssue">
                    @csrf
                    <input type="hidden" name="id" value="<?php echo $issue['id'];  ?>" />
                    {{-- <input type="hidden" name="owner" value="{{ $issue['login']}}"/> --}}
                    {{-- <input type="hidden" name="repo" value="{{ $issue['repository']['name'] }}"/> --}}
                    <input type="hidden" name="issue_number" value="{{ $issue['number'] }}" />
                    <textarea name="body">{{ $issue['body'] ?? 'No description provided.' }}</textarea>
                    <button type="submit">submit</button>
                </form>
            </div>

        </div>
    </div>
@endsection