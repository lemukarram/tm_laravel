<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Task Manager</title>
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
    rel="stylesheet"
  >
  <style>
    .label-todo       { background: #ffc107; color: #212529; }
    .label-inprogress { background: #17a2b8; color: #fff; }
    .label-done       { background: #28a745; color: #fff; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('tasks.index') }}">Task Manager</a>
    </div>
  </nav>

  <div class="container">
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
  </div>

  <script 
    src="https://code.jquery.com/jquery-3.6.0.min.js">
  </script>
  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>
  @stack('scripts')
</body>
</html>