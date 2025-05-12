<?php

namespace App\Http\Livewire;

use App\Models\LeadTask;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardLeadTasks extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $lead_tasks = LeadTask::orderBy('completed')
        ->orderBy('due_date')
        ->with('lead')
        ->paginate(5,['*'],'lead-tasks');
        return view('livewire.dashboard-lead-tasks',['lead_tasks'=>$lead_tasks]);
    }

    public function completeTask(LeadTask $lead_task)
    {
        $lead_task->completed = $lead_task->getChangeCompletedValue($lead_task->getRawOriginal('completed'));
        $lead_task->save();
    }
    
}
