<!DOCTYPE html>
<html lang="ta">

<head>
    <meta charset="utf-8">
    <title>Member Summary Report</title>
    <style>
        @font-face {
            font-family: 'NotoSansTamil';
            src: url('{{ storage_path('storage/font/NotoSansTamil-Regular.ttf') }}') format('truetype');
        }

        body {
            font-family: 'NotoSansTamil', DejaVu Sans, sans-serif;
            background-color: #f9f9f9;
            font-size: 12px;
            color: #333;
        }

        .report-wrapper {
            width: 98%;
            margin: auto;
            background: #fff;
            padding: 20px;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            padding: 6px 12px;
            background-color: #e3f2fd;
            border-left: 4px solid #0d6efd;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .info-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .info-box {
            flex: 1 1 45%;
            background: #fefefe;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 6px;
        }

        .label {
            font-weight: bold;
            color: #0a0a0a;
        }

        .value {
            margin-top: 3px;
            color: #2c3e50;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-image {
            border-radius: 8px;
            object-fit: cover;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 12px;
        }

        th {
            background-color: #0d6efd;
            color: white;
            padding: 5px;
            border: 1px solid #ccc;
            text-align: center;
        }

        td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: center;
        }
    </style>
    <style>
        @font-face {
            font-family: 'NotoSansTamil';
            src: url('{{ resource_path('../font/Baamini-Plain.ttf') }}') format('truetype');
        }

        body {
            font-family: 'NotoSansTamil', sans-serif;
        }
    </style>
</head>

<body>
    <div class="report-wrapper">
        <div class="profile-header">
            <img src="{{ public_path('memberimages/' . ($member->profiePhoto ?? 'default.png')) }}" width="120"
                height="120" class="profile-image">
            <h3>{{ $member->title }}. {{ $member->firstName }} {{ $member->lastName }}</h3>
            <p>{{ $member->uniqueId }}</p>
        </div>

        <div class="section-title">அங்கத்தவர் விபரம் / Member Details</div>
        <div class="info-group">
            @php
                use Carbon\Carbon;
                $dob = $member->dateOfBirth ? Carbon::parse($member->dateOfBirth) : null;
                $now = Carbon::now();
                $ageString = $dob ? $dob->diff($now)->format('%y years, %m months, %d days') : '-';

                $fields = [
                    ['First Name / முதற்பெயர்', $member->firstName],
                    ['Last Name / கடைசி பெயர்', $member->lastName],
                    ['NIC / தே.அ. இலக்கம்', $member->nicNumber],
                    ['NIC Issue Date / தே.அ. வழங்கப்பட்ட தேதி', $member->nicIssueDate],
                    ['Gender / பால்நிலை', $member->gender],
                    ['Marital Status / திருமணநிலை', $member->maritalStatus],
                    ['Phone Number / தொலைபேசி இலக்கம்', $member->phoneNumber],
                    ['Date of Birth / பிறந்த தேதி', $dob ? $dob->format('d-m-Y') : '-'],
                    ['Age / வயது', $ageString],
                    ['New Account Number / புதிய கணக்கு இலக்கம்', $member->newAccountNumber],
                    ['Old Account Number / பழைய கணக்கு இலக்கம்', $member->oldAccountNumber],
                    ['Address / முகவரி', $member->address],
                    ['Village / கிராமம்', optional($member->village)->villageName ?? '-'],
                    ['Division / பிரதேசம்', optional($member->division)->divisionName ?? '-'],
                    ['Group Name / குழுவின் பெயர்', optional($member->smallgroup)->smallGroupName ?? '-'],
                    ['Status / நிலை', $member->statusType],
                    [
                        'Profession Type / தொழில் பிரிவு',
                        optional(collect($getPro)->firstWhere('id', $member->profession))->name ?? '-',
                    ],
                    [
                        'Profession / தொழில்',
                        optional(collect($getSubPro)->firstWhere('id', $member->subprofession))->name ?? '-',
                    ],
                    [
                        'GN Division',
                        optional(collect($getGnDivision)->firstWhere('id', $member->gnDivisionId))->gnDivisionName ??
                        '-',
                    ],
                    [
                        'GN Division Small Group',
                        optional(collect($gndivisionSmallgroup)->firstWhere('id', $member->gnDivisionSmallGroup))
                            ->smallGroupName ?? '-',
                    ],
                ];
            @endphp

            @foreach ($fields as [$label, $value])
                <div class="info-box">
                    <div class="label">{{ $label }}</div>
                    <div class="value">{{ $value }}</div>
                </div>
            @endforeach
        </div>

        <div class="section-title">பின்னுருத்தளி விபரம் / Follower Information</div>
        <div class="info-group">
            @php
                $followers = [
                    ['Follower Name / பெயர்', $member->followerName],
                    ['Follower NIC / தே.அ. இலக்கம்', $member->followerNicNumber],
                    ['NIC Issue Date / வழங்கப்பட்ட தேதி', $member->followerIssueDate],
                    ['Follower Address / முகவரி', $member->followerAddress],
                ];
            @endphp

            @foreach ($followers as [$label, $value])
                <div class="info-box">
                    <div class="label">{{ $label }}</div>
                    <div class="value">{{ $value }}</div>
                </div>
            @endforeach
        </div>

        <div class="section-title">கையொப்பம் / Signature</div>
        <div class="profile-header">
            <img src="{{ public_path('memberimages/' . ($member->signature ?? 'default-signature.png')) }}"
                width="250" height="100" class="border rounded">
        </div>

        <div class="section-title">சேமிப்பு விவரங்கள் / Saving Details</div>
        @php
            $encId = Crypt::encrypt($getSavings->savingsId);
        @endphp
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Total Saving Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><a href="{{ route('view_saving_history', $encId) }}">{{ $getSavings->savingsId }}</a></td>
                    <td>{{ $getSavings->totalAmount }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Loan Details Table --}}
    <div class="col-12 mb-4 px-1">
        <div class="section-title">Loan Details / கடன் விவரங்கள்</div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center shadow-sm">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Loan ID</th>
                        <th>Purpose</th>
                        <th>Term</th>
                        <th>Interest</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Principal Arrears</th>
                        <th>Interest Arrears</th>
                        <th>Total Arrears</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = 1; @endphp
                    @forelse ($getDataActive as $data)
                        @php
                            $loanEncId = Crypt::encrypt($data->id);
                            $monthlyPaymentTotal = 0;
                            foreach ($getLoanScheduleData as $schedule) {
                                if ($schedule->loanId == $data->id && $schedule->status == 'paid') {
                                    $monthlyPaymentTotal += $schedule->monthlyPayment;
                                }
                            }

                            $totalPayAmount = 0;
                            $totalPrincipalArreas = 0;
                            $totalInterestArreas = 0;
                            $totalArreasAmount = null;

                            foreach ($getRepaymentData as $repayment) {
                                if ($repayment->loanId == $data->id) {
                                    $totalPayAmount += $repayment->repaymentAmount;
                                    $totalPrincipalArreas += $repayment->principalAmount;
                                    $totalInterestArreas += $repayment->interest;
                                    if (
                                        $totalArreasAmount === null ||
                                        $repayment->lastLoanBalance < $totalArreasAmount
                                    ) {
                                        $totalArreasAmount = $repayment->lastLoanBalance;
                                    }
                                }
                            }

                            $totalArreasAmount ??= 0;

                            $statusClass = match ($data->loanStatus) {
                                'Active' => 'bg-success',
                                'Rejected' => 'bg-danger',
                                default => 'bg-primary',
                            };
                        @endphp
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td><a href="{{ route('view_loan_details', $loanEncId) }}">{{ $data->loanId }}</a>
                            </td>
                            <td>{{ $getLoanPurpose->firstWhere('id', $data->loanPurpose)?->name ?? '-' }}</td>
                            <td>{{ $data->loanterm }}</td>
                            <td>{{ $data->interestRate }}%</td>
                            <td>{{ number_format($data->principal, 2) }}</td>
                            <td>{{ number_format($totalPayAmount, 2) }}</td>
                            <td>{{ number_format($totalPrincipalArreas, 2) }}</td>
                            <td>{{ number_format($totalInterestArreas, 2) }}</td>
                            <td>{{ number_format($totalArreasAmount, 2) }}</td>
                            <td><span class="badge {{ $statusClass }}">{{ $data->loanStatus }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-muted">No loan records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Guarantor Details Table --}}
    <div class="col-12 px-1">
        <div class="section-title">Guarantor Details / உத்தரவாததாரர் விவரங்கள்</div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center shadow-sm">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>NIC</th>
                        <th>Loan ID</th>
                        <th>Loan Amount</th>
                        <th>Saving Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                        $allGurData = collect($getGurDetails);
                    @endphp

                    @if ($allGurData->isNotEmpty())
                        @foreach ($allGurData as $gur)
                            @php
                                // Determine the correct ID field
                                $guarantorId = $gur->memberId ?? ($gur->gurrantos ?? null);
                                $guarantor = $getAllMemberData->firstWhere('id', $guarantorId);
                            @endphp
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>
                                    @if ($guarantor)
                                        <a href="{{ route('view_member', encrypt($guarantor->id)) }}">
                                            {{ $guarantor->firstName ?? '-' }} {{ $guarantor->lastName ?? '' }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $guarantor->nicNumber ?? '-' }}</td>
                                <td>{{ $gur->loanId }}</td>
                                <td>{{ number_format($gur->principal, 2) }}</td>
                                <td>{{ number_format($gur->savingAmount ?? 0, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-muted">No guarantor data available.</td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    {{-- Notes Details Table --}}
    <div class="col-12 px-1">
        <div class="section-title">Feedback Details / கருத்து விவரங்கள்</div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center shadow-sm">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Id</th>
                        <th>Staff Name</th>
                        <th>Date & Time</th>
                        <th>Title</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($getMemberNotes as $note)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $note->randomId }}</td>
                            <td>
                                @foreach ($getAllUser as $user)
                                    @if ($user->id == $note->createdBy)
                                        {{ $user->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $note->created_at }}</td>
                            <td>{{ $note->title }}</td>
                            <td>{{ $note->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
