<div>
    @include('livewire.permissions.permission-group-permissions-modals')

    @if (session()->has('message'))
        <h5 class="alert alert-success">{{ session('message') }}</h5>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Permissions of {{ $group->name }}</h5>
            <label for="groupPermissionSearch" class="float-end mx-2">
                <input id="groupPermissionSearch" type="search" wire:model="search" class="form-control"
                       placeholder="Search..." />
            </label>
        </div>
        <div class="card-body border-0 shadow table-responsive">
            <table class="table text-center">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Permission</th>
                    <th>Server</th>
                    <th>World</th>
                    <th>Expires</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    @php
                        $server = $permission->server;
                        $world = $permission->world;
                        $expires = $permission->expires;
                        if (empty($server)) {
                            $server = "ALL";
                        }
                        if (empty($world)) {
                            $world = "ALL";
                        }
                        if (empty($expires)) {
                            $expires = "Never";
                        }
                    @endphp
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->permission }}</td>
                        <td>{{ $server }}</td>
                        <td>{{ $world }}</td>
                        <td>{{ $expires }}</td>
                        <td>
                            <button type="button" style="background: transparent; border: none;" data-mdb-toggle="modal"
                                    data-mdb-target="#editGroupPermissionModal"
                                    wire:click="editGroupPermission({{$permission->id}})">
                                <i class="material-icons text-warning">edit</i>
                            </button>
                            <button type="button" style="background: transparent; border: none;" data-mdb-toggle="modal"
                                    data-mdb-target="#deleteGroupPermissionModal"
                                    wire:click="deleteGroupPermission({{ $permission->id }})">
                                <i class="material-icons text-danger">delete</i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
    <div class="p-4">
        <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#addGroupPermissionModal"
                wire:click="addGroupPermission">
            <i style="font-size: 18px !important;" class="material-icons">add</i> Add Permission
        </button>
    </div>
</div>
