<div>
    @include('livewire.languages.language-modals')

    @if (session()->has('message'))
        <h5 class="alert alert-success">{{ session('message') }}</h5>
    @endif
    @if(session()->has('warning-message'))
        <h5 class="alert alert-warning">{{ session('warning-message')  }}</h5>
    @endif

    <div class="card">
        <div class="card-header h5">
            Languages
            <label for="languageSearch" class="float-end mx-2">
                <input id="languageSearch" type="search" wire:model="search" class="form-control"
                       placeholder="Search..."/>
            </label>
        </div>
        <div class="card-body border-0 shadow table-responsive">
            <table id="languagesTable" class="table text-center">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($languages as $language)
                    <tr>
                        <td>{{ $language->id }}</td>
                        <td>{{ $language->name }}</td>
                        <th>
                            <a type="button" style="background: transparent; border: none;" href="/languages/{{$language->id}}">
                                <i class="material-icons text-warning">edit</i>
                            </a>
                            <button type="button" style="background: transparent; border: none;" data-mdb-toggle="modal"
                                    data-mdb-target="#deleteLanguageModal"
                                    wire:click="deleteLanguage({{ $language->id }})">
                                <i class="material-icons text-danger">delete</i>
                            </button>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $languages->links() }}
            </div>
        </div>
    </div>
    <div class="p-4">
        <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#addLanguageModal"
                wire:click="addLanguage" disabled>
            <i style="font-size: 18px !important;" class="material-icons">add</i> Add Language
        </button>
    </div>
</div>
