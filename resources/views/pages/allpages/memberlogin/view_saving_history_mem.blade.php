@php
    use Carbon\Carbon;
@endphp
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>

                            @foreach ($getMember as $member)
                                @if ($member->id == $memberId)
                                    {{ $member->firstName }} - {{ $member->nicNumber }} -
                                    {{ $member->oldAccountNumber }} - {{ $member->newAccountNumber }} - Savings
                                @endif
                            @endforeach
                        </div>
                        <div class="col-6 d-flex justify-content-end">

                            @if ($userType == 'superAdmin')
                                <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#transferSavingsAmountModal"><i
                                        class="menu-icon ti ti-square-rounded-plus"></i>
                                    Transfer</button>
                                <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#importSavingHistoryModal"><i
                                        class="menu-icon ti ti-square-rounded-plus"></i>
                                    Import Saving history</button>
                            @else
                                @php
                                    $userRolesArray = $getUserRole->pluck('roleName')->toArray();
                                @endphp

                                @if (in_array($userType, $userRolesArray))
                                    @php
                                        $usersDataPer = $permissions;
                                        $usersDataPer = json_decode($usersDataPer, true);
                                    @endphp

                                    @if (in_array('ImportSavingHistory', $usersDataPer))
                                        <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                            data-bs-target="#importSavingHistoryModal"><i
                                                class="menu-icon ti ti-square-rounded-plus"></i>
                                            Import Saving history</button>
                                    @endif

                                    @if (in_array('transferSavings', $usersDataPer))
                                        <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                            data-bs-target="#transferSavingsAmountModal"><i
                                                class="menu-icon ti ti-square-rounded-plus"></i>
                                            Transfer</button>
                                    @endif
                                @endif
                            @endif

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
                                    <div class="row mt-2">
                                        <div class="col-md-3 me-2">
                                            <div class="form-group">
                                                <label>From Date</label>
                                                <input type="date" class="form-control" id="fromdate">
                                            </div>
                                        </div>
                                        <div class="col-md-3 me-2">
                                            <div class="form-group">
                                                <label>To Date</label>
                                                <input type="date" class="form-control" id="todate">
                                            </div>
                                        </div>
                                        <div class="col-md-3 me-2">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <select class="selectize" id="txtType">
                                                    <option value="">---Select---</option>
                                                    <option value="Credit">Credit</option>
                                                    <option value="Debit">Debit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 me-2 mt-3">
                                            <div class="form-group">
                                                <label>From Amount</label>
                                                <input type="number" class="form-control" id="fromAmount">
                                            </div>
                                        </div>
                                        <div class="col-md-3 me-2 mt-3">
                                            <div class="form-group">
                                                <label>To Amount</label>
                                                <input type="number" class="form-control" id="toAmount">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <table class="table table-sm" id="viewTransTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Transection Id</th>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getSavingHistory as $history)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>
                                                {{ $history->randomId }}
                                            </td>
                                            <td>
                                                @php

                                                    $date = Carbon::createFromFormat(
                                                        'Y-m-d H:i:s',
                                                        $history->created_at,
                                                    );
                                                    $formattedDate = $date->format('Y-m-d');
                                                @endphp
                                                {{ $formattedDate }}
                                            </td>
                                            <td>
                                                @foreach ($getUser as $user)
                                                    @if ($user->id == $history->userId)
                                                        {{ $user->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $history->description }}
                                            </td>
                                            <td>
                                                @if ($history->type == 'Credit')
                                                    <span class="badge bg-success">Credit</span>
                                                @else
                                                    <span class="badge bg-danger">Debit</span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $history->amount }}
                                            </td>
                                            <td>
                                                {{ number_format($history->balance, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach ($geInterData as $history)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>
                                                {{ $history->randomId }}
                                            </td>
                                            <td>
                                                @php

                                                    $date = Carbon::createFromFormat(
                                                        'Y-m-d H:i:s',
                                                        $history->created_at,
                                                    );
                                                    $formattedDate = $date->format('Y-m-d');
                                                @endphp
                                                {{ $formattedDate }}
                                            </td>
                                            <td>
                                                @foreach ($getUser as $user)
                                                    @if ($user->id == $history->userId)
                                                        {{ $user->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $history->description }}
                                            </td>
                                            <td>
                                                @if ($history->type == 'Credit')
                                                    <span class="badge bg-success">Credit</span>
                                                @else
                                                    <span class="badge bg-danger">Debit</span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $history->amount }}
                                            </td>
                                            <td>
                                                {{ number_format($history->balance, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>

                            @foreach ($getMember as $member)
                                @if ($member->id == $memberId)
                                    {{ $member->firstName }} - {{ $member->nicNumber }} -
                                    {{ $member->oldAccountNumber }} - {{ $member->newAccountNumber }} - Withdrawals
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm" id="viewWithTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Withdrawal ID</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>User</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($getWithHisData as $his)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $his->withdrawalId }}</td>
                                        <td>{{ $his->amount }}</td>
                                        <td>{{ $his->status }}</td>
                                        <td>
                                            @foreach ($getUser as $user)
                                                @if ($user->id == $his->userId)
                                                    {{ $user->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$his->reason}}</td>
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


<!-- Import Saving History Modal -->
<div class="modal fade" id="importSavingHistoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h4 class="mb-2">Import Saving History</h4>
                    <p>Savings import function</p>
                </div>

                <!-- Sample Excel Download -->
                <div class="col-12 mb-3 text-center">
                    <a href="{{ asset('excelimportfile/savinghistory.xlsx') }}" class="btn btn-outline-info" download>
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
                    <button class="btn btn-primary me-4" id="btnImportSavingHistory">Import Savings History</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Import Saving History Modal -->


<!-- Transfer Saving History Modal -->
<div class="modal fade" id="transferSavingsAmountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h4 class="mb-2">Transfer Saving Amount</h4>
                    <p>Transfer Saving Amount</p>
                </div>

                <input type="hidden" id="txtMemberUniqueId" value="{{ $memberUniqueId }}" />
                <div class="col-12 mt-3">
                    <div class="form-group">
                        <label>Select Account</label>
                        <select class="selectize" id="txtSelectAcccount">
                            <option value="">---Select---</option>
                            <option value="Death">Death</option>
                            <option value="Other Income">Other Income</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" id="txtAmount" class="form-control" placeholder="Enter Amount" />
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea class="form-control" id="txtRemarks"></textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnTransferAccount">Transfer</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Transfer Saving History Modal -->
