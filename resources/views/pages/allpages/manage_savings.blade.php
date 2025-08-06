<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i> View Savings
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            @if ($userType == 'superAdmin')
                                <button class="btn btn-light btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#withdrawalModal">Withdrawal</button>
                            @else
                                @php
                                    $userRolesArray = $getUserRole->pluck('roleName')->toArray();
                                @endphp

                                @if (in_array($userType, $userRolesArray))
                                    @php
                                        $usersDataPer = $permissions;
                                        $usersDataPer = json_decode($usersDataPer, true);
                                    @endphp

                                    @if (in_array('Withdrawal', $usersDataPer))
                                        <button class="btn btn-light btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#withdrawalModal">Withdrawal</button>
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
                                    @foreach ($getSavings as $savings)
                                        @php
                                            $encryptedId = encrypt($savings->savingsId);
                                        @endphp
                                        @if (auth()->user()->userType == 'superAdmin')
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td>
                                                    <a href="{{ route('view_saving_history', $encryptedId) }}">
                                                        {{ $savings->savingsId ?? 'N/A' }}
                                                    </a>
                                                </td>
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

                                                <td>{{ isset($savings->totalAmount) ? number_format($savings->totalAmount, 2) : 'N/A' }}
                                                </td>

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
                                                        <td>
                                                            <a href="{{ route('view_saving_history', $encryptedId) }}">
                                                                {{ $savings->savingsId ?? 'N/A' }}
                                                            </a>
                                                        </td>
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

                                                        <td>{{ isset($savings->totalAmount) ? number_format($savings->totalAmount, 2) : 'N/A' }}
                                                        </td>

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

<div class="modal fade" id="withdrawalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Withdrawal 1st request</h4>
                    <p>Wthdrawal</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtMember">Member</label>
                    <select class="selectize" id="txtMember">
                        <option value="">Select Member</option>
                        @foreach ($getAllMemberData as $member)
                            <option value="{{ $member->uniqueId }}">{{ $member->firstName }} -
                                {{ $member->lastName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-4" hidden id="txtGetAccDiv">
                    <label class="form-label" for="txtSavingAccount">Saving Account</label>
                    <select id="txtSavingAccount">
                    </select>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtAmount">Amount</label>
                    <input type="text" id="txtAmount" class="form-control" placeholder="Enter Amount" />
                </div>
                <div class="col-12 mb-4">
                    <label>Approve User</label>
                    <select class="selectize" id="txtApproveUser">
                        <option value="">Select user</option>
                        @foreach ($getUserRole as $userRole)
                            <option value="{{ $userRole->id }}">{{ $userRole->roleName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtReason">Reason</label>
                    <input type="text" id="txtReason" class="form-control" placeholder="Enter Reason" />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnWithdrawalRequest">Request</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
