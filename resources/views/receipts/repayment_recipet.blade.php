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
        <div style="font-family: Arial, sans-serif; text-align: center;">
            <div style=" margin: auto; border: 1px solid #000; padding: 10px;">
                <div style="font-size: 18px; font-weight: bold;"> <img src="../../assets/img/logo.png" alt="" height="70" width="110"></div>
                <div style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">Sagama Road, Akkaraipattu<br>0672277276, 0772242265</div>
                <div style="font-size: 16px; font-weight: bold; border-bottom: 1px solid #000; margin-bottom: 5px;">Payment Receipt</div>
                <div style="text-align: left; margin-top: 10px;">
                    <strong>Date:</strong> {{$getData->repaymentDate}}<br>
                    <strong>Transaction ID:</strong> {{$getData->transectionId}}<br>
                    <strong>FO Name:</strong> {{$getmemApproverDetails->name}}
                </div>
                <div style="text-align: left; margin-top: 10px;">
                    <strong>Member Name:</strong> {{$getmemDetails->firstName}} {{$getmemDetails->lastName}}<br>
                    <strong>Member NIC:</strong> {{$getmemDetails->nicNumber}}<br>
                    <strong>Member Acc No:</strong> {{$getmemDetails->newAccountNumber}}
                </div>
                <div style="text-align: left; margin-top: 10px;">
                    <div style="font-size: 16px; font-weight: bold; border-bottom: 1px solid #000; margin-bottom: 5px;">Loan Payment</div>
                    <strong>Loan ID:</strong> {{$getloanDetails->loanId}}<br>
                    <strong>Loan Amount:</strong> Rs. {{number_format($getloanDetails->principal, 2)}}<br>
                    <strong>Capital:</strong> Rs. {{number_format($getData->principalAmount, 2)}}<br>
                    <strong>Interest:</strong> Rs. {{number_format($getData->interest, 2)}}<br>
                    <strong>Total Payment:</strong> Rs. {{number_format($getData->repaymentAmount, 2)}}<br>
                    <strong>Loan Outstanding:</strong> Rs. {{number_format($getData->lastLoanBalance, 2)}}
                </div>
                <div style="text-align: left; margin-top: 10px;">
                    <div style="font-size: 16px; font-weight: bold; border-bottom: 1px solid #000; margin-bottom: 5px;">Saving Payment</div>
                    <strong>Payment:</strong> Rs. {{number_format($getData->savingAmount, 2)}}<br>
                    <strong>Total Saving:</strong> Rs. {{number_format($getmemSavDetails->totalAmount, 2)}}
                </div>
                <div style="margin-top: 15px; font-size: 12px;">
                    Thank you for your payment<br>
                    Better Life for all
                </div>
            </div>
        </div>
    </div>
</body>
</html>
