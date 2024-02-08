<?php

namespace App\Http\Livewire\Permissions;

use App\Models\Permissions\Group;
use App\Models\Permissions\GroupPermission;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ShowGroupPermissions extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public ?int $permissionId;

    public ?string $permission;

    public ?string $world;

    public ?string $server;

    public ?string $expires;

    public Group $group;

    public string $search = '';

    protected function rules()
    {
        return [
            'permission' => 'required|string',
            'world' => 'string|nullable',
            'server' => 'string|nullable',
            'expires' => 'date|nullable',
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function addGroupPermission(): void
    {
        $this->resetInput();
    }

    public function createGroupPermission()
    {
        $validatedData = $this->validate();
        $server = empty($validatedData['server']) ? '' : $validatedData['server'];
        $world = empty($validatedData['world']) ? '' : $validatedData['world'];
        $expires = empty($validatedData['expires']) ? null : $validatedData['expires'];

        GroupPermission::create([
            'groupid' => $this->group->id,
            'permission' => $validatedData['permission'],
            'server' => $server,
            'world' => $world,
            'expires' => $expires,
        ]);

        session()->flash('message', 'Successfully Created Group Permission');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editGroupPermission(GroupPermission $groupPermission)
    {
        $this->resetInput();

        $this->permissionId = $groupPermission->id;
        $this->permission = $groupPermission->permission;
        $this->server = $groupPermission->server;
        $this->world = $groupPermission->world;
        $this->expires = $groupPermission->expires;
    }

    public function updateGroupPermission()
    {
        $validatedData = $this->validate();
        $server = empty($validatedData['server']) ? '' : $validatedData['server'];
        $world = empty($validatedData['world']) ? '' : $validatedData['world'];
        $expires = empty($validatedData['expires']) ? null : $validatedData['expires'];

        GroupPermission::where('id', $this->permissionId)->update([
            'permission' => $validatedData['permission'],
            'server' => $server,
            'world' => $world,
            'expires' => $expires,
        ]);
        session()->flash('message', 'Group Permission Updated Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteGroupPermission(GroupPermission $groupPermission)
    {
        $this->permissionId = $groupPermission->id;
        $this->permission = $groupPermission->permission;
    }

    public function delete()
    {
        GroupPermission::find($this->permissionId)->delete();
        $this->resetInput();
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->permissionId = null;
        $this->permission = null;
        $this->world = null;
        $this->server = null;
        $this->expires = null;
    }

    public function render(): View
    {
        $groupPermissions = GroupPermission::where('groupid', $this->group->id)
            ->where(function ($query) {
                $query->orWhere('permission', 'like', '%'.$this->search.'%')
                    ->orWhere('world', 'like', '%'.$this->search.'%')
                    ->orWhere('server', 'like', '%'.$this->search.'%');
            })->orderBy('id', 'ASC')->paginate(10);

        return view('livewire.permissions.show-group-permissions')->with('permissions', $groupPermissions);
    }
}
