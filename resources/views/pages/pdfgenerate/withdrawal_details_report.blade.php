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
    <h3 class="header">Withdrawal Details</h3>

    <table>
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
            @php $count = 1; @endphp

            @if (count($getAllWithdrawal) > 0)
                @foreach ($getAllWithdrawal as $withdrawal)
                    @php
                        $encryptId = Crypt::encrypt($withdrawal->withdrawalId);
                        $member = collect($getAllMemberData)->firstWhere('uniqueId', $withdrawal->memberId);
                    @endphp
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>
                            {{ $withdrawal->withdrawalId }}
                        </td>
                        <td>{{ number_format($withdrawal->amount, 2) }}</td>
                        <td>{{ $member->firstName ?? '-' }} {{ $member->lastName ?? '' }}</td>
                        <td>{{ $member->nicNumber ?? '-' }}</td>
                        <td>
                            {{ $member->divisionId ? $member->division->divisionName : '-' }}
                        </td>
                        <td>
                            {{ $member->villageId ? $member->village->villageName : '-' }}
                        </td>
                        <td>
                            {{ $member->smallGroupId ? $member->smallgroup->smallGroupName : '-' }}
                        </td>
                        <td>{{ $member->profession ?? '-' }}</td>
                        <td>{{ $member->oldAccountNumber ?? '-' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10" style="text-align: center; padding: 10px;">
                        No withdrawal data available.
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
