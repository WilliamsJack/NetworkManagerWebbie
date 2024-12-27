<?php

namespace App\Livewire\Permissions;

use App\Models\Permissions\GroupPrefix;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class GroupPrefixesTable extends PowerGridComponent
{
    public string $tableName = 'group-prefixes-table';

    public int $groupId;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return GroupPrefix::query()->where('groupid', $this->groupId);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('prefix')
            ->add('server');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable()
                ->searchable(),

            Column::make('Prefix', 'prefix')
                ->sortable()
                ->searchable(),

            Column::make('Server', 'server')
                ->sortable()
                ->searchable(),

            Column::action('Action'),
        ];
    }

    public function actions(GroupPrefix $row): array
    {
        return [
            Button::add('edit')
                ->attributes(['data-mdb-ripple-init' => '', 'data-mdb-modal-init' => '', 'data-mdb-target' => '#editGroupPrefixModal'])
                ->slot('<i class="material-icons text-warning">edit</i>')
                ->can(auth()->user()->can('edit_permissions'))
                ->id()
                ->class('bg-transparent border-0')
                ->dispatch('edit', ['rowId' => $row->id]),
            Button::add('delete')
                ->attributes(['data-mdb-ripple-init' => '', 'data-mdb-modal-init' => '', 'data-mdb-target' => '#deleteGroupPrefixModal'])
                ->slot('<i class="material-icons text-danger">delete</i>')
                ->can(auth()->user()->can('edit_permissions'))
                ->id()
                ->class('bg-transparent border-0')
                ->dispatch('delete', ['rowId' => $row->id]),
        ];
    }
}
