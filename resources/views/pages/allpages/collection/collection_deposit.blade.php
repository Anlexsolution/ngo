<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                <div class="col-6">
                    <i class="menu-icon ti ti-device-desktop-cog"></i> Manage Collection Deposit
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal"
                        data-bs-target="#createCollectionDepositModal">Deposit</button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm datatableView">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Slip Number</th>
                            <th>Deposit Amount</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($getAllCollectionData as $collection)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $collection->created_date }}</td>
                                <td>{{ $collection->slipNo }}</td>
                                <td>{{ number_format($collection->amount, 2) }}</td>
                                <td>{{ number_format($collection->balance, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Permission Modal -->
<div class="modal fade" id="createCollectionDepositModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add Collection Deposit</h4>
                    <p>Create a new Collection Deposit</p>
                </div>
                <div class="row">
                    <div class="col-6 mb-4">
                        <label class="form-label">Today Collection Amount</label>
                        <p>{{ number_format($totalTodayCollection, 2) }}</p>
                    </div>
                    <div class="col-6 mb-4">
                        <label class="form-label">Total Deposit pending Amount</label>
                        <p id="txtGetbalanceDepositAm">{{ number_format($balanceDeposit, 2) }}</p>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label">Deposit Amount</label>
                    <input type="number" class="form-control" id="txtDepositAmount">
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label">Slip No</label>
                    <input type="text" class="form-control" id="txtSlipNo">
                </div>
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateDeposit"
                        data-totaldeposit="{{ $balanceDeposit }}">Create Deposit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->
