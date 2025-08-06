<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Member Details</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            position: relative;
        }

        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .company-info {
            text-align: center;
            margin-bottom: 10px;
        }

        .profile-image,
        .signature-image {
            display: block;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            object-fit: cover;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        .label {
            font-weight: bold;
            width: 30%;
        }

        .value {
            width: 70%;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-style: italic;
            font-size: 11px;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('assets/img/logo.png') }}" width="100" height="50">
    </div>
    <div class="company-info">
        <div>Sagama Road, Akkaraipattu</div>
        <div>Phone: 0123456789</div>
        <div>Date: {{ now()->format('Y-m-d H:i:s') }}</div>
    </div>
    <hr>
    <h3 class="header">Member Details</h3>

<table style="width: 100%; border-collapse: collapse;" border="1">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>NIC number</th>
            <th>Division</th>
            <th>Village</th>
            <th>Small Group</th>
            <th>Profession</th>
            <th>Old Account Number</th>
            <th>Savings</th>
            <th>Other Income</th>
            <th>Death Subscription</th>
            <th>Status</th>
            <th>Loan 1</th>
            <th>Loan 2</th>
        </tr>
    </thead>
    <tbody>
        {{-- Show session messages outside <tr> --}}
        @if (session('success'))
            <tr>
                <td colspan="14">
                    <div class="mt-3 alert alert-success success-alert">
                        {{ session('success') }}
                    </div>
                </td>
            </tr>
        @endif

        @if (session('error'))
            <tr>
                <td colspan="14">
                    <div class="mt-3 alert alert-danger danger-alert">
                        {{ session('error') }}
                    </div>
                </td>
            </tr>
        @endif

        @php $count = 1; @endphp

        @if(count($getMember) > 0)
            @foreach ($getMember as $member)
                @php
                    $encryptedId = encrypt($member->id);
                    $memberLoans = $getLoansData->where('memberId', $member->id)->take(2)->values();
                @endphp
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $member->firstName }}</td>
                    <td>{{ $member->nicNumber }}</td>
                    <td>{{ $member->divisionId ? $member->division->divisionName : '-' }}</td>
                    <td>{{ $member->villageId ? $member->village->villageName : '-' }}</td>
                    <td>{{ $member->smallGroupId ? $member->smallgroup->smallGroupName : '-' }}</td>
                    <td>{{ $member->profession }}</td>
                    <td>{{ $member->oldAccountNumber }}</td>
                    <td>
                        @php
                            $savings = $getSavingData->firstWhere('memberId', $member->uniqueId);
                        @endphp
                        {{ $savings ? number_format($savings->totalAmount, 2) : '0.00' }}
                    </td>
                    <td>
                        @php
                            $otherIncome = $getOtherIncomeData->firstWhere('memberId', $member->uniqueId);
                        @endphp
                        {{ $otherIncome && $otherIncome->totalAmount !== '' ? number_format($otherIncome->totalAmount, 2) : '0.00' }}
                    </td>
                    <td>
                        @php
                            $deathSub = $getDeathSubData->firstWhere('memberId', $member->uniqueId);
                        @endphp
                        {{ $deathSub && $deathSub->totalAmount !== '' ? number_format($deathSub->totalAmount, 2) : '0.00' }}
                    </td>
                    <td>
                        @if ($member->status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Non active</span>
                        @endif
                    </td>
                    <td>{{ isset($memberLoans[0]) ? number_format($memberLoans[0]->principal, 2) : '-' }}</td>
                    <td>{{ isset($memberLoans[1]) ? number_format($memberLoans[1]->principal, 2) : '-' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="14" style="text-align: center; padding: 10px;">
                    No member data available.
                </td>
            </tr>
        @endif
    </tbody>
</table>



    <div class="footer">
        This is an auto-generated document.
    </div>

</body>

</html>
