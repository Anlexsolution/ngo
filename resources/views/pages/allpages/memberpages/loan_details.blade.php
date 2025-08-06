<div class="row mt-3">
    <table class="table table-sm datatableView">
        <thead>
            <tr>
                <th>#</th>
                <th> Id</th>
                <th> Purpose</th>
                <th>Term</th>
                <th>Interest</th>
                <th>Amount</th>
                <th>Pay Amount</th>
                <th>Collect Principal</th>
                <th>Collect Interest</th>
                <th>Arreas Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $count = 1;
            @endphp
            @foreach ($getData as $data)
                @php
                    $loanEncId = Crypt::encrypt($data->id);
                @endphp
                <tr>
                    <td>{{ $count++ }}</td>
                    <td> <a href="{{ route('view_loan_details', $loanEncId) }}">{{ $data->loanId }}</a></td>
                    <td>
                        @foreach ($getLoanPurpose as $pur)
                            @if ($pur->id == $data->loanPurpose)
                                {{ $pur->name }}
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $data->loanterm }}</td>
                    <td>{{ $data->interestRate }}%</td>
                    <td>{{ number_format($data->principal, 2) }}</td>
                    @php
                        $totalPayAmount = 0;
                        $totalPrincipalArreas = 0;
                        $totalInterestArreas = 0;
                        $totalArreasAmount = null;

                        foreach ($getRepaymentData as $repayment) {
                            if ($repayment->loanId == $data->id) {
                                $totalPayAmount += $repayment->repaymentAmount;
                                $totalPrincipalArreas += $repayment->principalAmount;
                                $totalInterestArreas += $repayment->interest;
                                if ($totalArreasAmount === null || $repayment->lastLoanBalance < $totalArreasAmount) {
                                    $totalArreasAmount = $repayment->lastLoanBalance;
                                }
                            }
                        }

                        if ($totalArreasAmount === null) {
                            $totalArreasAmount = 0;
                        }

                    @endphp
                    <td>{{ number_format($totalPayAmount, 2) }}</td>
                    <td>{{ number_format($totalPrincipalArreas, 2) }}</td>
                    <td>{{ number_format($totalInterestArreas, 2) }}</td>
                    <td>{{ number_format($totalArreasAmount, 2) }}</td>
                    <td>
                        @php
                            if ($data->loanStatus == 'Active') {
                                $statusClass = 'bg-success';
                            } elseif ($data->loanStatus == 'Rejected') {
                                $statusClass = 'bg-danger';
                            } else {
                                $statusClass = 'bg-primary';
                            }

                        @endphp
                        <span class="badge {{ $statusClass }}">{{ $data->loanStatus }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
