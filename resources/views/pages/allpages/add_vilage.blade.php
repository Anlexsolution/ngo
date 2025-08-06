<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-map-search"></i> Create New Village
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-6">
                                    <label for="divisionId" class="form-label fw-bold">Select Division</label>
                                    <select name="divisionId" id="divisionId" class="selectize">
                                        @foreach ($getDivision as $division)
                                            <option value="{{ $division->id }}">{{ $division->divisionName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label class="form-label w-100" for="villageName">Village Name</label>
                                    <div class="input-group input-group-merge">
                                        <input id="villageName" name="villageName" class="form-control mt-2"
                                            type="text" placeholder="Village Name" />
                                    </div>
                                </div>
                                <div class="col-12 text-center d-flex justify-content-end mt-3">
                                    <button id="btnCreateVillage" class="btn btn-primary me-3">Create</button>
                                </div>
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
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Village ID</th>
                                        <th>Division Name</th>
                                        <th>Village Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($getVillage as $village)
                                        <tr>
                                            <td>@php
                                                echo $i++;
                                            @endphp</td>
                                            <td>{{ $village->id }}</td>
                                            <td>

                                                @foreach ($getDivision as $division)
                                                    @php
                                                        $divisionId = $division->id;
                                                        if ($village->divisionId == $divisionId) {
                                                            echo $division->divisionName;
                                                        }
                                                    @endphp
                                                @endforeach
                                            </td>
                                            <td>{{ $village->villageName }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-black" href="#"><i
                                                                class="ti ti-edit me-1"></i> Edit</a>
                                                        <a class="dropdown-item text-danger btnDeleteVillageModal"
                                                            data-id="{{ $village->id }}"><i
                                                                class="ti ti-trash me-1"></i> Delete</a>
                                                    </div>
                                                </div>
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

{{-- delete village modal --}}
<div class="modal fade" id="villageDeleteModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtVillageId">
                Are you sure you want to delete this Village?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteVillageBtn">Delete</button>
            </div>
        </div>
    </div>
</div>
{{-- delete village modal --}}
