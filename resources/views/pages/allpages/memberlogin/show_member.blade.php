<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="/logout_member">
                <button class="btn btn-danger btn-sm">logout</button>
                </a>
            </div>
            <div class="col mt-3">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> {{ $member->firstName }} {{ $member->lastName }} - {{ $member->nicNumber }} -
                        {{ $member->oldAccountNumber }}
                    </div>
                    <div class="card-body">
                        <input type="hidden" value="{{ $member->id }}" id="txtMemberId">
                        <div class="nav-align-top mt-3">
                            <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab"
                                            data-bs-toggle="tab" data-bs-target="#navs-justified-personal"
                                            aria-controls="navs-justified-personal" aria-selected="true">
                                            Personal Details
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-savings"
                                            aria-controls="navs-justified-link-savings" aria-selected="false">
                                            Savings
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-loan"
                                            aria-controls="navs-justified-link-loan" aria-selected="false">
                                            Loan
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-death"
                                            aria-controls="navs-justified-link-death" aria-selected="false">
                                            Death
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-meetings"
                                            aria-controls="navs-justified-link-meetings" aria-selected="false">
                                            Meetings
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-location"
                                            aria-controls="navs-justified-link-location" aria-selected="false">
                                            Location
                                        </button>
                                    </li>
                              

                            </ul>
                            <div class="tab-content border-0 mx-1">
                                <div class="tab-pane fade show active" id="navs-justified-personal" role="tabpanel">
                                    @include('pages.allpages.memberpages.personal_details')
                                </div>
                                <div class="tab-pane fade show " id="navs-justified-link-savings" role="tabpanel">
                                    @include('pages.allpages.memberlogin.saving_details_mem')
                                </div>
                                <div class="tab-pane fade show " id="navs-justified-link-loan" role="tabpanel">
                                    @include('pages.allpages.memberlogin.loan_details_mem')
                                </div>
                                <div class="tab-pane fade show " id="navs-justified-link-death" role="tabpanel">
                                    @include('pages.allpages.memberlogin.death_details_mem')
                                </div>
                                <div class="tab-pane fade show " id="navs-justified-link-meetings" role="tabpanel">
                                    @include('pages.allpages.memberpages.meetings_details')
                                </div>
                                 <div class="tab-pane fade show " id="navs-justified-link-location" role="tabpanel">
                                    @include('pages.allpages.memberpages.manage_location')
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- profile update modAL --}}
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Update Profile</h4>
                    <p>Profile</p>
                </div>
                <input type="text" class="form-control" id="txtMemberId" name="txtMemberId"
                    value="{{ $memberId }}" hidden />
                <div class="col-12 mb-4">
                    <label class="form-label">Choose Profile</label>
                    <input type="file" class="form-control" id="txtProfile" name="txtProfile"
                        accept="image/*" />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnUpdateProfile">Update</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- signature update modAL --}}
<div class="modal fade" id="updateSignatureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Update Signature</h4>
                    <p>Signature</p>
                </div>
                <input type="text" class="form-control" id="txtSigMemberId" name="txtSigMemberId"
                    value="{{ $memberId }}" hidden />
                <div class="col-12 mb-4">
                    <label class="form-label">Choose Signature</label>
                    <input type="file" class="form-control" id="txtSignature" name="txtSignature"
                        accept="image/*" />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnUpdateSignature">Update</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
