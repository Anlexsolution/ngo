@php
    use Carbon\Carbon;

$date = $getData->created_at;
$formattedDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d M Y h:i A');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .header, .footer {
            text-align: center;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt-container">
        <div class="header">
            <img src="../../assets/img/logo.png" alt="" height="50" width="70" style="margin-left: 10px;">
            <h1>Receipt</h1>
            <p>Receipt ID: {{$getData->randomId}}</p>
        </div>
        <hr>
        <div class="content">
            <p><strong>Date:</strong> {{$formattedDate}}</p>
            <p><strong>Amount:</strong> @php
              echo  number_format($getData->amount, 2);
            @endphp</p>
            <p><strong>Description:</strong> {{$getData->description}}</p>
        </div>
        <hr>
        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
