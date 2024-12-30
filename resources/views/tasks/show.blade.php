@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Task Details</h1>
    <div class="mb-3">
        <h3>Title</h3>
        <p>{{ $task->title }}</p>
    </div>
    <div class="mb-3">
        <h3>Description</h3>
        <p>{{ $task->description }}</p>
    </div>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Tasks</a>
</div>
@endsection
