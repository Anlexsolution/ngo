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
                                    {{ $member->oldAccountNumber }} - {{ $member->newAccountNumber }} - Death
                                @endif
                            @endforeach
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            @if ($userType == 'superAdmin')
                                <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#importDeathHistoryModal"><i
                                        class="menu-icon ti ti-square-rounded-plus"></i>
                                    Import Death history</button>
                            @else
                                @php
                                    $userRolesArray = $getUserRole->pluck('roleName')->toArray();
                                @endphp

                                @if (in_array($userType, $userRolesArray))
                                    @php
                                        $usersDataPer = $permissions;
                                        $usersDataPer = json_decode($usersDataPer, true);
                                    @endphp

                                    @if (in_array('ImportDeathHistory', $usersDataPer))
                                          <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#importDeathHistoryModal"><i
                                        class="menu-icon ti ti-square-rounded-plus"></i>
                                    Import Death history</button>
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
                                    @foreach ($getDeathHistory as $history)
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
                                                    $formattedDate = $date->format('d-m-Y h:i:s A');
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
                                                {{ number_format($history->amount, 2) }}
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
        </div>
    </div>
</div>


<!-- Import Death History Modal -->
<div class="modal fade" id="importDeathHistoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h4 class="mb-2">Import Death History</h4>
                    <p>Death import function</p>
                </div>

                <!-- Sample Excel Download -->
                <div class="col-12 mb-3 text-center">
                    <a href="{{ asset('excelimportfile/deathhistory.xlsx') }}" class="btn btn-outline-info" download>
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
                    <button class="btn btn-primary me-4" id="btnImportDeathHistory">Import Death History</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Import Death History Modal -->
