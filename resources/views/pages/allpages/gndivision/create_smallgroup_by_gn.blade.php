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
                                            <option value="{{ $division->id }}">{{ $division->divisionName }}</option>
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
                                    <input type="text" class="form-control" id="txtGnSmallGroup">
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end mt-2">
                                <button class="btn btn-primary" id="btnCreateGnSmallGroup">Create Small Group</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> View
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col">
                                <table class="table table-sm datatableView">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Division</th>
                                            <th>GN Division</th>
                                            <th>Small Group Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($getSmallGroups as $group)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $group->divisionName }}</td>
                                                <td>{{ $group->gnDivisionName }}</td>
                                                <td>{{ $group->smallGroupName }}</td>
                                                <td>
                                                    <button class="btn btn-success btn-sm editSmallGroupBtn"
                                                        data-id="{{ $group->id }}"
                                                        data-divisionid="{{ $group->divisionId }}"
                                                        data-gndivisionid="{{ $group->gnDivisionId }}"
                                                        data-smallgroupname="{{ $group->smallGroupName }}">Edit</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Edit Small Group Modal -->
<div class="modal fade" id="editSmallGroupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Edit Small Group</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
                <input type="hidden" name="id" id="editSmallGroupId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <label>Select Division</label>
                            <select  id="editSelectDivision" name="divisionId">
                                @foreach ($getDivision as $division)
                                    <option value="{{ $division->id }}">{{ $division->divisionName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Select GN Division</label>
                            <select id="editSelectGnDivision" name="gnDivisionId">

                            </select>
                        </div>
                        <div class="col-4">
                            <label>Small Group Name</label>
                            <input type="text" class="form-control" id="editGnSmallGroup" name="smallGroupName">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="btnUpdateSmallGroup" class="btn btn-success">Update Small Group</button>
                </div>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    // Initialize Selectize for Division dropdown in modal
    let divisionSelectize = $('#editSelectDivision').selectize();

    // Initialize empty Selectize for GN Division
    let gnSelectize = $('#editSelectGnDivision').selectize({
        placeholder: "---Select---"
    });

    // Function to fetch GN Divisions and populate selectize
    function fetchGnDivisions(divisionId, selectedGnId = null) {
        if(!divisionId) {
            gnSelectize[0].selectize.clearOptions();
            return;
        }
        $.ajax({
            url: "/get-gn-division-data",
            type: "POST",
            data: {
                txtSelectDivision: divisionId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.code == 200) {
                    let gnSelect = gnSelectize[0].selectize;
                    gnSelect.clearOptions();
                    // Append new options
                    $(response.getGnDiv).each(function() {
                        gnSelect.addOption({value: this.value, text: this.text});
                    });
                    gnSelect.refreshOptions(false);
                    // Set selected value if provided
                    if(selectedGnId) gnSelect.setValue(selectedGnId);
                } else {
                    alert("Error fetching GN Divisions!");
                }
            },
            error: function() {
                alert("Something went wrong while fetching GN Divisions!");
            }
        });
    }

    // Edit button click
    $('.editSmallGroupBtn').on('click', function () {
        let id = $(this).data('id');
        let divisionId = $(this).data('divisionid');
        let gnDivisionId = $(this).data('gndivisionid');
        let smallGroupName = $(this).data('smallgroupname');

        // Set values
        $('#editSmallGroupId').val(id);
        $('#editGnSmallGroup').val(smallGroupName);

        // Set division
        divisionSelectize[0].selectize.setValue(divisionId);

        // Fetch and set GN Division
        fetchGnDivisions(divisionId, gnDivisionId);

        // Show modal
        let modal = new bootstrap.Modal(document.getElementById('editSmallGroupModal'));
        modal.show();
    });

    // Handle division change dynamically in modal
    $('#editSelectDivision').on('change', function() {
        let divisionId = $(this).val();
        fetchGnDivisions(divisionId);
    });
});
</script>
