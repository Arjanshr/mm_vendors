<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="ion ion-clipboard mr-1"></i>
            Lead Tasks
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm">
                {{ $lead_tasks->links() }}
            </ul>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <ul class="todo-list" data-widget="todo-list">
            @foreach ($lead_tasks as $task)
                <li>
                    <!-- drag handle -->
                    <span class="handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <!-- checkbox -->
                    <div class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo1" id="todoCheck{{ $task->id }}"
                            {{ $task->completed == App\Enums\LeadTaskCompleted::COMPLETED || $task->completed == 'Completed'
                                ? 'checked'
                                : '' }}
                            wire:click="completeTask({{ $task->id }})"
                            @cannot('edit-lead-task') disabled @endcannot>
                        <label for="todoCheck{{ $task->id }}"></label>
                    </div>
                    <!-- todo text -->
                    <span class="text">
                        <small>
                            @can('read-lead-tasks')
                                <a href="{{ route('lead-task.show', [$task->lead_id, $task->id]) }}">
                                    {{ $task->task }}
                                </a>
                            @else
                                {{ $task->task }}
                            @endcan
                            @can('read-leads')
                                <a href="{{ route('lead.show', $task->lead->id) }}">
                                    ({{ $task->lead->full_name }})
                                </a>
                            @else
                                {{ $task->lead->full_name }}
                            @endcan
                        </small>
                    </span>

                    <!-- General tools such as edit or delete-->
                    <small>
                        <div class="tools">
                            @can('edit-lead-tasks')
                                <a href="{{ route('lead-task.edit', [$task->lead_id, $task->id]) }}"
                                    class="btn btn-sm btn-success" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('delete-lead-tasks')
                                <form method="post" action="{{ route('lead-task.delete', [$task->lead_id, $task->id]) }}"
                                    style="display: initial;">
                                    @csrf
                                    @method('delete')
                                    <button class="delete btn btn-danger btn-sm" type="submit" title="Delete"
                                        onclick="">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </small>

                    <!-- Emphasis label -->
                    <small
                        class="badge badge-{{ $task->getAlertClass($task->completed, $task->due_date) }} pull-right">
                        <i class="far fa-clock"></i>{{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }}
                    </small>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- /.card-body -->
</div>
