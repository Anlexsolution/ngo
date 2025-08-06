<table class="table table-sm datatableView">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Amount to pay</th>
            <th>Principal Amount</th>
            <th>Interest</th>
            <th>Balance</th>
            <th>Repayment Officer</th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 1;
        @endphp
        @foreach ($getRepaymentDetails as $repayment)
            <tr>
                <td>{{$count++}}</td>
                <td>{{$repayment->repaymentDate}}</td>
                <td>{{number_format($repayment->repaymentAmount, 2)}}</td>
                <td>{{number_format($repayment->principalAmount, 2)}}</td>
                <td>{{number_format($repayment->interest, 2)}}</td>
                <td>{{number_format($repayment->lastLoanBalance, 2)}}</td>
                <td>@foreach ($getAllUser as $allUser)
                    @if ($allUser->id == $repayment->userId)
                        {{$allUser->name}}
                    @endif
                @endforeach</td>
            </tr>
        @endforeach
    </tbody>
</table>
