<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Manage Interest Settings
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Interest Rate (%) - Year</label>
                                    <input type="number" class="form-control" id="txtInterestRate" value="{{ $getInterest }}" />
                                </div>
                            </div>
                            <div class="col-6" style="margin-top: 30px;">
                                <button class="btn btn-primary btn-sm" id="btnUpdateInterest" >Update Interest</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
