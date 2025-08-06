<!-- DataTables & jQuery -->

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<style>
    .checkbox-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
        background: #ffffff;
        padding: 15px 20px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .checkbox-wrapper label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        padding: 8px 12px;
        background-color: #e8edf4;
        border-radius: 6px;
        border: 1px solid #d0d7e5;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .checkbox-wrapper label:hover {
        background-color: #d6e4f0;
    }

    .checkbox-wrapper input[type="checkbox"] {
        accent-color: #0d6efd;
        transform: scale(1.2);
    }
</style>





<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>Member Report
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
                                    <div class="row">
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
                                            <label class="form-label fw-bold">Loan 1 Range</label>
                                            <div class="d-flex">
                                                <input type="number" id="loan1Min" class="form-control me-1"
                                                    placeholder="Min" />
                                                <input type="number" id="loan1Max" class="form-control"
                                                    placeholder="Max" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label fw-bold">Loan 2 Range</label>
                                            <div class="d-flex">
                                                <input type="number" id="loan2Min" class="form-control me-1"
                                                    placeholder="Min" />
                                                <input type="number" id="loan2Max" class="form-control"
                                                    placeholder="Max" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label fw-bold">Savings Range</label>
                                            <div class="d-flex">
                                                <input type="number" id="savingsMin" class="form-control me-1"
                                                    placeholder="Min" />
                                                <input type="number" id="savingsMax" class="form-control"
                                                    placeholder="Max" />
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
                                            <label class="form-label fw-bold">Date</label>
                                            <div class="d-flex">
                                                <input type="date" id="filterDate" class="form-control me-1" />
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


                        {{-- <a href="{{ route('view_pdf_member') }}" class="mt-3" target="_blank">
                            <button class="btn btn-secondary ">
                                PDF
                            </button>
                        </a> --}}

                        <button id="exportToPdf" class="btn btn-secondary mt-3">PDF</button>

                        <!-- Column Checkbox Controls -->
                        <div class="checkbox-wrapper">
                            @php
                                $columns = [
                                    '#',
                                    'Name',
                                    'NIC',
                                    'Division',
                                    'Village',
                                    'Group',
                                    'Old Acc No',
                                    'Savings',
                                    'Other Income',
                                    'Death Sub',
                                    'Loan',
                                    'Profession Type',
                                    'Profession',
                                    'Address',
                                    'NIC Issue Date',
                                    'Marital Status',
                                    'Date Of Birth',
                                    'Age',
                                    'Follower Name',
                                    'Follower Address',
                                    'Follower NIC Number',
                                    'Follower Issue Date',
                                    'Status',
                                ];
                            @endphp
                            @foreach ($columns as $index => $label)
                                <label>
                                    <input type="checkbox" class="col-toggle" data-index="{{ $index }}"
                                        checked>
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>

                        <!-- Flash Messages -->
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="row mt-3">
                            <table class="table table-sm mt-3" id="tableMemberReports">
                                <thead>
                                    <tr>
                                        <th>#</th>

                                        <th>Name</th>
                                        <th>NIC number</th>
                                        <th>Division</th>
                                        <th>Village</th>
                                        <th>Small Group</th>
                                        <th>Old Account Number</th>
                                        <th>Savings</th>
                                        <th>Other Income</th>
                                        <th>Death Subscription</th>
                                        <th>Total Loan</th>
                                        <th>Profession Type</th>
                                        <th>Profession</th>
                                        <th>Address</th>
                                        <th>NIC Issue Date</th>
                                        <th>Marital Status</th>
                                        <th>Date Of Birth</th>
                                        <th>Age</th>
                                        <th>Follower Name</th>
                                        <th>Follower Address</th>
                                        <th>Follower NIC Number</th>
                                        <th>Follower Issue Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (session('success'))
                                        <div class="mt-3 alert alert-success success-alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="mt-3 alert alert-danger danger-alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            $encryptedId = encrypt($member->id);
                                        @endphp
                                        @php
                                            $memberLoans = $getLoansData
                                                ->where('memberId', $member->id)
                                                ->where('loanStatus', 'Active')
                                                ->values();
                                            $totalLoanAmount = $memberLoans->sum('principal');
                                            $ageString = '-';

                                            if (!empty($member->dateOfBirth)) {
                                                try {
                                                    $dob = \Carbon\Carbon::parse($member->dateOfBirth)->startOfDay();
                                                    $now = \Carbon\Carbon::now()->startOfDay();
                                                    $diff = $dob->diff($now);
                                                    $ageString = "{$diff->y} years, {$diff->m} months, {$diff->d} days";
                                                } catch (\Exception $e) {
                                                    $ageString = '-';
                                                }
                                            }
                                        @endphp


                                        <tr>
                                            <td>{{ $count++ }}</td>


                                            <td> <a href="{{ route('view_member', $encryptedId) }}">
                                                    {{ $member->firstName }} {{ $member->lastName }}</a></td>
                                            <td>{{ $member->nicNumber }}</td>
                                            <td>
                                                @php
                                                    $divIdEnc = encrypt($member->divisionId);
                                                @endphp
                                                @if ($member->divisionId == '')
                                                    -
                                                @else
                                                    <a href="{{ route('division_details', $divIdEnc) }}">
                                                        {{ $member->division->divisionName }} </a>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $villageIdEnc = encrypt($member->villageId);
                                                @endphp
                                                @if ($member->villageId == '')
                                                    -
                                                @else
                                                    <a href="{{ route('village_details', $villageIdEnc) }}">
                                                        {{ $member->village->villageName }} </a>
                                                @endif
                                            </td>
                                            @php
                                                $smallgroupIdEnc = encrypt($member->smallGroupId);
                                            @endphp
                                            @if ($member->smallGroupId == '')
                                                <td>-</td>
                                            @else
                                                <td><a
                                                        href="{{ route('smallgroup_details', $smallgroupIdEnc) }}">{{ $member->smallgroup->smallGroupName }}</a>
                                                </td>
                                            @endif


                                            <td>{{ $member->oldAccountNumber }}</td>
                                            <td>
                                                @foreach ($getSavingData as $data)
                                                    @if ($data->memberId == $member->uniqueId)
                                                        @php
                                                            $encryptedId = encrypt($data->savingsId);
                                                        @endphp
                                                        <a href="{{ route('view_saving_history', $encryptedId) }}">
                                                            {{ number_format($data->totalAmount, 2) }} </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getOtherIncomeData as $data)
                                                    @if ($data->memberId == $member->uniqueId)
                                                        @if ($data->totalAmount == '')
                                                            0
                                                        @else
                                                            {{ number_format($data->totalAmount, 2) }}
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getDeathSubData as $data)
                                                    @if ($data->memberId == $member->uniqueId)
                                                        @if ($data->totalAmount == '')
                                                            0
                                                        @else
                                                            @php
                                                                $encryptedId = encrypt($data->deathId);
                                                            @endphp
                                                            <a href="{{ route('view_death_history', $encryptedId) }}">
                                                                {{ number_format($data->totalAmount, 2) }} </a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>

                                            <td>
                                                @php
                                                    $loanone = $memberLoans[0]->principal ?? 0;
                                                    $loantwo = $memberLoans[1]->principal ?? 0;
                                                    $totalLoan = $loanone + $loantwo;
                                                @endphp
                                                {{ number_format($totalLoanAmount, 2) }}
                                            </td>
                                            <td>
                                                @foreach ($getProfession as $pro)
                                                    @if ($pro->id == $member->profession)
                                                        {{ $pro->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $member->subprofession->name ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $member->address }}
                                            </td>
                                            <td>
                                                {{ $member->nicIssueDate }}
                                            </td>
                                            <td>
                                                {{ $member->maritalStatus }}
                                            </td>
                                            <td>{{ $member->dateOfBirth ? \Carbon\Carbon::parse($member->dateOfBirth)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td>{{ $ageString }}</td>


                                            <td>
                                                {{ $member->followerName }}
                                            </td>
                                            <td>
                                                {{ $member->followerAddress }}
                                            </td>
                                            <td>
                                                {{ $member->followerNicNumber }}
                                            </td>
                                            <td>
                                                {{ $member->followerIssueDate }}
                                            </td>
                                            <td>
                                                @if ($member->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Non active</span>
                                                @endif
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
                                    <label class="fw-bold">Total Savings Amount</label>
                                    <p class="total-savings-amount">0.00</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Other Income Amount</label>
                                    <p class="total-other-amount">0.00</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Death Subscription Amount</label>
                                    <p class="total-death-amount">0.00</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Loan Amount</label>
                                    <p class="total-loan1-amount">0.00</p>
                                </div>
                            </div>
                            {{-- <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Loan 2 Amount</label>
                                    <p class="total-loan2-amount">0.00</p>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this member?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var divisionId = document.getElementById('divisionId');
        var villageId = document.getElementById('villageId');
        var smallGroupDiv = document.getElementById('selectSmallGroupDiv');

        function toggleSmallGroupDropdown() {
            if (divisionId.value || villageId.value) {
                smallGroupDiv.style.display = 'block';
            } else {
                smallGroupDiv.style.display = 'none';
            }
        }

        toggleSmallGroupDropdown();

        divisionId.addEventListener('change', toggleSmallGroupDropdown);
        villageId.addEventListener('change', toggleSmallGroupDropdown);
    });
</script>
<!-- JS: Toggle Column Visibility -->
<script>
    // let table;

    // $(document).ready(function () {
    //     table = $('#tableMemberReports').DataTable({
    //         scrollX: true,
    //         scrollY: '750px',
    //         scrollCollapse: true,
    //         autoWidth: true,
    //         responsive: false,
    //         pageLength: 25


    //     });

    //     $('.col-toggle').on('change', function () {
    //         const colIndex = $(this).data('index');
    //         const column = table.column(colIndex);
    //         column.visible(this.checked);
    //     });
    // });
</script>
