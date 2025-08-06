<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>Loan Arreas Report
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

                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Loan Amount</label>
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
                           <a href="{{ route('view_pdf_loan_arreas_report') }}" class="mt-3" target="_blank">
                            <button class="btn btn-secondary ">
                                PDF
                            </button>
                        </a>
                        <table class="table table-sm" id="loanReportTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Loan ID</th>
                                    <th>Loan Amount</th>
                                    <th>Loan Arreass</th>
                                    <th>Member Name</th>
                                    <th>Division</th>
                                    <th>Village</th>
                                    <th>Small Group</th>
                                    <th>Member NIC</th>
                                    <th>Old Account Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($getLoanData as $data)
                                    @php
                                        $loanEncId = Crypt::encrypt($data->id);
                                    @endphp
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td> <a
                                                href="{{ route('view_loan_details', $loanEncId) }}">{{ $data->loanId }}</a>
                                        </td>
                                        <td>{{ number_format($data->principal, 2) }}</td>
                                        <td>
                                            @php
                                                $matchingBalances = $getAllRepaymentData
                                                    ->where('loanId', $data->id)
                                                    ->pluck('lastLoanBalance');
                                                $minBalance = $matchingBalances->min();
                                            @endphp

                                            @if ($minBalance !== null)
                                                {{ number_format($minBalance, 2) }}
                                            @else
                                                {{ number_format($data->principal, 2) }}
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($getAllMemberData as $mem)
                                                @if ($mem->id == $data->memberId)
                                                    {{ $mem->firstName }} {{ $mem->lastName }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($getAllMemberData as $mem)
                                                @if ($mem->id == $data->memberId)
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
                                                @if ($mem->id == $data->memberId)
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
                                                @if ($mem->id == $data->memberId)
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
                                                @if ($mem->id == $data->memberId)
                                                    {{ $mem->nicNumber }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($getAllMemberData as $mem)
                                                @if ($mem->id == $data->memberId)
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
        <div class="col-12 mt-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
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
                                <label class="fw-bold">Total loan Amount</label>
                                <p class="total-loan-amount">0.00</p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label class="fw-bold">Total loan Arreas Amount</label>
                                <p class="total-loan-arreas-amount">0.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
