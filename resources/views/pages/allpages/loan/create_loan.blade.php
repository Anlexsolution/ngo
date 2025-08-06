<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-list"></i> Create Loan
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            @php
                                $randomNumber = mt_rand(1000000000, 9999999999);
                            @endphp

                            <div class="col-6">
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Select Loan Product</label>
                                    <select class="selectize" id="txtSelectLoanProduct">
                                        <option value="">---Select---</option>
                                        @foreach ($getLoanProduct as $product)
                                            <option value="{{ $product->id }}">{{ $product->productName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Select Loan Amount</label>
                                    <select id="txtSelectLoanAmount">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>Select Loan Approval</label>
                                    <select class="selectize" id="txtSelectLoanApprovalSet">
                                        <option value="">---Select---</option>
                                        @foreach ($getLoanApproveSetData as $App)
                                            <option value="{{ $App->id }}">{{ $App->name }} ( {{number_format($App->minimum, 2)}} - {{number_format($App->maximum, 2)}} ) approve - {{$App->howManyApproval}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end mt-2">
                                <button class="btn btn-primary" id="btnGenerateLoanProduct">Generate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-5" id="loanProductDiv" style="display: none;">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-list"></i> Terms
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label>Loan Id</label>
                                    <input type="text" class="form-control" id="txtLoanId" value="{{$randomNumber}}" readonly>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" class="form-control" id="txtProductName" readonly>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" id="txtDescription" readonly>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="form-group">
                                    <label>Principal</label>
                                    <input type="number" class="form-control" id="txtPricipal">
                                    <div id="validationCheckPrincipal"></div>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="form-group">
                                    <label>Loan Term</label>
                                    <input type="number" class="form-control" id="txtLoanTerm">
                                    <div id="validationCheckTerm"></div>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="form-group">
                                    <label>Repayment Frequency</label>
                                    <input type="number" class="form-control" id="txtRepaymentFrequency">
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="form-group">
                                    <label>Interest Rate</label>
                                    <input type="number" class="form-control" id="txtInterestRate">
                                    <div id="validationCheckInterest"></div>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <label>Repayment Period</label>
                                <select class="selectize" id="txtRepaymentPreriod">
                                    <option value="Months">Months</option>
                                </select>
                            </div>
                            <div class="col-4 mt-2">
                                <label>Per</label>
                                <select class="selectize" id="txtPer">
                                    <option value="Year">Year</option>
                                </select>
                            </div>
                            <div class="col-4 mt-3">
                                <br>
                                <button class="btn btn-primary btn-sm" id="calculateLoanSchedule">Calculate</button>
                            </div>
                            <br>
                            <hr>
                            <div id="loanScheduleTable"></div>
                            <hr>
                            <br>
                            <div class="col-4 mt-2" hidden>
                                <label>Interest Type</label>
                                <select class="selectize" id="txtInterestType">
                                    <option value="normal">normal</option>
                                    {{-- <option value="Reduce Amount">Reduce Amount</option>
                                    <option value="One Time Payment">One Time Payment</option> --}}
                                </select>
                            </div>
                            <div class="col-12 mt-2">
                                <h5>Approval Details</h5>
                            </div>
                            <hr>
                            <div id="getApprovalDetails"></div>
                            <div class="col-12 mt-2">
                                <h5>Settings</h5>
                            </div>
                            <hr>
                            <div class="col-4 mt-2">
                                <div class="form-group">
                                    <label>Loan Officer</label>
                                    <div id="getLoanOfficers"></div>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="form-group">
                                    <label>Loan Purpose</label>
                                    <select class="selectize" id="txtLoanPurpose">
                                        <option value="">Select Loan Purpose</option>
                                        @foreach ($getLoanPurpose as $purpose)
                                            <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="form-group">
                                    <label>Loan Sub Purpose</label>
                                    <select id="txtLoanPurposeSub">
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="form-group">
                                    <label>Expected First Repayment Date</label>
                                    @php
                                        use Carbon\Carbon;

                                        $newDate = Carbon::now()->addMonth();
                                        $finalDate = $newDate->format('Y-m-d');
                                    @endphp
                                    <input type="date" class="form-control" id="txtExpectedFirstRepaymentDate" value="{{$finalDate}}">
                                </div>
                            </div>
                            <div class="col-12 mt-3 d-flex justify-content-end">
                                <button class="btn btn-primary" id="btnCreateLoanBasic">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add gur Modal -->
<div class="modal fade" id="addGuarantorsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Assign Guarantors</h4>
                    <p>set a Guarantors</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">Guarantors</label>
                    <div id="selectGuarantors"></div>
                </div>

                <input type="hidden" id="txtLoanId">
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnAssignGuarantors">Assign Guarantors</button>
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
