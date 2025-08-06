<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-list"></i> Add Loan Follower
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="txtLoanId" value="{{ $loanId }}" >
                        <div class="row mt-3">
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" id="txtName">
                                </div>
                            </div>
                            <div class="col-6 mt-3 ">
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea class="form-control" id="txtAddress"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">NIC</label>
                                    <input type="text" class="form-control" id="txtNic">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="">NIC Issue Date</label>
                                    <input type="date" class="form-control" id="txtNicIssueDate">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="">Phone Number</label>
                                    <input type="text" class="form-control" id="txtPhoneNumber">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="">Profession</label>
                                    <select class="selectize" id="txtProfession">
                                        <option value="">Select Profession</option>
                                        @foreach($getPro as $profession)
                                        <option value="{{$profession->id }}">{{ $profession->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-3 d-flex justify-content-end">
                                <button class="btn btn-primary" id="CreateFInalLoan">Create Loan</button>
                            </div>
                        </div>
                     
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>