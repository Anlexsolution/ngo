<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        View Loan Approval Details
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
                                    <p>{{ $memberDetails->firstName }} {{ $memberDetails->lastName }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Address</label>
                                    <p>{{ $memberDetails->address }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">New Account Number</label>
                                    <p>{{ $memberDetails->newAccountNumber }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Old Account Number</label>
                                    <p>{{ $memberDetails->oldAccountNumber }}</p>
                                </div>
                            </div>
                            <div class="col-12 mt-2 d-flex justify-content-center text-uppercase">
                                <h5>Loan Details</h5>
                            </div>
                            <hr>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Loan Id</label>
                                    <p>{{ $loanDetails->loanId }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Loan Amount</label>
                                    <p>{{ number_format($loanDetails->principal, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Loan Term</label>
                                    <p>{{ $loanDetails->loanterm }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Repayment Period</label>
                                    <p>{{ $loanDetails->repaymentPeriod }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Interest Type</label>
                                    <p>{{ $loanDetails->interestType }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="fw-bold">Loan Officer</label>
                                    <p>{{ $getLoanOfficer->name }}</p>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-danger btn-sm btnRejectLoanModal me-2"
                                    data-id="{{ $loanDetails->id }}">Rejected</button>
                                @if ($maxId == $getApprovalStatus)
                                    <button class="btn btn-primary btn-sm btnAprovalLoanFinalModal"
                                        data-id="{{ $loanDetails->id }}">Approval</button>
                                @else
                                    <button class="btn btn-primary btn-sm btnAprovalLoanModal"
                                        data-id="{{ $loanDetails->id }}">Approval</button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add gur Modal -->
<div class="modal fade" id="btnAprovalLoanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Loan Approval Reason</h4>
                    <p>set a reason</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtApprovalReason">Reason</label>
                    <textarea class="form-control" id="txtApprovalReason"></textarea>
                </div>

                <input type="hidden" id="txtLoanIdGetApproval">
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnAprovalLoan">Approval</button>
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
<div class="modal fade" id="btnAprovalLoanModalFinal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Loan Approval Reason</h4>
                    <p>set a reason</p>
                </div>
                <div class="col-12 mb-4">
                    <label>Account</label>
                    <select class="selectize" id="txtAccount">
                        @foreach ($getAccountData as $data)
                            <option value="{{ $data->id }}">{{ $data->name }} - {{ $data->branch }}
                                ({{ number_format($data->balance, 2) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-4">
                    <label>Check No</label>
                    <input type="text" class="form-control" id="txtCheckNoFinal">
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtApprovalReasonFinal">Reason</label>
                    <textarea class="form-control" id="txtApprovalReasonFinal"></textarea>
                </div>

                <input type="hidden" id="txtLoanIdGetApprovalFinal">
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnAprovalLoanFinal">Approval</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add gur Modal -->


<!-- Add gur Modal -->
<div class="modal fade" id="btnRejectLoanModals" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Loan Rejected Reason</h4>
                    <p>set a reason</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtRejectedReason">Reason</label>
                    <textarea class="form-control" id="txtRejectedReason"></textarea>
                </div>

                <input type="hidden" id="txtLoanIdGetRejected">
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-danger me-4" id="btnRelectLoan">Rejected</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add gur Modal --
