<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Manage loan Approval
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-end">

                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addApprovalModal">Create Approval</button>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Min Amount</th>
                                        <th>Max Amount</th>
                                        <th>How Many Approval</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getAllLoanApprovalSetting as $app)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $app->name }}</td>
                                            <td>{{ number_format($app->minimum, 2) }}</td>
                                            <td>{{ number_format($app->maximum, 2) }}</td>
                                            <td>{{ $app->howManyApproval }}</td>
                                            <td>
                                                <button class="btn btn-success btn-sm updateSetiingsModal"
                                                    data-id="{{ $app->id }}"
                                                    data-name="{{ $app->name }}"
                                                    data-minimum = "{{ $app->minimum }}"
                                                    data-maximum = "{{ $app->maximum }}"
                                                    data-count = "{{ $app->howManyApproval }}">Edit</button>
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
<div class="modal fade" id="addApprovalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add New Approval Settings</h4>
                    <p>Create a new Approval Settings</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">Approval Name</label>
                    <input type="text" id="txtApprovalName" class="form-control" placeholder="Approval Name"
                        autofocus />
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">Min Amount</label>
                    <input type="number" id="txtMinAmount" class="form-control" placeholder="Approval Name"
                        autofocus />
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">Max Amount</label>
                    <input type="number" id="txtMaxAmount" class="form-control" placeholder="Approval Name"
                        autofocus />
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">How Many Approval</label>
                    <input type="number" id="txtHowManyApproval" class="form-control" placeholder="Approval Name"
                        autofocus />
                </div>
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateApproval">Create Approval</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->


<!-- Update Permission Modal -->
<div class="modal fade" id="updateApprovalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Update Approval Settings</h4>
                    <p>Update a Approval Settings</p>
                </div>
                <input type="hidden" id="txtApprovalIdUpdate" />
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">Approval Name</label>
                    <input type="text" id="txtApprovalNameUpdate" class="form-control" placeholder="Approval Name"
                        autofocus />
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">Min Amount</label>
                    <input type="number" id="txtMinAmountUpdate" class="form-control" placeholder="Approval Name"
                        autofocus />
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">Max Amount</label>
                    <input type="number" id="txtMaxAmountUpdate" class="form-control" placeholder="Approval Name"
                        autofocus />
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">How Many Approval</label>
                    <input type="number" id="txtHowManyApprovalUpdate" class="form-control"
                        placeholder="Approval Name" autofocus />
                </div>
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnUpdateApproval">Update Approval</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Update Permission Modal -->
