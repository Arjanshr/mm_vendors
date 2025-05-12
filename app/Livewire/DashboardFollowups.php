<?php

namespace App\Http\Livewire;

use App\Models\FollowUp;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardFollowups extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $followups = FollowUp::orderBy('status')
            ->orderBy('followup_date')
            ->orderBy('followup_time')
            ->with('lead')
            ->paginate(10, ['*'], 'followups');
        return view('livewire.dashboard-followups', ['follow_ups' => $followups]);
    }

    public function completeFollowup(Followup $follow_up)
    {
        $follow_up->status = $follow_up->getChangeStatusValue($follow_up->getRawOriginal('status'));
        $follow_up->save();
    }
}
