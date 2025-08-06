<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Manage Meeting Category
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-end">

                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addMeetingModal">Create Meeting Category</button>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Meeting Category name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($manageMeetingType as $pro)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td>{{ $pro->name }}</td>
                                                <td class="d-flex justify-content-center">
                                                    <button class="btn btn-success btn-sm me-2 btnUpdateMeetingType"
                                                        data-name ="{{ $pro->name }}"
                                                        data-id="{{ $pro->id }}"><i class="ti ti-edit"></i>
                                                        Edit</button>
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


<!-- Add Meeting Type Modal -->
<div class="modal fade" id="addMeetingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add New Meeting Category</h4>
                    <p>Create a Meeting Category</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtMeetingTypeName">Meeting Type Category</label>
                    <input type="text" id="txtMeetingTypeName" class="form-control" placeholder="Meeting type Name"
                        autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateMeetingType">Create Meeting Category</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add Meeting Type Modal -->


<!-- update Permission Modal -->
<div class="modal fade" id="updateMeetingTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Update Meeting Category</h4>
                    <p>Update a Meeting Category</p>
                </div>
                <input type="hidden" id="txtMeetingTypeId">
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtMeetingTypeNameUpdate">Meeting Category Name</label>
                    <input type="text" id="txtMeetingTypeNameUpdate" class="form-control" placeholder="Meeting Type Name"
                        autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnUpdateMeetingType">Update Meeting Category</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ update Permission Modal -->


