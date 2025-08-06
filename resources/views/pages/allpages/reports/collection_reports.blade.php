<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>Collection Report
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col d-flex justify-content-end">
                                <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample"
                                    role="button" aria-expanded="false" aria-controls="collapseExample">

                                    <i class="ti ti-filter-pause"></i> Filter
                                </a>
                            </div>
                            <div class="collapse mt-3" id="collapseExample">
                                <div class="card card-body">
                                    <div class="row mt-3">
                                        <div class="col-md-3 me-2">
                                            <div class="form-group">
                                                <label for="divisionId" class="form-label fw-bold">Select
                                                    Division</label>
                                                <select name="divisionId" id="divisionIdData" class="selectize">
                                                    <option value="">Select Division</option>
                                                    @foreach ($getDivision as $division)
                                                        <option value="{{ $division->divisionName }}">
                                                            {{ $division->divisionName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 me-2">
                                            <div class="form-group">
                                                <label for="villageId" class="form-label fw-bold">Select village</label>
                                                <select name="villageId" id="villageId">
                                                    <option value="">Select Village</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 me-2">
                                            <div class="form-group">
                                                <label for="smallgroupId" class="form-label fw-bold">Select Small
                                                    Group</label>
                                                <select name="smallgroupId" id="smallgroupId">
                                                    <option value="">Select Small Group</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 me-2 mt-3">
                                            <div class="form-group">
                                                <label for="divisionId" class="form-label fw-bold">Select
                                                    Field Officer</label>
                                                <select name="fieldOfficerData" id="fieldOfficerData" class="selectize">
                                                    <option value="">Select Field Officer</option>
                                                    @foreach ($getUser as $user)
                                                        <option value="{{ $user->name }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mt-3">
                                            <label class="form-label fw-bold">Amount</label>
                                            <div class="d-flex">
                                                <input type="number" id="with1Min" class="form-control me-1"
                                                    placeholder="Min" />
                                                <input type="number" id="with1Max" class="form-control"
                                                    placeholder="Max" />
                                            </div>
                                        </div>

                                        <div class="col-md-3 mt-3">
                                            <label class="form-label fw-bold">Date Range</label>
                                            <div class="d-flex">
                                                <input type="date" id="minDate" class="form-control me-1" />
                                                <input type="date" id="maxDate" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-primary" id="btnApplyFilters" data-bs-toggle="collapse"
                                                href="#collapseExample" role="button" aria-expanded="false"
                                                aria-controls="collapseExample">
                                                <i class="ti ti-filter-pause"></i> Filter
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('view_collection_report') }}" class="mt-3" target="_blank">
                            <button class="btn btn-secondary ">
                                PDF
                            </button>
                        </a>

                        <table class="table table-sm" id="collectionReportTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Collection By</th>
                                    <th>Member Name</th>
                                    <th>Division</th>
                                    <th>Village</th>
                                    <th>Small Group</th>
                                    <th>Member NIC</th>
                                    <th>Old Account Number</th>
                                    <th>Savings</th>
                                    <th>Principal Amount</th>
                                    <th>Interest Amount</th>
                                    <th>Entre Fees</th>
                                    <th>Total Amount</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($getCollectionData as $index => $data)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $data['collectionDate'] }}</td>
        <td>{{ $data['collectedBy'] }}</td>
        <td>{{ $data['memberFirstName'] }} {{ $data['memberLastName'] }}</td>
        <td><a href="{{ route('division_details', Crypt::encrypt($data['divisionId'])) }}">{{ $data['divisionName'] }}</a></td>
        <td><a href="{{ route('village_details', Crypt::encrypt($data['villageId'])) }}">{{ $data['villageName'] }}</a></td>
        <td><a href="{{ route('smallgroup_details', Crypt::encrypt($data['smallGroupId'])) }}">{{ $data['smallGroupName'] }}</a></td>
        <td>{{ $data['nicNumber'] }}</td>
        <td>{{ $data['oldAccountNumber'] }}</td>
        <td>{{ number_format($data['totalSaving'], 2) }}</td>
        <td>{{ number_format($data['totalPrincipal'], 2) }}</td>
        <td>{{ number_format($data['totalInterest'], 2) }}</td>
        <td>-</td>
        <td>{{ number_format($data['totalAmount'], 2) }}</td>
        <td>{{ $data['descriptions'] }}</td>
    </tr>
@endforeach



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Collector</label>
                                    <p class="total-collector-count">0</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Member</label>
                                    <p class="total-member-count">0</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Division</label>
                                    <p class="total-division-count">0</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Village</label>
                                    <p class="total-village-count">0</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Smallgroup</label>
                                    <p class="total-smallgroup-count">0</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Collection Amount</label>
                                    <p class="total-amount-count">0.00</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
