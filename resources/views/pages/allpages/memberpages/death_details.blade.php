<div class="row mt-3">
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
                    $encryptedId = encrypt($getDeath->deathId);
                @endphp
                <td>{{ $count++ }}</td>
                <td>
                    <a href="{{ route('view_death_history', $encryptedId) }}">
                        {{ $getDeath->deathId ?? 'N/A' }}
                    </a>
                </td>
                <!-- <td>{{ $member->firstName }}</td> -->
                <td>{{ number_format($getDeath->totalAmount, 2) }}</td>
            </tr>
        </tbody>
    </table>
</div>
