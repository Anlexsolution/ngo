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
    <h3 class="header">Loan Details</h3>

    <table style="width: 100%; border-collapse: collapse;" border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>Loan Id</th>
                <th>Member Name</th>
                <th>Product Name</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $count = 1; @endphp

            @if (count($getData) > 0)
                @foreach ($getData as $data)
                    @php
                        $loanEncId = Crypt::encrypt($data->id);

                        $memberName = '';
                        foreach ($getMember as $mem) {
                            if ($mem->id == $data->memberId) {
                                $memberName = $mem->firstName;
                                break;
                            }
                        }

                        $productName = '';
                        foreach ($getproduct as $pro) {
                            if ($pro->id == $data->loanProductId) {
                                $productName = $pro->productName;
                                break;
                            }
                        }

                        $statusClass = match ($data->loanStatus) {
                            'Active' => 'bg-success',
                            'Rejected' => 'bg-danger',
                            default => 'bg-primary',
                        };
                    @endphp
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $data->loanId }}</td>
                        <td>{{ $memberName }}</td>
                        <td>{{ $productName }}</td>
                        <td>{{ number_format($data->principal, 2) }}</td>
                        <td><span class="badge {{ $statusClass }}">{{ $data->loanStatus }}</span></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" style="text-align: center; padding: 10px;">
                        No data available
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
