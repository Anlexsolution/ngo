<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-group"></i> Manage Opening Balance
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>NIC Number</th>
                                        <th>Old Account Number</th>
                                        <th>Opening Saving Amount</th>
                                        <th>Opening Death Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp

                                    @foreach ($memberGet as $members)
                                        @php
                                            $memberSavings = $savingsData->firstWhere('memberId', $members->uniqueId);
                                            $memberDeath = $deathData->firstWhere('memberId', $members->uniqueId);
                                        @endphp

                                        @if ($memberSavings || $memberDeath)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td>{{ $members->firstName ?? 'N/A' }}</td>
                                                <td>{{ $members->nicNumber ?? 'N/A' }}</td>
                                                <td>{{ $members->oldAccountNumber ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($memberSavings)
                                                        <input type="number"
                                                            class="form-control savingsTotalUpdateField"
                                                            value="{{ $memberSavings->amount }}"
                                                            id="{{ $memberSavings->id }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($memberDeath)
                                                        <input type="number"
                                                            class="form-control deathTotalUpdateField"
                                                            value="{{ $memberDeath->amount }}"
                                                            id="{{ $memberDeath->id }}">
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($count > 1)
                                <div class="col-12 d-flex justify-content-end mt-3">
                                    <button class="btn btn-primary" id="btnSavingAmountSubmit">Submit</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
