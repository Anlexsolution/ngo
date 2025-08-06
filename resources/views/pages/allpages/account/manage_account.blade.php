<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                <div class="col-6">
                    <i class="menu-icon ti ti-device-desktop-cog"></i> Manage Account
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <!-- Example single danger button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu dropdown-menu-sm">
                            @if ($userType == 'superAdmin')
                                <li><a class="dropdown-item" href="/create_account">Create Account</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#createTransferModal">Transfer</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#createExpensiveIncomeModal">Expensive / Income</a></li>
                                <li><a class="dropdown-item" href="/collection_transfer">Collection Transfer</a></li>
                            @else
                                @php
                                    $userRolesArray = $getUserRole->pluck('roleName')->toArray();
                                @endphp
                                @if (in_array($userType, $userRolesArray))
                                    @php
                                        $usersDataPer = $permissions;
                                        $usersDataPer = json_decode($usersDataPer, true);
                                    @endphp
                                    @if (in_array('addAccount', $usersDataPer))
                                        <li><a class="dropdown-item" href="/create_account">Create Account</a></li>
                                    @endif
                                    @if (in_array('transferAccount', $usersDataPer))
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#createTransferModal">Transfer</a></li>
                                    @endif
                                    @if (in_array('addExpensiveIncome', $usersDataPer))
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#createExpensiveIncomeModal">Expensive / Income</a></li>
                                    @endif
                                    @if (in_array('collectionTransfer', $usersDataPer))
                                        <li><a class="dropdown-item" href="/collection_transfer">Collection Transfer</a>
                                        </li>
                                    @endif
                                @endif
                            @endif

                        </ul>
                    </div>
                    {{-- <a href="/create_account">  <button class="btn btn-light btn-sm me-2">Create Account</button> </a>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#createTransferModal">Transfer</button> --}}
                </div>
            </div>
            <div class="card-body">
                <br>
                <table class="table table-sm datatableView">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Account name</th>
                            <th>Branch Name</th>
                            <th>Account Number</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($getAccountData as $data)
                            @php
                                $cryptId = Crypt::encrypt($data->id);
                            @endphp
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td><a href="{{ route('view_account_details', $cryptId) }}">
                                        {{ $data->name }}</a></td>
                                <td>{{ $data->branch }}</td>
                                <td>{{ $data->accountNumber }}</td>
                                <td>
                                    @if ($data->balance != 0 || $data->balance != '')
                                        {{ number_format($data->balance, 2) }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if ($data->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">In Active</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">
                                                Edit</a>
                                            <a class="dropdown-item" href="#">
                                                Delete</a>
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


<!-- Add Permission Modal -->
<div class="modal fade" id="createTransferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add New Transfer</h4>
                    <p>Create a new Transfer</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label">From Account</label>
                    <select class="selectize" id="txtFromAccount">
                        <option value="">---Select---</option>
                        @foreach ($getAccountData as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}
                                ({{ number_format($account->balance, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">To Account</label>
                    <select class="selectize" id="txtToAccount">
                        <option value="">---Select---</option>
                        @foreach ($getAccountData as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}
                                ({{ number_format($account->balance, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Transfer Amount</label>
                    <input type="text" class="form-control" id="txtTransferAmount">
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control" id="txtRemarks"></textarea>
                </div>
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateTransfer">Create Transfer</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->


<!-- Add Permission Modal -->
<div class="modal fade" id="createExpensiveIncomeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add New Expensive / Income</h4>
                    <p>Create a new Expensive / Income</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label">Account</label>
                    <select class="selectize" id="txtSelectAccount">
                        <option value="">---Select---</option>
                        @foreach ($getAccountData as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}
                                ({{ number_format($account->balance, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Type</label>
                    <select class="selectize" id="txtType">
                        <option value="">---Select---</option>
                        <option value="Expensive">Expensive</option>
                        <option value="Income">Income</option>
                    </select>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Date</label>
                    <input type="date" class="form-control" id="txtDate">
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Amount</label>
                    <input type="number" class="form-control" id="txtAmount">
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control" id="txtExpensiveRemarks"></textarea>
                </div>
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateExpensiveIncome">Create Expensive /
                        Income</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->
