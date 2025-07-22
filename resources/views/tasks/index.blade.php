@extends('layouts.app')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>All Tasks</h2>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">New Task</a>
  </div>

  <div class="mb-3">
  <select id="status-filter" class="form-select w-auto d-inline-block">
    <option value="" style="background-color: transparent; color: #000;">
      All Statuses
    </option>
    <option 
      value="todo" 
      @selected($status=='todo') 
      style="background-color: #ffc107; color: #212529;"
    >
      To Do
    </option>
    <option 
      value="inprogress" 
      @selected($status=='inprogress') 
      style="background-color: #17a2b8; color: #fff;"
    >
      In Progress
    </option>
    <option 
      value="done" 
      @selected($status=='done') 
      style="background-color: #28a745; color: #fff;"
    >
      Done
    </option>
  </select>
</div>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Attachment</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($tasks as $task)
        <tr>
          <td>{{ $task->title }}</td>
          <td>
            <span class="badge 
              label-{{ $task->status }}">
              {{ ucfirst($task->status) }}
            </span>
          </td>
          <td>
            @if($task->attachment)
              <a 
                href="{{ asset('storage/'.$task->attachment) }}" 
                target="_blank">
                View
              </a>
            @endif
          </td>
          <td>
            <a 
              href="{{ route('tasks.edit', $task) }}" 
              class="btn btn-sm btn-warning">
              Edit
            </a>
            <form 
              action="{{ route('tasks.destroy', $task) }}" 
              method="POST" 
              class="d-inline"
              onsubmit="return confirm('Delete this task?')">
              @csrf
              @method('DELETE')
              <button 
                class="btn btn-sm btn-danger">
                Delete
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center">No tasks found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection

@push('scripts')
<script>
  $('#status-filter').on('change', function() {
    let status = $(this).val();
    let url    = '{{ route("tasks.index") }}';
    window.location = status 
      ? `${url}?status=${status}` 
      : url;
  });
</script>
@endpush