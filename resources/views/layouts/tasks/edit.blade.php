@extends('layouts.app')

@section('content')
  <h2>Edit Task</h2>
  <form 
    action="{{ route('tasks.update', $task) }}" 
    method="POST" 
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Title</label>
      <input 
        type="text" 
        name="title" 
        class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title', $task->title) }}">
      @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea 
        name="description" 
        class="form-control">@old('description', $task->description)</textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Status</label>
      <select 
        name="status" 
        class="form-select @error('status') is-invalid @enderror">
        <option value="todo"       @selected($task->status=='todo')>To Do</option>
        <option value="inprogress" @selected($task->status=='inprogress')>In Progress</option>
        <option value="done"       @selected($task->status=='done')>Done</option>
      </select>
      @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Attachment</label>
      @if($task->attachment)
        <p>
          Current: 
          <a 
            href="{{ asset('storage/'.$task->attachment) }}" 
            target="_blank">
            View
          </a>
        </p>
      @endif
      <input 
        type="file" 
        name="attachment" 
        class="form-control @error('attachment') is-invalid @enderror">
      @error('attachment')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-primary">Update Task</button>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
@endsection