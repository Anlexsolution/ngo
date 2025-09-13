<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-map-search"></i> Create New Gn Division
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form id="gnDivisionForm" action="/createGnDivisiondata" method="POST">
                                @csrf
                                @if ($errors->any())
                                    <div class="row">
                                        {!! implode('', $errors->all('<div class="alert alert-danger col-sm-12 col-md-12" role="alert">:message</div>')) !!}
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="mt-3 alert alert-success success-alert">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="mt-3 alert alert-danger danger-alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-6 mt-3">
                                        <label for="divisionId" class="form-label fw-bold">Select Division</label>
                                        <select name="divisionId" id="divisionId" class="selectize">
                                            @foreach ($getDivision as $division)
                                                <option value="{{ $division->id }}">{{ $division->divisionName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label class="form-label w-100" for="villageName">Gn Division Name</label>
                                        <div class="input-group input-group-merge mt-2">
                                            <input id="gnDivisionName" name="gnDivisionName" class="form-control"
                                                type="text" placeholder="GN Division Name" />
                                        </div>
                                    </div>
                                    <div class="col-12 text-center d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-primary me-3"
                                            value="createGnDivisiondata">Create</button>
                                    </div>
                                </div>
                            </form>
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
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Division Name</th>
                                        <th>GN Division Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($getGnDivisionData as $div)
                                        <tr>
                                            <td>@php
                                                echo $i++;
                                            @endphp</td>
                                            <td>{{ $div->divisionName }}</td>
                                            <td>{{ $div->gnDivisionName }}</td>
                                            <td>
                                                <button class="btn btn-success btn-sm editBtn"
                                                    data-id="{{ $div->id }}"
                                                    data-divisionid="{{ $div->divisionId }}"
                                                    data-divisionname="{{ $div->divisionName }}"
                                                    data-gndivisionname="{{ $div->gnDivisionName }}">
                                                    Edit
                                                </button>
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


<!-- Edit Modal -->
<div class="modal fade" id="editGnDivisionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Edit GN Division</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <input type="hidden" name="id" id="editId">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label for="editDivisionId" class="form-label fw-bold">Select Division</label>
                        <select name="divisionId" id="editDivisionId" class="">
                            @foreach ($getDivision as $division)
                                <option value="{{ $division->id }}">{{ $division->divisionName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="form-label fw-bold" for="editGnDivisionName">GN Division Name</label>
                        <input id="editGnDivisionName" name="gnDivisionName" class="form-control" type="text" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="btnUpdateGnDivision" class="btn btn-success">Update</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // initialize selectize
        $('#editDivisionId').selectize();

        const editButtons = document.querySelectorAll(".editBtn");
        editButtons.forEach(btn => {
            btn.addEventListener("click", function() {
                let id = this.dataset.id;
                let divisionId = this.dataset.divisionid;
                let gnDivisionName = this.dataset.gndivisionname;

                // set values
                document.getElementById("editId").value = id;
                document.getElementById("editGnDivisionName").value = gnDivisionName;

                // update selectize
                let selectizeControl = $('#editDivisionId')[0].selectize;
                selectizeControl.setValue(divisionId);

                // show modal
                let modal = new bootstrap.Modal(document.getElementById("editGnDivisionModal"));
                modal.show();
            });
        });
    });
</script>
