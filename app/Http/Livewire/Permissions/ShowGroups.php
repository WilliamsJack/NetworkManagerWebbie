<?php

namespace App\Http\Livewire\Permissions;

use App\Models\Permissions\Group;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ShowGroups extends Component
{

    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public ?int $groupId, $rank;
    public ?string $name, $ladder;

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'ladder' => 'required|string',
            'rank' => 'required|integer'
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function showGroup(Group $group)
    {
        $this->groupId = $group->id;
        $this->name = $group->name;
        $this->ladder = $group->ladder;
        $this->rank = $group->rank;
    }

    public function addGroup() {
        $this->resetInput();
    }

    public function createGroup() {
        $validatedData = $this->validate();
        Group::create([
            'name' => $validatedData['name'],
            'ladder' => $validatedData['ladder'],
            'rank' => $validatedData['rank']
        ]);

        session()->flash('message', 'Successfully Created Group');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editGroup(Group $group)
    {
        $this->resetInput();

        $this->groupId = $group->id;
        $this->name = $group->name;
        $this->ladder = $group->ladder;
        $this->rank = $group->rank;
    }

    public function updateGroup()
    {
        $validatedData = $this->validate();

        Group::where('id', $this->groupId)->update([
            'name' => $validatedData['name'],
            'ladder' => $validatedData['ladder'],
            'rank' => $validatedData['rank']
        ]);
        session()->flash('message', 'Group Updated Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteGroup(Group $group) {
        $this->groupId = $group->id;
        $this->name = $group->name;
    }

    public function delete() {
        Group::find($this->groupId)->delete();
        $this->resetInput();
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->groupId = null;
        $this->name = null;
        $this->ladder = null;
        $this->rank = null;
    }

    public function render(): View
    {
        $groups = Group::orderBy('id', 'ASC')->paginate(10);
        return view('livewire.permissions.show-groups')->with('groups', $groups);
    }
}
