<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>Create Meeting
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Meeting Title</label>
                                    <input type="text" class="form-control" id="txtMeetingTitle">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Meeting Date</label>
                                    <input type="date" class="form-control" id="txtMeetingDate">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Meeting Time</label>
                                    <input type="time" class="form-control" id="txtMeetingTime">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Resource Person</label>
                                    <input type="text" class="form-control" id="txtResourcePerson">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Resource Position</label>
                                   <input type="text" class="form-control" id="txtResourcePosition">
                                </div>
                            </div>
                                  <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Resource Contact No</label>
                                    <input type="number" class="form-control" id="txtResourceContactNo">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Meeting Type</label>
                                    <select class="selectize" id="txtMeetingType">
                                        <option value="">---select---</option>
                                        <option value="Group Meeting">Group Meeting</option>
                                        <option value="Village Meeting">Village Meeting</option>
                                        <option value="Division Meeting">Division Meeting</option>
                                        <option value="Other Meeting">Other Meeting</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3 d-none" id="btnShowDivision">
                                <div class="form-group">
                                    <label>Division</label>
                                    <select id="txtDivision">
                                        <option value="">---Select---</option>
                                        @foreach ($getDivision as $division)
                                            <option value="{{ $division->id }}">{{ $division->divisionName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3 d-none" id="btnShowVIllage">
                                <div class="form-group">
                                    <label>Village</label>
                                    <select id="txtVillage">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3 d-none" id="btnShowSmallgroup">
                                <div class="form-group">
                                    <label>Small Group</label>
                                    <select id="txtSmallGroup">
                                    </select>
                                </div>
                            </div>
                            <hr class="mt-5">
                            <table class="table table-striped" id="showMember">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Member Name</th>
                                        <th>NIC</th>
                                        <th>Old Account Number</th>
                                        <th>Absent</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="col-12 mt-3 d-flex justify-content-end">
                                <button class="btn btn-primary" id="btnSaveMeeting">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
