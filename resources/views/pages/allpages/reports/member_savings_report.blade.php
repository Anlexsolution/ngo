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
                            <i class="menu-icon ti ti-users-group"></i> Member Saving Report
                        </div>
                    </div>
                    <div class="card-body">

                        <!-- ✅ Year Filter -->
                        <form method="GET" action="{{ url('/member_savings_report') }}">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="year">Select Year</label>
                                    <select name="year" id="year" class="form-control">
                                        @php
                                            $currentYear = now()->year;
                                            $selectedYear = request('year', $currentYear);
                                        @endphp
                                        @for ($y = $currentYear; $y >= 2000; $y--)
                                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3 align-self-end">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- ✅ Success/Error Alerts -->
                        @if (session('success'))
                            <div class="alert alert-success success-alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger danger-alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- ✅ Responsive Table -->
                        <div class="table-responsive">
                            <table class="table table-sm mt-3 datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>NIC number</th>
                                        <th>Division</th>
                                        <th>Village</th>
                                        <th>Small Group</th>
                                        <th>Old Account Number</th>
                                        <th>January</th>
                                        <th>February</th>
                                        <th>March</th>
                                        <th>April</th>
                                        <th>May</th>
                                        <th>June</th>
                                        <th>July</th>
                                        <th>August</th>
                                        <th>September</th>
                                        <th>October</th>
                                        <th>November</th>
                                        <th>December</th>
                                        <th class="text-success">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            $encryptedId = encrypt($member->id);
                                            $memberLoans = $getLoansData->where('memberId', $member->id)->where('loanStatus', 'Active')->values();

                                            // Initialize all months
                                            $januaryTotal = $februaryTotal = $marchTotal = $aprilTotal = $mayTotal = $juneTotal =
                                            $julyTotal = $augustTotal = $septemberTotal = $octoberTotal = $novemberTotal = $decemberTotal = 0;
                                        @endphp

                                        @foreach ($getData as $getD)
                                            @if ($getD->memberId == $member->uniqueId && $getD->type == 'Credit')
                                                @php
                                                  $monthNumber = (int) Carbon::parse($getD->created_at)->format('n');

                                                    $amount = $getD->amount ?? 0;
                                                    match ($monthNumber) {
                                                        1 => $januaryTotal += $amount,
                                                        2 => $februaryTotal += $amount,
                                                        3 => $marchTotal += $amount,
                                                        4 => $aprilTotal += $amount,
                                                        5 => $mayTotal += $amount,
                                                        6 => $juneTotal += $amount,
                                                        7 => $julyTotal += $amount,
                                                        8 => $augustTotal += $amount,
                                                        9 => $septemberTotal += $amount,
                                                        10 => $octoberTotal += $amount,
                                                        11 => $novemberTotal += $amount,
                                                        12 => $decemberTotal += $amount,
                                                    };
                                                @endphp
                                            @endif
                                        @endforeach

                                        @php
                                            $yearTotal = $januaryTotal + $februaryTotal + $marchTotal + $aprilTotal +
                                                         $mayTotal + $juneTotal + $julyTotal + $augustTotal +
                                                         $septemberTotal + $octoberTotal + $novemberTotal + $decemberTotal;
                                        @endphp

                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ \Carbon\Carbon::parse($member->created_at)->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="{{ route('view_member_saving_report', $encryptedId) }}">
                                                    {{ $member->firstName }} {{ $member->lastName }}
                                                </a>
                                            </td>
                                            <td>{{ $member->nicNumber }}</td>
                                            <td>
                                                @php $divIdEnc = encrypt($member->divisionId); @endphp
                                                @if ($member->divisionId)
                                                    <a href="{{ route('division_details', $divIdEnc) }}">
                                                        {{ $member->division->divisionName }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @php $villageIdEnc = encrypt($member->villageId); @endphp
                                                @if ($member->villageId)
                                                    <a href="{{ route('village_details', $villageIdEnc) }}">
                                                        {{ $member->village->villageName }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @php $smallgroupIdEnc = encrypt($member->smallGroupId); @endphp
                                                @if ($member->smallGroupId)
                                                    <a href="{{ route('smallgroup_details', $smallgroupIdEnc) }}">
                                                        {{ $member->smallgroup->smallGroupName }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $member->oldAccountNumber }}</td>
                                            <td>{{ number_format($januaryTotal, 2) }}</td>
                                            <td>{{ number_format($februaryTotal, 2) }}</td>
                                            <td>{{ number_format($marchTotal, 2) }}</td>
                                            <td>{{ number_format($aprilTotal, 2) }}</td>
                                            <td>{{ number_format($mayTotal, 2) }}</td>
                                            <td>{{ number_format($juneTotal, 2) }}</td>
                                            <td>{{ number_format($julyTotal, 2) }}</td>
                                            <td>{{ number_format($augustTotal, 2) }}</td>
                                            <td>{{ number_format($septemberTotal, 2) }}</td>
                                            <td>{{ number_format($octoberTotal, 2) }}</td>
                                            <td>{{ number_format($novemberTotal, 2) }}</td>
                                            <td>{{ number_format($decemberTotal, 2) }}</td>
                                            <td class="fw-bold text-success">{{ number_format($yearTotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- /.table-responsive -->
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
            </div>
        </div>
    </div>
</div>
