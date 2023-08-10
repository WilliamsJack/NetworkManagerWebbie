<div>
    @include('livewire.motd.motd-modals')

    <div class="card">
        <div class="card-header text-center py-3">
            <h5 class="mb-0 text-center">
                <strong>MOTD</strong>
            </h5>
        </div>

        <div class="card-body border-0 shadow table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Simple Preview</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($motds as $motd)
                    <tr>
                        <td>
                            <div class="preview_zone"
                                 style="background-image: url({{ $motd->faviconUrl }}), url(../images/motd.png);">
                                <div class="server-name">Minecraft Server <span id="ping" class="ping">@if(empty($motd->customversion)) 143/200 @else {!! $motd->customversion !!} @endif</span>
                                </div>
                                <span class="preview_motd" wire:modal="motd.text">{!! $motd->text !!}</span>
                            </div>
                        </td>
                        <td>
                            <a type="button" style="background: transparent; border: none;" data-mdb-toggle="tooltip"
                               title="Click to preview"
                               href="https://webui.advntr.dev/?mode=server_list&input={{urlencode($motd->text)}}"
                               target="_blank" rel="noopener noreferrer">
                                <i class="material-icons text-primary">travel_explore</i>
                            </a>
                            <button type="button" style="background: transparent; border: none;" data-mdb-toggle="modal"
                                    data-mdb-target="#editMotdModal"  wire:click="editMotd({{$motd->id}})">
                                <i class="material-icons text-warning">edit</i>
                            </button>
                            <button type="button" style="background: transparent; border: none;" data-mdb-toggle="modal"
                                    data-mdb-target="#deleteMotdModal" wire:click="deleteMotd({{$motd->id}})">
                                <i class="material-icons text-danger">delete</i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-4">
        <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#addMotdModal"
                wire:click="addMotd">
            <i style="font-size: 18px !important;" class="material-icons">add</i> Add MOTD
        </button>
    </div>
</div>
