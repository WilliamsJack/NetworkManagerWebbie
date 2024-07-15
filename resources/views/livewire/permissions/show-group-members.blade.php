<div>
    @include('livewire.permissions.permission-group-members-modals')

    @if (session()->has('message'))
        <h5 class="alert alert-success">{{ session('message') }}</h5>
    @endif
    @if(session()->has('error'))
        <h5 class="alert alert-danger">{{ session('error') }}</h5>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="row mt-2 justify-content-between text-center">
                <div class="col-md-auto me-auto">
                    <label>Show
                        <select class="form-select form-select-sm" style="display: inherit; width: auto" wire:model.live="per_page">
                            <option value=10>10</option>
                            <option value=25>25</option>
                            <option value=50>50</option>
                            <option value=100>100</option>
                        </select>
                        entries
                    </label>
                </div>
                <div class="col-md-auto">
                    <h5 class="mb-0 text-center">
                        <strong>Members of {{ $group->name }}</strong>
                    </h5>
                </div>
                <div class="col-md-auto ms-auto" wire:ignore>
                    <div class="form-outline w-auto d-inline-block" data-mdb-input-init>
                        <input type="search" id="groupMemberSearch" class="form-control form-control-sm" wire:model.live="search"/>
                        <label class="form-label" for="groupMemberSearch" style="font-family: Roboto, 'FontAwesome'">Search...</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border-0 shadow table-responsive">
            <table class="table text-center">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Server</th>
                    <th>Expired</th>
                    @can('edit_permissions')
                        <th>Actions</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                @forelse($members as $member)
                    @php
                        $server = $member->server;
                        $expires = $member->expires;
                        if (empty($server)) {
                            $server = "ALL";
                        }
                        if (empty($expires)) {
                            $expires = "Never";
                        }
                    @endphp
                    <tr>
                        <td>{{ $member->permissionPlayer->name }}</td>
                        <td>{{ $server }}</td>
                        <td>{{ $expires }}</td>
                        @can('edit_permissions')
                            <td>
                                <button type="button" style="background: transparent; border: none;"
                                        data-mdb-ripple-init data-mdb-modal-init
                                        data-mdb-target="#deleteGroupMemberModal"
                                        wire:click="deleteGroupMember({{ $member->id }}, '{{ $member->permissionPlayer->uuid }}')">
                                    <i class="material-icons text-danger">delete</i>
                                </button>
                            </td>
                        @endcan
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Sorry - No Data Found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $members->links() }}
        </div>
    </div>
    <div class="p-4">
        <button type="button" class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#addGroupMemberModal"
                wire:click="addGroupMember">
            <i style="font-size: 18px !important;" class="material-icons">add</i> Add Member
        </button>
    </div>
</div>
