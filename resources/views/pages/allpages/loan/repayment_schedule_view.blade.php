<style>
    .custom-schedule-repay-table th,
    .custom-schedule-repay-table td {
        font-size: 12px;
        padding: 4px 6px;
        vertical-align: middle;
    }

    .custom-schedule-repay-table thead th {
        white-space: nowrap;
    }

    .custom-schedule-repay-table .section-header {
        font-size: 13px;
        font-weight: 600;
        padding: 6px;
    }

    @media (max-width: 768px) {
        .custom-schedule-repay-table th,
        .custom-schedule-repay-table td {
            font-size: 11px;
            padding: 3px 4px;
        }
    }
</style>

@php
    use Carbon\Carbon;

    $combinedData = [];

    // Add schedule data
    foreach ($getScheduleData as $schedule) {
        $combinedData[] = [
            'type' => 'Schedule',
            'date' => $schedule->paymentDate,
            'amount' => $schedule->monthlyPayment,
            'principal' => $schedule->principalPayment,
            'interest' => $schedule->interestPayment,
            'balance' => $schedule->balance,
            'status' => $schedule->status,
        ];
    }

    // Add repayment data
    foreach ($getRepaymentDetails as $repayment) {
        $combinedData[] = [
            'type' => 'Repayment',
            'date' => $repayment->repaymentDate,
            'amount' => $repayment->repaymentAmount,
            'principal' => $repayment->principalAmount,
            'interest' => $repayment->interest,
            'balance' => $repayment->lastLoanBalance,
            'status' => null,
        ];
    }

    // Sort by date
    usort($combinedData, function ($a, $b) {
        return strtotime($a['date']) <=> strtotime($b['date']);
    });
@endphp

<div class="table-responsive">
    <table class="table table-bordered table-sm text-center align-middle custom-schedule-repay-table">
        <thead>
            <tr>
                <th colspan="7" class="bg-info text-white section-header">Schedule</th>
                <th colspan="7" class="bg-primary text-white section-header">Repayment</th>
            </tr>
            <tr>
                {{-- Schedule Columns --}}
                <th>#</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Balance</th>
                <th>Status</th>

                {{-- Repayment Columns --}}
                <th>#</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Balance</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $maxRows = max(count($getScheduleData), count($getRepaymentDetails));
            @endphp

            @for ($i = 0; $i < $maxRows; $i++)
                <tr>
                    {{-- Schedule Row --}}
                    @if (isset($getScheduleData[$i]))
                        @php
                            $schedule = $getScheduleData[$i];
                            $status = strtolower($schedule->status);
                        @endphp
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $schedule->paymentDate }}</td>
                        <td>{{ number_format($schedule->monthlyPayment, 2) }}</td>
                        <td>{{ number_format($schedule->principalPayment, 2) }}</td>
                        <td>{{ number_format($schedule->interestPayment, 2) }}</td>
                        <td>{{ number_format($schedule->balance, 2) }}</td>
                        <td>
                            <span class="badge
                                @if ($status == 'paid') bg-success
                                @elseif ($status == 'unpaid') bg-warning
                                @elseif ($status == 'interest wise') bg-primary
                                @elseif ($status == 'write off') bg-danger
                                @else bg-secondary @endif
                            ">
                                {{ ucfirst($schedule->status) }}
                            </span>
                        </td>
                    @else
                        {{-- Empty Schedule cells --}}
                        <td colspan="7">—</td>
                    @endif

                    {{-- Repayment Row --}}
                    @if (isset($getRepaymentDetails[$i]))
                        @php
                            $repayment = $getRepaymentDetails[$i];
                        @endphp
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $repayment->repaymentDate }}</td>
                        <td>{{ number_format($repayment->repaymentAmount, 2) }}</td>
                        <td>{{ number_format($repayment->principalAmount, 2) }}</td>
                        <td>{{ number_format($repayment->interest, 2) }}</td>
                        <td>{{ number_format($repayment->lastLoanBalance, 2) }}</td>
                        <td>—</td>
                    @else
                        {{-- Empty Repayment cells --}}
                        <td colspan="7">—</td>
                    @endif
                </tr>
            @endfor
        </tbody>
    </table>
</div>
