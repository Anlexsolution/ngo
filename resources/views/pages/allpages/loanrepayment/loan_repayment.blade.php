<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12" id="txtGenCard">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-device-desktop-cog"></i> Manage Loan Repayments
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#importRepaymentModal">Repayment Import</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Payment Date</label>
                                    <input type="date" class="form-control" id="txtPaymentDate"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Member</label>
                                    <select class="selectize" id="txtMember">
                                        <option value="">---Select---</option>
                                        @foreach ($getAllMemberData as $member)
                                            <option value="{{ $member->id }}">{{ $member->firstName }} -
                                                {{ $member->oldAccountNumber }} - {{ $member->nicNumber }} -
                                                {{ $member->division->divisionName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mt-2">
                                <div class="form-group">
                                    <label>Loans</label>
                                    <select class="" id="txtLoan">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mt-7">
                                <button type="button" class="btn btn-primary" id="btnAddLoandata">Add</button>
                            </div>
                            <hr class="mt-4">
                            <div class="col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="tblLoanRepayment">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Loan Id</th>
                                                <th>Loan Amount</th>
                                                <th>Days</th>
                                                <th>Interest</th>
                                                <th>Principal Amount</th>
                                                <th>Total Payment</th>
                                                <th>Balance Payment</th>
                                                <th>Pay Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Your data rows go here -->
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <hr class="mt-4">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Saving Amount</label>
                                    <input type="number" class="form-control" id="txtSavingAmount">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mt-4 d-flex justify-content-end">
                                <button class="btn btn-primary" id="txtRepaymentAmount">Pay</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-12 mt-4" id="txtDetails" hidden>
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-device-desktop-cog"></i> View Loan Repayment Details
                    </div>
                    <div class="card-body">
                        <br>
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td>Days</td>
                                    <td>
                                        <div id="viewDays"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Repayment Date</td>
                                    <td>
                                        <div id="viewRepaymentDate"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Loan Amount</td>
                                    <td>
                                        <div id="viewloanAmount"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Interest</td>
                                    <td>
                                        <div id="viewInterest"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Principal Amount</td>
                                    <td>
                                        <div id="viewPrincipalAmount"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Payment</td>
                                    <td>
                                        <div id="viewPTotalAmount"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Balance Payment</td>
                                    <td>
                                        <div id="viewbalanvepayAmount"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="text" class="form-control" id="txtInterestPay" hidden>
                        <input type="text" class="form-control" id="txtprincipalPayment" hidden>
                        <input type="text" class="form-control" id="txttotalPay" hidden>
                        <input type="text" class="form-control" id="txtbalancePay" hidden>
                        <input type="text" class="form-control" id="txtdays" hidden>
                        <input type="text" class="form-control" id="txtloanAmount" hidden>
                        <div class="row">
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label>Payment Amount</label>
                                    <input type="number" class="form-control" id="txtPaymentAmount">
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label>Saving Amount</label>
                                    <input type="number" class="form-control" id="txtSavingAmount">
                                </div>
                            </div>
                            <div class="col-4 " style="margin-top: 40px;">
                                <button class="btn btn-primary btn-sm" id="txtRepaymentAmount">Payment</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>


<!-- Import Saving History Modal -->
<div class="modal fade" id="importRepaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h4 class="mb-2">Import Repayment</h4>
                    <p>Repayment import function</p>
                </div>

                <!-- Sample Excel Download -->
                <div class="col-12 mb-3 text-center">
                    <a href="{{ asset('excelimportfile/repayment.xlsx') }}" class="btn btn-outline-info" download>
                        Download Sample Excel
                    </a>
                </div>

                <!-- File Input -->
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtImportFile">Choose Excel file</label>
                    <input type="file" id="txtImportFile" class="form-control" accept=".xlsx, .xls, .csv" />
                </div>

                <!-- Action Buttons -->
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnImportRepayment">Import Repayment</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Import Saving History Modal -->
