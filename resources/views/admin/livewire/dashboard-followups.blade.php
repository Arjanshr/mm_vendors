<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="ion ion-clipboard mr-1"></i>
            Lead Followups
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm">
                {{ $follow_ups->links() }}
            </ul>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <ul class="todo-list" data-widget="todo-list">
            @foreach ($follow_ups as $followup)
                <li>
                    <!-- drag handle -->
                    <span class="handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <!-- checkbox -->
                    <div class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo1" id="followuptodoCheck{{ $followup->id }}"
                            {{ $followup->status == App\Enums\FollowupStatus::COMPLETED || $followup->status == 'Completed'
                                ? 'checked'
                                : '' }} wire:click="completeFollowup({{ $followup->id }})" @cannot('edit-lead-task') disabled @endcannot>
                        <label for="followuptodoCheck{{ $followup->id }}"></label>
                    </div>
                    <span class="text">
                        @can('read-followups')
                            <a href="{{ route('followup.show', [$followup->id, $followup->lead_id]) }}">
                                {{ $followup->date_time }}
                            </a>
                        @else
                            {{ $followup->date_time }}
                        @endcan
                        @can('read-leads')
                            <a href="{{ route('lead.show', $followup->lead->id) }}">
                                ({!! $followup->lead->full_name.'&#8594'.$followup->lead->user->name??'' !!})
                            </a>
                        @else
                            {!! $followup->lead->full_name.'&#8594'.$followup->lead->user->name??'' !!}
                        @endcan
                    </span>
                    <small
                        class="badge badge-{{ $followup->getAlertClass($followup->status, $followup->date_time) }}"><i
                            class="far fa-clock"></i>
                        {{ \Carbon\Carbon::parse($followup->date_time)->diffForHumans() }}</small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                        @can('edit-follow-ups')
                            <a href="{{ route('followup.edit', [$followup->id, $followup->lead_id]) }}"
                                class="btn btn-sm btn-success" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endcan
                        @can('delete-follow-ups')
                            <form method="post"
                                action="{{ route('followup.delete', [$followup->id, $followup->lead_id]) }}"
                                style="display: initial;">
                                @csrf
                                @method('delete')
                                <button class="delete btn btn-danger btn-sm" type="submit" title="Delete" onclick="">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endcan
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <a href="{{ route('followup.create', $lead->id ?? null) }}" class="btn btn-primary float-right">
            <i class="fas fa-plus"></i> Add Followup</button>
        </a>
    </div>
</div>