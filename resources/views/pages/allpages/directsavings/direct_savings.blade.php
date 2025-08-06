<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-device-desktop-cog"></i> Manage Direct Savings
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-4 mt-2">
                                <label>Select Member</label>
                            </div>
                            <div class="col-4">
                                <select class="selectize" id="txtSelectMember">
                                    <option value="">---Select---</option>
                                    @foreach ($getMember as $member)
                                        <option value="{{ $member->id }}">{{ $member->firstName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3" hidden id="divDirectSavings">
                            <div class="col-12 d-flex justify-content-center text-uppercase ">
                                <h4 class="text-primary">Details</h4>
                            </div>
                            <hr>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Member First Name</label>
                                    <div id="txtMemberFirstName"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Member Last Name</label>
                                    <div id="txtMemberLastName"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Address</label>
                                    <div id="txtAddress"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>NIC Number</label>
                                    <div id="txtNic"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>New Account Number</label>
                                    <div id="txtNewAccountNumber"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Old Account Number</label>
                                    <div id="txtOldAccountNumber"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Total Saving Amount</label>
                                    <div id="txtTotalSavingAmount"></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-4 mt-2">
                                    <label>Amount</label>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txtAmount"
                                        placeholder="Enter Amount">
                                </div>
                                <div class="col-4 d-flex justify-content-center">
                                    <button class="btn btn-primary" id="btnSaveDirectSaving">Save</button>
                                  
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
