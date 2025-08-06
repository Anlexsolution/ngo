<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                <i class="menu-icon ti ti-users-group"></i> View Saving History
            </div>
            <div class="card-body">
                <table class="table table-sm datatableView">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Receipt ID</th>
                            <th>Amount</th>
                            <th>Total Amount</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($getSavingTransec as $trans)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $trans->randomId }}</td>
                                <td>{{ number_format($trans->amount, 2) }}</td>
                                <td>{{ number_format($trans->balance, 2) }}</td>
                                <td>{{ $trans->description }}</td>
                                <td>
                                    @if ($trans->type == 'Credit')
                                        <span class="badge bg-success">Credit</span>
                                    @else
                                        <span class="badge bg-danger">Debit</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
