@extends('layouts.app')

@section('content')
  <h2>New Task</h2>
  <form 
    action="{{ route('tasks.store') }}" 
    method="POST" 
    enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label class="form-label">Title</label>
      <input 
        type="text" 
        name="title" 
        class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title') }}">
      @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea 
        name="description" 
        class="form-control">{{@old('description')}}</textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Attachment</label>
      <input 
        type="file" 
        name="attachment" 
        class="form-control @error('attachment') is-invalid @enderror">
      @error('attachment')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-success">Save Task</button>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
@endsection