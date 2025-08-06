<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-group"></i> Withdrawal Report
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
                                                    Profession</label>
                                                <select name="divisionId" id="txtProfession" class="selectize">
                                                    <option value="">Select profession</option>
                                                    @foreach ($getProfession as $profession)
                                                        <option value="{{ $profession->name }}">
                                                            {{ $profession->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label fw-bold">Withdrawal Amount</label>
                                            <div class="d-flex">
                                                <input type="number" id="with1Min" class="form-control me-1"
                                                    placeholder="Min" />
                                                <input type="number" id="with1Max" class="form-control"
                                                    placeholder="Max" />
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

                        <a href="{{ route('view_withdrawal_report') }}" class="mt-3" target="_blank">
                            <button class="btn btn-secondary ">
                                PDF
                            </button>
                        </a>
                        <div class="row mt-3">
                            <table class="table table-sm" id="tableWithApproveTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Withdrawal Id</th>
                                        <th>Amount</th>
                                        <th>Name</th>
                                        <th>NIC number</th>
                                        <th>Division</th>
                                        <th>Village</th>
                                        <th>Small Group</th>
                                        <th>Profession</th>
                                        <th>Old Account Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getAllWithdrawal as $withdrawal)
                                        @php
                                            $encryptId = Crypt::encrypt($withdrawal->withdrawalId);
                                        @endphp
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td> <a
                                                    href="{{ route('view_withdrawal_history', $encryptId) }}">{{ $withdrawal->withdrawalId }}</a>
                                            </td>
                                            <td>{{ number_format($withdrawal->amount, 2) }}</td>
                                            <td>
                                                @foreach ($getAllMemberData as $mem)
                                                    @if ($mem->uniqueId == $withdrawal->memberId)
                                                        {{ $mem->firstName }} {{ $mem->lastName }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getAllMemberData as $mem)
                                                    @if ($mem->uniqueId == $withdrawal->memberId)
                                                        {{ $mem->nicNumber }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getAllMemberData as $mem)
                                                    @if ($mem->uniqueId == $withdrawal->memberId)
                                                        @if ($mem->divisionId == '')
                                                            -
                                                        @else
                                                            {{ $mem->division->divisionName }}
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getAllMemberData as $mem)
                                                    @if ($mem->uniqueId == $withdrawal->memberId)
                                                        @if ($mem->villageId == '')
                                                            -
                                                        @else
                                                            {{ $mem->village->villageName }}
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getAllMemberData as $mem)
                                                    @if ($mem->uniqueId == $withdrawal->memberId)
                                                        @if ($mem->smallGroupId == '')
                                                            -
                                                        @else
                                                            {{ $mem->smallgroup->smallGroupName }}
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getAllMemberData as $mem)
                                                    @if ($mem->uniqueId == $withdrawal->memberId)
                                                        {{ $mem->profession }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getAllMemberData as $mem)
                                                    @if ($mem->uniqueId == $withdrawal->memberId)
                                                        {{ $mem->oldAccountNumber }}
                                                    @endif
                                                @endforeach
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
        <div class="row mt-3">
            <div class="col-12 mt-3">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Withdrawal Amount</label>
                                    <p class="total-amount">0</p>
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
