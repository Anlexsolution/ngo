<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Create Resource Person
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label>Full Name</label>
                                <input type="text" class="form-control" id="txtFullName">
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label>Division</label>
                                <select id="txtDivision">
                                    <option value="">---Select---</option>
                                    @foreach ($getDivision as $division)
                                    <option value="{{ $division->id }}">{{ $division->divisionName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label>Village</label>
                                <select  id="txtVillage">
                                    <option value="">---Select---</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label>Type</label>
                                <select class="selectize" id="txType">
                                    <option value="">---Select---</option>
                                    <option value="Resource Person">Resource Person</option>
                                    <option value="Youth">Youth</option>
                                    <option value="Volunteer">Volunteer</option>
                                    <option value="Acting">Acting</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label>Designation</label>
                                <input type="text" class="form-control" id="txtDesignation">
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label>Main Qualification</label>
                                <select id="txtMainQualification">
                                    <option value="">---Select---</option>
                                    @foreach ($getQualification as $qualification)
                                    <option value="{{ $qualification->id }}">{{ $qualification->qualificationName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label>Sub Qualification</label>
                                <select  id="txtSubQualification">
                                    <option value="">---Select---</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label>Date Of Birth</label>
                                <input type="date" class="form-control" id="txtDateOfBirth">
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label>NIC</label>
                                <input type="text" class="form-control" id="txtNic">
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label>Contact No</label>
                                <input type="number" class="form-control" id="txtContactNo">
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label>Whatsapp No</label>
                                <input type="number" class="form-control" id="txtWhatsappNo">
                            </div>
                            <div class="col-sm-12 col-md-12 d-flex justify-content-end mt-3">
                                <button class="btn btn-primary" id="btnSaveResource">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
