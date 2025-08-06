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
    <h3 class="header">Collection VS Deposit Details</h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>User</th>
                <th>Collection Amount</th>
                <th>Deposit Amount</th>
                <th>Difference</th>
            </tr>
        </thead>
        <tbody>
            @php $count = 1; @endphp

            @if (count($collectionData) > 0)
                @foreach ($collectionData as $collection)
                    @php
                        $datetime = $collection->created_at;
                        $dateOnly = \Carbon\Carbon::parse($datetime)->format('Y-m-d');

                        // Find user name
                        $userName = '';
                        foreach ($getUser as $user) {
                            if ($user->id == $collection->depositBy) {
                                $userName = $user->name;
                                break;
                            }
                        }

                        // Calculate total collection amount for this user on this date
                        $totalCollectionAmount = 0;
                        foreach ($accountTransectionHis as $trans) {
                            if (
                                $trans->collectionBy == $collection->depositBy &&
                                \Carbon\Carbon::parse($trans->created_at)->format('Y-m-d') == $dateOnly
                            ) {
                                $totalCollectionAmount += $trans->amount;
                            }
                        }

                        $depositAmount = $collection->amount ?? 0;
                        $difference = $totalCollectionAmount - $depositAmount;
                    @endphp
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $dateOnly }}</td>
                        <td>{{ $userName }}</td>
                        <td>{{ number_format($totalCollectionAmount, 2) }}</td>
                        <td>{{ number_format($depositAmount, 2) }}</td>
                        <td>{{ number_format($difference, 2) }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" style="text-align: center; padding: 10px;">
                        No collection records available.
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
