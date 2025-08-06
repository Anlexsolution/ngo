<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-list"></i> Create Old Loan
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Select Member</label>
                                    <select class="selectize" id="txtSelectMember">
                                        <option value="">---Select---</option>
                                        @foreach ($getMember as $member)
                                            <option value="{{ $member->id }}">{{ $member->firstName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Loan ID</label>
                                    <input type="text" class="form-control" id="txtLoanId">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Loan Amount</label>
                                    <input type="number" class="form-control" id="txtLoanAmount">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Loan Term</label>
                                    <input type="number" class="form-control" id="txtLoanTerm">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Interest Rate</label>
                                    <input type="number" class="form-control" id="txtInterestRate">
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <label>Repayment Period</label>
                                <select class="selectize" id="txtRepaymentPreriod">
                                    {{-- <option value="Days">Days</option>
                                    <option value="Weeks">Weeks</option> --}}
                                    <option value="Months">Months</option>
                                </select>
                            </div>
                            <div class="col-6 mt-2">
                                <label>Per</label>
                                <select class="selectize" id="txtPer">
                                    {{-- <option value="Month">Month</option> --}}
                                    <option value="Year">Year</option>
                                    {{-- <option value="Principal">Principal</option> --}}
                                </select>
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label>Loan Officer</label>
                                    <select class="selectize" id="txtLoanOfficer">
                                        <option value="">---Select---</option>
                                        @foreach ($getLoanOfficer as $officer)
                                            <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label>Loan Purpose</label>
                                    <select class="selectize" id="txtLoanPurpose">

                                        @foreach ($getLoanPurpose as $purpose)
                                            <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="">Loan Date</label>
                                    <input type="date" class="form-control" id="txtLoanDate">
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
                                    <input type="text" class="form-control" id="txtFollowerName">
                                </div>
                            </div>
                            <div class="col-6 mt-3 ">
                                <div class="form-group">
                                    <label for="">Follower Address</label>
                                    <textarea class="form-control" id="txtFollowerAddress"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Follower NIC</label>
                                    <input type="text" class="form-control" id="txtFollowerNic">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="">Follower NIC Issue Date</label>
                                    <input type="date" class="form-control" id="txtFollowerNicIssueDate">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for=""> Follower Phone Number</label>
                                    <input type="text" class="form-control" id="txtFollowerPhoneNumber">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="">Profession</label>
                                    <select class="selectize" id="txtFollowerProfession">
                                        <option value="">Select Follower Profession</option>
                                        @foreach ($getPro as $profession)
                                            <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end mt-3">
                                <button class="btn btn-primary btn-sm" id="btnCreateOldLoan">Create Old Loan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
