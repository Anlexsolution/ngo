<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        View Death Donation Details
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-center text-uppercase">
                                <h5>Member Details</h5>
                            </div>
                            <hr>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Member Name</label>
                                    <p>{{ $getMember->firstName }} {{ $getMember->lastName }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Member Relative Name</label>
                                    <p>{{ $getDonation->name }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">RelationShip</label>
                                    <p>{{ $getRelative->name }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Address</label>
                                    <p>{{ $getMember->address }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Division</label>
                                    <p>{{ $getMember->division->divisionName }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Village</label>
                                    <p>{{ $getMember->village->villageName }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Small Group</label>
                                    <p>{{ $getMember->smallgroup->smallGroupName }}</p>
                                </div>
                            </div>
                            <div class="col-12 mt-2 d-flex justify-content-center text-uppercase">
                                <h5>Approval Details</h5>
                            </div>
                            <hr>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>By</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getDonationHis as $data)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>{{ $data->userName }}</td>
                                            <td>{{ $data->remarks }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $data->status }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col-12 d-flex justify-content-end mt-3">
                                <button class="btn btn-danger btn-sm btnRejectModalOpen me-2"
                                    data-id="{{ $getDonation->id }}">Rejected</button>
                                <button class="btn btn-primary btn-sm btnAprovalModalOpen"
                                    data-id="{{ $getDonation->id }}">Approval</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add gur Modal -->
<div class="modal fade" id="btnAprovalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Distribute</h4>
                    <p>set a Distribute</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label">Account</label>
                    <select class="selectize" id="txtAccount">
                        @foreach ($getAllAccount as $account)
                            <option value="{{ $account->id }}">{{ $account->name }} ({{ $account->balance }})</option>
                        @endforeach
                    </select>
                </div>
                 <div class="col-12 mb-4">
                    <label class="form-label" >Cheq No</label>
                    <input type="text" class="form-control" id="txtCheqNo" placeholder="Cheq No">
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtApprovalReason">Remarks</label>
                    <textarea class="form-control" id="txtApprovalReason"></textarea>
                </div>
                <input type="hidden" id="txtDonationId">
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnAproval">Distribute</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add gur Modal -->


<!-- Add gur Modal -->
<div class="modal fade" id="btnRejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Death Donation Rejected Reason</h4>
                    <p>set a reason</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtRejectedReason">Reason</label>
                    <textarea class="form-control" id="txtRejectedReason"></textarea>
                </div>

                <input type="hidden" id="txtDonationRejectedId">
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-danger me-4" id="btnRejected">Rejected</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add gur Modal --
