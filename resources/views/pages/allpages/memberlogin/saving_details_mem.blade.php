<div class="row mt-3" style="width: 100%">
    <table class="table table-sm datatableView">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <!-- <th>Name</th> -->
                <th>Total Saving Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $count = 1;
            @endphp
            <tr>
                @php
                    $encId = Crypt::encrypt($getSavings->savingsId);
                @endphp
                <td>{{ $count++ }}</td>
                <td>
                    <a href="{{route('view_saving_history_mem',  $encId)}}">
                        {{ $getSavings->savingsId }}
                    </a>
                </td>
                <!-- <td>{{ $member->firstName }}</td> -->
                <td>{{ $getSavings->totalAmount }}</td>
            </tr>
        </tbody>
    </table>
</div>
