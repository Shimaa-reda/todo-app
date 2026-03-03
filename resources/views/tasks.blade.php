<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Todo List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">

        <h1 class="mb-4 text-center">Todo List</h1>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <div class="card mb-4">
            <div class="card-header">
                {{ $editingTask ? 'Edit Task' : 'Add New Task' }}
            </div>
            <div class="card-body">
                <form
                    action="{{ $editingTask ? route('tasks.update', $editingTask) : route('tasks.store') }}"
                    method="POST">
                    @csrf
                    @if($editingTask)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            value="{{ old('title', $editingTask?->title) }}"
                            placeholder="Task title">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea
                            name="description"
                            class="form-control"
                            rows="2"
                            placeholder="Description (optional)">{{ old('description', $editingTask?->description) }}</textarea>
                    </div>

                    @if($editingTask)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox"
                            name="is_completed" id="is_completed"
                            {{ $editingTask->is_completed ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_completed">
                            Completed
                        </label>
                    </div>
                    @endif

                    <button type="submit" class="btn btn-primary">
                        {{ $editingTask ? 'Update Task' : 'Add Task' }}
                    </button>

                    @if($editingTask)
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    @endif
                </form>
            </div>
        </div>

        <div class="row g-3">
            @forelse ($tasks as $task)
            <div class="col-sm-12 col-md-6 col-lg-4 d-flex">
                <div class="card flex-fill {{ $task->is_completed ? 'border-success' : '' }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title {{ $task->is_completed ? 'text-decoration-line-through text-muted' : '' }}">
                            {{ $task->title }}
                        </h5>
                        @if($task->description)
                        <p class="card-text {{ $task->is_completed ? 'text-muted' : '' }}">
                            {{ $task->description }}
                        </p>
                        @endif

                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <!-- toggle statues  -->
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="btn btn-sm {{ $task->is_completed ? 'btn-outline-secondary' : 'btn-outline-success' }}">
                                    {{ $task->is_completed ? 'Mark as Pending' : 'Mark as Done' }}
                                </button>
                            </form>

                            <div class="d-flex gap-2">
                                <a href="{{ route('tasks.edit', $task) }}"
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                                <!-- delete form -->
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-2">Delete</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-muted">No tasks yet.</p>
            @endforelse
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
