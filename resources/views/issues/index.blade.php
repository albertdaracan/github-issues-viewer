@extends('layouts.app')

@section('content')
<div class="container mt-4">

    @if (!empty($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @else

        <h2>Assigned Open Issues</h2>

        @if (empty($issues))
            <p class="text-muted mt-3">No open assigned issues found.</p>
        @else
            <div class="list-group">

        @foreach ($issues as $issue)
            <?php
            //var_dump()
            if(!array_search('wontfix', array_column($issue['labels'], 'name')) !== FALSE) {
                ?>
                     <a href="{{ route('issues.show', [
                'owner' => $issue['repository']['owner']['login'],
                'repo' => $issue['repository']['name'],
                'issue' => $issue['number']
            ]) }}"
               class="list-group-item list-group-item-action">

                <div class="d-flex justify-content-between">
                    <h5>#{{ $issue['number'] }} — {{ $issue['title'] }}</h5>
                    <small>{{ \Carbon\Carbon::parse($issue['created_at'])->format('M d, Y') }}</small>
                </div>

                <small class="text-muted">
                    {{ $issue['repository']['owner']['login'] }}/{{ $issue['repository']['name'] }}
                </small>
            </a>
                
            <?php } 
            ?>
                
           
        @endforeach

    </div>
        @endif

    @endif

</div>
@endsection

