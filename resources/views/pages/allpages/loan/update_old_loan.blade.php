<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-list"></i> Update Old Loan
                    </div>
                    <div class="card-body">
                        <input type="hidden" class="form-control" id="txtLoanIdUpdate" value="{{ $DecId }}">
                        <div class="row">
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Select Member</label>
                                    <select class="selectize" id="txtSelectMember">
                                        <option value="">---Select---</option>
                                        @foreach ($getMember as $member)
                                            @if ($getLoanUnique->memberId == $member->id)
                                                <option value="{{ $member->id }}" selected>{{ $member->firstName }}
                                                </option>
                                            @else
                                                <option value="{{ $member->id }}">{{ $member->firstName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Loan ID</label>
                                    <input type="text" class="form-control" id="txtLoanId"
                                        value="{{ $getLoanUnique->loanId }}">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Loan Amount</label>
                                    <input type="number" class="form-control" id="txtLoanAmount"
                                        value="{{ $getLoanUnique->principal }}">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Loan Term</label>
                                    <input type="number" class="form-control" id="txtLoanTerm"
                                        value="{{ $getLoanUnique->loanterm }}">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Interest Rate</label>
                                    <input type="number" class="form-control" id="txtInterestRate"
                                        value="{{ $getLoanUnique->interestRate }}">
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <label>Repayment Period</label>
                                <select class="selectize" id="txtRepaymentPreriod">
                                    {{-- <option value="Days">Days</option>
                                    <option value="Weeks">Weeks</option> --}}
                                    <option value="Months" selected>Months</option>
                                </select>
                            </div>
                            <div class="col-6 mt-2">
                                <label>Per</label>
                                <select class="selectize" id="txtPer">
                                    {{-- <option value="Month">Month</option> --}}
                                    <option value="Year" selected>Year</option>
                                    {{-- <option value="Principal">Principal</option> --}}
                                </select>
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label>Loan Officer</label>
                                    <select class="selectize" id="txtLoanOfficer">
                                        <option value="">---Select---</option>
                                        @foreach ($getLoanOfficer as $officer)
                                            @if ($getLoanUnique->loanOfficer == $officer->id)
                                                <option value="{{ $officer->id }}" selected>{{ $officer->name }}
                                                </option>
                                            @else
                                                <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label>Loan Purpose</label>
                                    <select class="selectize" id="txtLoanPurpose">

                                        @foreach ($getLoanPurpose as $purpose)
                                            @if ($getLoanUnique->loanPurpose == $purpose->id)
                                                <option value="{{ $purpose->id }}" selected>{{ $purpose->name }}</option>
                                            @else
                                                <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="">Loan Date</label>
                                    <input type="date" class="form-control" id="txtLoanDate"
                                        value="{{ \Carbon\Carbon::parse($getLoanUnique->created_at)->format('Y-m-d') }}">

                                </div>
                            </div>
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
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="">Profession</label>
                                    <select class="selectize" id="txtFollowerProfession">
                                        <option value="">Select Follower Profession</option>
                                        @foreach ($getPro as $profession)
                                          @if ($getLoanUnique->followerProfession == $profession->id)
                                               <option value="{{ $profession->id }}" selected>{{ $profession->name }}</option>
                                            @else
                                               <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
