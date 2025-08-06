<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>Manage Other Incomes
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            @if ($userType == 'superAdmin')
                                <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#importOtherIncomeModal"><i
                                        class="menu-icon ti ti-square-rounded-plus"></i>
                                    Import Other Income</button>
                            @else
                                @php
                                    $userRolesArray = $getUserRole->pluck('roleName')->toArray();
                                @endphp

                                @if (in_array($userType, $userRolesArray))
                                    @php
                                        $usersDataPer = $permissions;
                                        $usersDataPer = json_decode($usersDataPer, true);
                                    @endphp

                                    @if (in_array('importOtherIncome', $usersDataPer))
                                        <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                            data-bs-target="#importOtherIncomeModal"><i
                                                class="menu-icon ti ti-square-rounded-plus"></i>
                                            Import Other Income</button>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>NIC number</th>
                                        <th>Division</th>
                                        <th>Village</th>
                                        <th>Small Group</th>
                                        <th>Profession</th>
                                        <th>Old Account Number</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getOtherIncome as $savings)
                                        @php
                                            $encryptedId = encrypt($savings->incomId);
                                        @endphp
                                        @if (auth()->user()->userType == 'superAdmin')
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td> <a href="{{ route('view_death_history', $encryptedId) }}">
                                                        {{ $savings->incomId ?? 'N/A' }}
                                                    </a></td>
                                                <td>{{ $savings->member->firstName ?? 'N/A' }}</td>
                                                <td>{{ $savings->member->nicNumber ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($savings->member->divisionId == '')
                                                        -
                                                    @else
                                                        {{ $savings->member->division->divisionName }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($savings->member->villageId == '')
                                                        -
                                                    @else
                                                        {{ $savings->member->village->villageName }}
                                                    @endif
                                                </td>
                                                @if ($savings->member->smallGroupId == '')
                                                    <td>-</td>
                                                @else
                                                    <td>{{ $savings->member->smallgroup->smallGroupName }}</td>
                                                @endif
                                                <td>{{ $savings->member->profession }}</td>
                                                <td>{{ $savings->member->oldAccountNumber }}</td>

                                                <td>{{ $savings->totalAmount ?? 'N/A' }}</td>

                                            </tr>
                                        @else
                                            @php
                                                $divArray = auth()->user()->division;
                                                $vilArray = auth()->user()->village;
                                            @endphp
                                            @if ($divArray != '' || $divArray != null || $vilArray != '' || $vilArray != null)
                                                @if (in_array($savings->member->divisionId, json_decode(auth()->user()->division)) &&
                                                        in_array($savings->member->villageId, json_decode(auth()->user()->village)))
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td> <a href="{{ route('view_death_history', $encryptedId) }}">
                                                                {{ $savings->incomId ?? 'N/A' }}
                                                            </a></td>
                                                        <td>{{ $savings->member->firstName ?? 'N/A' }}</td>
                                                        <td>{{ $savings->member->nicNumber ?? 'N/A' }}</td>
                                                        <td>
                                                            @if ($savings->member->divisionId == '')
                                                                -
                                                            @else
                                                                {{ $savings->member->division->divisionName }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($savings->member->villageId == '')
                                                                -
                                                            @else
                                                                {{ $savings->member->village->villageName }}
                                                            @endif
                                                        </td>
                                                        @if ($savings->member->smallGroupId == '')
                                                            <td>-</td>
                                                        @else
                                                            <td>{{ $savings->member->smallgroup->smallGroupName }}</td>
                                                        @endif
                                                        <td>{{ $savings->member->profession }}</td>
                                                        <td>{{ $savings->member->oldAccountNumber }}</td>

                                                        <td>{{ $savings->totalAmount ?? 'N/A' }}</td>

                                                    </tr>
                                                @endif
                                            @endif
                                        @endif
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


<!--/ Import Other Income Modal -->
<div class="modal fade" id="importOtherIncomeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h4 class="mb-2">Import Other Income</h4>
                    <p>Other Income import function</p>
                </div>

                <!-- Sample Excel Download -->
                <div class="col-12 mb-3 text-center">
                    <a href="{{ asset('excelimportfile/otherincome.xlsx') }}" class="btn btn-outline-info" download>
                        Download Sample Excel
                    </a>
                </div>

                <!-- File Input -->
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtImportFile">Choose Excel file</label>
                    <input type="file" id="txtImportFile" class="form-control" accept=".xlsx, .xls, .csv" />
                </div>

                <!-- Action Buttons -->
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnImportOtherIncome">Import Other Income</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Import Other Income Modal -->
