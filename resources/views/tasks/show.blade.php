<!-- resources/views/tasks/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">{{ $task->title }}</div>

                <div class="card-body">
                    <p><strong>Description:</strong> {{ $task->description }}</p>
                    <p><strong>Status:</strong> {{ $task->status }}</p>
                    <p><strong>Created at:</strong> {{ $task->created_at->format('d/m/Y H:i:s') }}</p>
                    <p><strong>Updated at:</strong> {{ $task->updated_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
