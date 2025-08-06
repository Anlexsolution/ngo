<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Manage Profession
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-end">

                                <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#addProfessionModal">Create Main Profession</button>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Main Profession name</th>
                                        <th>Sub Profession Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($managePro as $pro)
                                        @if ($pro->deleted == 0)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td>{{ $pro->name }}</td>
                                                <td>
                                                    @foreach ($getAllSubProfession as $data)
                                                    @if ($data->professionId == $pro->id)
                                                    {{ $data->name }} <br>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td class="d-flex justify-content-center">
                                                    <button class="btn btn-success btn-sm me-2 btnUpdateProfession"
                                                        data-name="{{ $pro->name }}" data-id="{{ $pro->id }}">
                                                        <i class="ti ti-edit"></i> Edit
                                                    </button>

                                                    <button class="btn btn-primary btn-sm me-2 btnSubProModalView"
                                                        data-id="{{ $pro->id }}">
                                                        Create Sub Profession
                                                    </button>
                                                </td>

                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add Permission Modal -->
<div class="modal fade" id="addProfessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add New Profession</h4>
                    <p>Create a member profession</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">Profession Name</label>
                    <input type="text" id="modalProfessionName" class="form-control" placeholder="Profession Name"
                        autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateProfession">Create Profession</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->

<!-- add sub pro Modal -->
<div class="modal fade" id="addSubProfessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add New Sub Profession</h4>
                    <p>Create a member Sub profession</p>
                </div>
                <input type="hidden" id="txtSubProfessionId">
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">Sub Profession Name</label>
                    <input type="text" id="txtSubProName" class="form-control" placeholder="Profession Name"
                        autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateSubProfession">Create sub Profession</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add sub pro Modal -->


<!-- update Permission Modal -->
<div class="modal fade" id="updateProfessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Update Profession</h4>
                    <p>Update a profession</p>
                </div>
                <input type="hidden" id="txtProfessionId">
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">Profession Name</label>
                    <input type="text" id="txtproName" class="form-control" placeholder="Profession Name"
                        autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnUpdateProfession">Update Profession</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ update Permission Modal -->

{{-- delete profession modal --}}
<div class="modal fade" id="proDeleteModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtProId">
                Are you sure you want to delete this Profession?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteProBtn">Delete</button>
            </div>
        </div>
    </div>
</div>
{{-- delete profession modal --}}
