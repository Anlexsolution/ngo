<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-list"></i> Update Loan Product
                    </div>
                    <div class="card-body">
                        <input type="hidden" class="form-control" id="txtLoanProductId" value="{{ $decId }}">
                        <input type="hidden" class="form-control" id="txtSubCatId" value="{{ $loanProductData->subCategory }}">
                        <div class="row">
                            <div class="col-6 mt-2">
                                <label for="txtProductName">Product Name</label>
                                <input type="text" class="form-control" id="txtProductName"
                                    value="{{ $loanProductData->productName }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>Description</label>
                                <input type="text" class="form-control" id="txtDescription"
                                    value="{{ $loanProductData->description }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>Default Principal</label>
                                <input type="number" class="form-control" id="txtDefaultPrincipel"
                                    value="{{ $loanProductData->defaultPrincipal }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>Minimum Principal</label>
                                <input type="number" class="form-control" id="txtMinimumPrincipel"
                                    value="{{ $loanProductData->minimumPrincipal }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>Maximum Principal</label>
                                <input type="number" class="form-control" id="txtMaximumPrincipel"
                                    value="{{ $loanProductData->maximumPrincipal }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>Default Loan Term</label>
                                <input type="number" class="form-control" id="txtDefaultLoanTerm"
                                    value="{{ $loanProductData->defaultLoanTerm }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>Minimum Loan Term</label>
                                <input type="number" class="form-control" id="txtMinimumLoanTerm"
                                    value="{{ $loanProductData->minimumLoanTerm }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>Maximum Loan Term</label>
                                <input type="number" class="form-control" id="txtMaximumLoanTerm"
                                    value="{{ $loanProductData->maximumLoanTerm }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>Repayment Frequency</label>
                                <input type="text" class="form-control" id="txtRepaymentFrequency"
                                    value="{{ $loanProductData->repaymentFrequency }}">
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
                                <label>Default Interest Rate</label>
                                <input type="number" class="form-control" id="txtDefaultInterest"
                                    value="{{ $loanProductData->defaultInterest }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>Minimum Interest Rate</label>
                                <input type="number" class="form-control" id="txtMinimumInterest"
                                    value="{{ $loanProductData->minimumInterest }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>Maximum Interest Rate</label>
                                <input type="number" class="form-control" id="txtMaximumInterest"
                                    value="{{ $loanProductData->maximumInterest }}">
                            </div>
                            <div class="col-6 mt-2" hidden>
                                <label>How Many Approval</label>
                                <input type="number" class="form-control" id="txtApprovalCount">
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
                                <label>Active</label>
                                <select class="selectize" id="txtActive">
                                    <option value="Yes" @if ($loanProductData->active == 'Yes') selected @endif>Yes
                                    </option>
                                    <option value="No" @if ($loanProductData->active == 'No') selected @endif>No</option>
                                </select>
                            </div>
                            <div class="col-6 mt-2" hidden>
                                <label>Interest Type</label>
                                <select class="selectize" id="txtInterestType">
                                    <option value="normal" selected>normal</option>
                                    {{-- <option value="Reduce Amount">Reduce Amount</option>
                                    <option value="One Time Payment">One Time Payment</option> --}}
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label class="form-label">Main Category</label>
                                <select class="selectize" id="txtMainCategory">
                                    <option value="">Select Main Category</option>
                                    @foreach ($getloanMainCatData as $mainData)
                                        @if ($loanProductData->mainCategory == $mainData->id)
                                            <option value="{{ $mainData->id }}" selected>{{ $mainData->name }}
                                            </option>
                                        @else
                                            <option value="{{ $mainData->id }}">{{ $mainData->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label class="form-label">Sub Category</label>
                                <select id="txtSubCategory">
                                    <option value="">---Select---</option>
                                </select>
                            </div>
                            <div class="col-12 d-flex justify-content-end mt-3">
                                <button class="btn btn-primary" id="btnUpdateProduct">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
