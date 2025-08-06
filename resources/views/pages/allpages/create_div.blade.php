<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> Create New Division
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label class="form-label w-100" for="divisionName">Division Name</label>
                                    <div class="input-group input-group-merge">
                                        <input id="divisionName" name="divisionName" id="divisionName"
                                            class="form-control" type="text" placeholder="Division Name" />
                                    </div>
                                </div>
                                <div class="col-12 text-center d-flex justify-content-end mt-3">
                                    <button class="btn btn-primary me-3" id="btnCreateDivision">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> View
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Division ID</th>
                                        <th>Division Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($getDivision as $division)
                                        <tr>
                                            <td>@php
                                                echo $i++;
                                            @endphp</td>
                                            <td>{{$division->id}}</td>
                                            <td>{{ $division->divisionName }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-black btnUpdateModal"
                                                            data-divisionName = "{{ $division->divisionName }}"
                                                            data-id = "{{ $division->id }}"><i
                                                                class="ti ti-edit me-1"></i> Edit</a>
                                                        <a class="dropdown-item text-danger btnDeleteModal"   data-id = "{{ $division->id }}"><i
                                                                class="ti ti-trash me-1"></i> Delete</a>
                                                    </div>
                                                </div>
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


<!-- Update Division Modal -->
<div class="modal fade" id="updateDivisionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Update Division</h4>
                    <p>Update the Division name</p>
                </div>
                <input type="hidden" id="txtDivisionId">
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtDivisionName">Division Name</label>
                    <input type="text" id="txtDivisionName" class="form-control" placeholder="Division Name"
                        autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnUpdateDivision">Update Division</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Update Division Modal -->

{{-- delete Division modal --}}
<div class="modal fade" id="divisionDeleteModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtDivisionId">
                Are you sure you want to delete this Division?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteDivisionBtn">Delete</button>
            </div>
        </div>
    </div>
</div>
{{-- delete Division modal --}}
