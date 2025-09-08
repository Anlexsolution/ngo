<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-list"></i> Update Loan
                    </div>
                    <div class="card-body">
                        <input type="hidden" class="form-control" id="txtLoanIdUpdate" value="{{ $DecId }}">
                        <input type="hidden" class="form-control" id="txtLoanType" value="{{ $getLoanUnique->loanType }}">
                        <div class="row">
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label>Guarantors</label>
                                    <select id="txtLoanGuarantors">
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="">Follower Name</label>
                                    <input type="text" class="form-control" id="txtFollowerName"
                                        value="{{ $getLoanUnique->followerName }}">
                                </div>
                            </div>
                            <div class="col-6 mt-3 ">
                                <div class="form-group">
                                    <label for="">Follower Address</label>
                                    <textarea class="form-control" id="txtFollowerAddress">{{ $getLoanUnique->followerAddress }}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Follower NIC</label>
                                    <input type="text" class="form-control" id="txtFollowerNic"
                                        value="{{ $getLoanUnique->followerNic }}">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="">Follower NIC Issue Date</label>
                                    <input type="date" class="form-control" id="txtFollowerNicIssueDate"
                                        value="{{ $getLoanUnique->followerNicIssueDate }}">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for=""> Follower Phone Number</label>
                                    <input type="text" class="form-control" id="txtFollowerPhoneNumber"
                                        value="{{ $getLoanUnique->followerPhone }}">
                                </div>
                            </div>
                            @if ($getLoanUnique->loanType == 'Old')
                                <div class="col-6 mt-3">
                                    <div class="form-group">
                                        <label for="">Profession</label>
                                        <select class="selectize" id="txtFollowerProfession">
                                            <option value="">Select Follower Profession</option>
                                            @foreach ($getPro as $profession)
                                                @if ($getLoanUnique->followerProfession == $profession->id)
                                                    <option value="{{ $profession->id }}" selected>
                                                        {{ $profession->name }}</option>
                                                @else
                                                    <option value="{{ $profession->id }}">{{ $profession->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12 d-flex justify-content-end mt-3">
                                <button class="btn btn-primary btn-sm" id="btnUpdateOldLoan">Update Old Loan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
