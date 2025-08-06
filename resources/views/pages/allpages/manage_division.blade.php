<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mt-3">

            <div class="col-12 col-sm-6 col-lg-4 mb-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="mb-4 text-heading ti ti-vocabulary ti-32px"></i>
                        <h5>Add New Division</h5>
                        <a href="/create_division">
                            <button type="button" class="btn btn-primary">
                                ADD
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 mb-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="mb-4 text-heading ti ti-map-search ti-32px"></i>
                        <h5>Add New GN Division</h5>
                        <a href="/create_division_by_gn">
                            <button type="button" class="btn btn-primary">
                                ADD
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 mb-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="mb-4 text-heading ti ti-users-group ti-32px"></i>
                        <h5>Add New Small Group</h5>
                        <a href="/create_smallgroup_by_gn">
                            <button type="button" class="btn btn-primary">
                                ADD
                            </button>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> Division by GN
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Division Name</th>
                                        <th>Gn Division Name</th>
                                        <th>Small Group</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp

                                    @foreach ($getGnSmallGroup as $gnsmall)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                @foreach ($getDivision as $divi)
                                                    @if ($divi->id == $gnsmall->divisionId)
                                                        {{ $divi->divisionName }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getGnDivision as $gn)
                                                    @if ($gn->id == $gnsmall->gnDivisionId)
                                                        {{ $gn->gnDivisionName }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $gnsmall->smallGroupName }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-black" href="#"><i
                                                                class="ti ti-edit me-1"></i> Edit</a>
                                                        <a class="dropdown-item text-danger" href="#"><i
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
