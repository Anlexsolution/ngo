<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-map-search"></i> Create New Small Group
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Select Division</label>
                                    <select class="selectize" id="txtSelectDivision">
                                        <option value="">---Select---</option>
                                        @foreach ($getDivision as $division)
                                            <option value="{{$division->id}}">{{$division->divisionName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Select Gn Division</label>
                                    <select id="txtSelectGnDivision">
                                        <option value="">---Select---</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Small Group Name</label>
                                   <input type="text" class="form-control mt-2" id="txtGnSmallGroup">
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end mt-2">
                                <button class="btn btn-primary"  id="btnCreateGnSmallGroup">Create Small Group</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>