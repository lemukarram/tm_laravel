@extends('layouts.app')

@section('content')
        <!-- Filter Section -->
        <div class="filter-container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h2 class="h5 mb-0">All Tasks</h2>
                </div>
                <div class="col-md-6">
                    <div class="desktop-only">
                        <div class="d-flex align-items-center">
                            <span class="me-2 text-muted">Filter:</span>
                            <select id="status-filter" class="form-select w-auto">
                                <option value="">All Statuses</option>
                                <option value="todo" @selected($status=='todo') style="background-color: #ffc107; color: #212529;">To Do</option>
                                <option value="inprogress" @selected($status=='inprogress') style="background-color: #17a2b8; color: #fff;">In Progress</option>
                                <option value="done" @selected($status=='done') style="background-color: #28a745; color: #fff;">Done</option>
                            </select>
                        </div>
                    </div>
                    <div class="mobile-only">
                        <button class="mobile-filter-btn" data-bs-toggle="collapse" data-bs-target="#mobileFilter">
                            <i class="fas fa-filter me-2"></i>Filter Tasks
                        </button>
                        <div class="collapse mt-2" id="mobileFilter">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-secondary text-start" data-filter="">
                                    <i class="fas fa-list me-2"></i>All Tasks
                                </button>
                                <button class="btn btn-outline-warning text-start" data-filter="todo">
                                    <i class="fas fa-clock me-2"></i>To Do
                                </button>
                                <button class="btn btn-outline-info text-start" data-filter="inprogress">
                                    <i class="fas fa-spinner me-2"></i>In Progress
                                </button>
                                <button class="btn btn-outline-success text-start" data-filter="done">
                                    <i class="fas fa-check me-2"></i>Done
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="desktop-only">
            <div class="table-responsive rounded-3">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Attachment</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-tasks me-3 text-muted"></i>
                                        <div>
                                            <div class="fw-medium">{{ $task->title }}</div>
                                            <div class="text-muted small">Created: {{ \Carbon\Carbon::parse($task->created_at)->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge badge-{{ $task->status }} text-uppercase">
                                        @if($task->status == 'todo')
                                            <i class="fas fa-clock me-1"></i>
                                        @elseif($task->status == 'inprogress')
                                            <i class="fas fa-spinner me-1"></i>
                                        @else
                                            <i class="fas fa-check me-1"></i>
                                        @endif
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($task->attachment)
                                        <a href="{{ asset('storage/'.$task->attachment) }}" target="_blank" class="attachment-badge">
                                            <i class="fas fa-paperclip me-1"></i> View
                                        </a>
                                    @else
                                        <span class="text-muted small">None</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div>
                                        <h3 class="h5">No tasks found</h3>
                                        <p class="text-muted">Get started by creating a new task</p>
                                        <a href="{{ route('tasks.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus me-1"></i> Create Task
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="mobile-only">
            @forelse ($tasks as $task)
                <div class="task-card {{ $task->status }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $task->title }}</h5>
                            <span class="status-badge badge-{{ $task->status }}">
                                @if($task->status == 'todo')
                                    <i class="fas fa-clock me-1"></i>
                                @elseif($task->status == 'inprogress')
                                    <i class="fas fa-spinner me-1"></i>
                                @else
                                    <i class="fas fa-check me-1"></i>
                                @endif
                                {{ ucfirst($task->status) }}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="text-muted small mb-1">
                                <i class="far fa-calendar me-1"></i> 
                                Created: {{ \Carbon\Carbon::parse($task->created_at)->format('M d, Y') }}
                            </div>
                            
                            @if($task->attachment)
                                <div>
                                    <a href="{{ asset('storage/'.$task->attachment) }}" target="_blank" class="attachment-badge">
                                        <i class="fas fa-paperclip me-1"></i> Attachment
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="h5">No tasks found</h3>
                    <p class="text-muted">Get started by creating a new task</p>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-1"></i> Create Task
                    </a>
                </div>
            @endforelse
        </div>
        
        <!-- Mobile Floating Action Button -->
        <div class="mobile-only mobile-actions">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
            </a>
        </div>
@endsection
@push('scripts')
<script>
// Desktop filter functionality
$('#status-filter').on('change', function() {
    let status = $(this).val();
    let url    = '{{ route("tasks.index") }}';
    window.location = status 
      ? `${url}?status=${status}` 
      : url;
  });
        
        // Mobile filter functionality
        document.querySelectorAll('.mobile-only [data-filter]').forEach(button => {
            button.addEventListener('click', function() {
                let status = this.getAttribute('data-filter');
                let url = '{{ route("tasks.index") }}';
                window.location = status ? `${url}?status=${status}` : url;
            });
        });
</script>
@endpush
