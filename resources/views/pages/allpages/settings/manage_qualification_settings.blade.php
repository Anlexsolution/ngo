<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Manage Qualification
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-end">

                                <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#addProfessionModal">Create Main Qualification</button>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Main Qualification name</th>
                                        <th>Sub Qualification Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getQualificationData as $pro)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $pro->qualificationName }}</td>
                                            <td>
                                                @foreach ($getSubQualification as $data)
                                                    @if ($data->qualificationId == $pro->id)
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <span>{{ $data->subQualificationName }}</span>
                                                            <button
                                                                class="btn btn-sm btn-outline-success ms-2 p-1 btnUpdateSubQualification"
                                                                data-id="{{ $data->id }}"
                                                                data-name="{{ $data->subQualificationName }}"
                                                                data-mainid="{{ $pro->id }}">
                                                                  <i class="ti ti-edit" style="font-size:12px;"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </td>
                                            </td>
                                            <td class="d-flex justify-content-center">
                                                <button class="btn btn-success btn-sm me-2 btnUpdateQualification"
                                                    data-name="{{ $pro->qualificationName }}"
                                                    data-id="{{ $pro->id }}">
                                                    <i class="ti ti-edit"></i> Edit
                                                </button>

                                                <button class="btn btn-primary btn-sm me-2 btnSubQualificationModalShow"
                                                    data-id="{{ $pro->id }}">
                                                    Create Sub Profession
                                                </button>
                                            </td>

                                        </tr>
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
                    <h4 class="mb-2">Add New Qualification</h4>
                    <p>Create a member Qualification</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">Qualification Name</label>
                    <input type="text" id="txtQualificationName" class="form-control"
                        placeholder="Qualification Name" autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateQualification">Create Qualification</button>
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
<div class="modal fade" id="addSubQualificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add New Sub Qualification</h4>
                    <p>Create Sub Qualification</p>
                </div>
                <input type="hidden" id="txtQualificationId">
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">Sub Qualification Name</label>
                    <input type="text" id="txtSubQualificationName" class="form-control"
                        placeholder="Qualification Name" autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateSubQualification">Create sub
                        Qualification</button>
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


<div class="modal fade" id="updateSubQualificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Update Sub Qualification</h4>
                    <p>Update a Sub Qualification</p>
                </div>
                <input type="hidden" id="txtSubQualificationId">
                <input type="hidden" id="txtMainQualificationId">
                <div class="col-12 mb-4">
                    <label class="form-label">Sub Qualification Name</label>
                    <input type="text" id="txtUpdateSubQualificationName" class="form-control"
                        placeholder="Sub Qualification Name" autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnUpdateSubQualification">
                        Update Sub Qualification
                    </button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
