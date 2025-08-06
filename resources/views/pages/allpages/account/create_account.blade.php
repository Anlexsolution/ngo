<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                <i class="menu-icon ti ti-device-desktop-cog"></i> Create Account
            </div>
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label class="fw-bold mt-1">Account Name <span class="text text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtAccountName">
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="form-group">
                            <label class="fw-bold mt-1">Branch Name <span class="text text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtBranchName">
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="form-group">
                            <label class="fw-bold mt-1">Account Number <span class="text text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtAccountNumber">
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="form-group">
                            <label class="fw-bold mt-1">Date <span class="text text-danger">*</span></label>
                            <input type="date" class="form-control" id="txtRegisterDate" value="">
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="form-group">
                            <label class="fw-bold mt-1">Status <span class="text text-danger">*</span></label>
                            <select id="txtStatus" class="form-control">
                                <option value="active">Active</option>
                                <option value="inActive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="form-group">
                            <label class="fw-bold mt-1">Opening Balance <span class="text text-danger">*</span></label>
                            <input type="number" class="form-control" id="txtOpeningBalance">
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="form-group">
                            <label class="fw-bold mt-1">Account Type <span class="text text-danger">*</span></label>
                            <select id="txtAccountType" class="form-control">
                                <option value="BANK">BANK</option>
                                <option value="COLLECTION">COLLECTION</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label class="fw-bold mt-1">Note <span class="text text-danger">*</span></label>
                            <textarea id="txtNote" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row-2 mt-3 d-flex justify-content-end">
                    <button class="btn btn-primary btn-sm" id="btnCreateAccount">Account Create</button>
                </div>
            </div>
        </div>
    </div>
</div>
