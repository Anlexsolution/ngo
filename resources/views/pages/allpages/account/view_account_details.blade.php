@php
    use Carbon\Carbon;
@endphp

@if ($getAccType == 'COLLECTION')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card shadow">
                <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                    <i class="menu-icon ti ti-device-desktop-cog"></i>View Account Details
                </div>
                <div class="card-body">
                    <br>
                    <table class="table table-sm datatableView">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Collection By</th>
                                <th>Member Name</th>
                                <th>Division</th>
                                <th>Village</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $count = 1; 
                                $runningTotal = 0;
                            @endphp
                            @foreach ($getAccountDetails as $data)

                                {{-- Skip row and skip affecting running total if description matches --}}
                                @if ($data->description === 'Saving from Loan Overpayment')
                                    @continue
                                @endif

                                @php
                                    $formatted = Carbon::parse($data->repaymentDate)->format('Y-m-d');
                                    $member = $getMember->firstWhere('id', $data->memberId);
                                    $user = $getUser->firstWhere('id', $data->collectionBy);
                                    $division = $getDivision->firstWhere('id', optional($member)->divisionId);
                                    $village = $getVillage->firstWhere('id', optional($member)->villageId);

                                    // Calculate running total only for valid entries
                                    if ($data->status == 'Credit') {
                                        $runningTotal += $data->amount;
                                    } else {
                                        $runningTotal -= $data->amount;
                                    }
                                @endphp

                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $formatted }}</td>
                                    <td>{{ $user->name ?? 'N/A' }}</td>
                                    <td>{{ optional($member)->firstName }} {{ optional($member)->lastName }}</td>
                                    <td>{{ optional($division)->divisionName }}</td>
                                    <td>{{ optional($village)->villageName }}</td>
                                    <td>{{ $data->description ?? '-' }}</td>
                                    <td>
                                        @if ($data->status == 'Credit')
                                            <span class="badge bg-success">Credit</span>
                                        @else
                                            <span class="badge bg-danger">Debit</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($data->amount, 2) }}</td>
                                    <td>
                                        <strong class="{{ $runningTotal < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($runningTotal, 2) }}
                                        </strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @elseif ($getAccType == 'BANK')
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-device-desktop-cog"></i>View Account Details
                    </div>
                    <div class="card-body">
                        <br>
                        <table class="table table-sm datatableView">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($getAcctransferHis as $TransHis)
                                    @php
                                        $date = $TransHis->created_at;
                                        $formatted = Carbon::parse($date)->format('Y-m-d');
                                    @endphp

                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>
                                            @if ($TransHis->date == '')
                                                {{ $formatted }}
                                            @else
                                                {{ $TransHis->date }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($TransHis->remarks == 'Opening Balance')
                                                Opening
                                            @elseif (Str::contains($TransHis->remarks, 'Expensive'))
                                                Expensive
                                            @elseif (Str::contains($TransHis->remarks, 'Income'))
                                                Income
                                            @else
                                                @if ($TransHis->fromAccountId == $decId)
                                                    @php
                                                        $accountName = '';
                                                    @endphp
                                                    @foreach ($getAccount as $acc)
                                                        @if ($acc->id == $TransHis->toAccountId)
                                                            @php
                                                                $accountName = $acc->name;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    <a href="#" data-name ="{{ $accountName }}"  data-amount = "{{ number_format($TransHis->transferAmount, 2) }}" data-remarks="{{ $TransHis->remarks }}"
                                                        id="viewTransfer">Transfer</a>
                                                @else
                                                    @php
                                                        $accountName = '';
                                                    @endphp
                                                    @foreach ($getAccount as $acc)
                                                        @if ($acc->id == $TransHis->fromAccountId)
                                                            @php
                                                                $accountName = $acc->name;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    <a href="#" data-name ="{{ $accountName }}" data-amount = "{{ number_format($TransHis->transferAmount, 2) }}" data-remarks="{{ $TransHis->remarks }}"
                                                        id="viewTransfer">Transfer</a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ str_replace(['Expensive', 'Income'], '', $TransHis->remarks) }}</td>
                                        <td>
                                            @if ($TransHis->fromAccountId == $decId)
                                                <span class="badge bg-danger">Debit</span>
                                            @else
                                                <span class="badge bg-success">Credit</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ number_format($TransHis->transferAmount, 2) }}
                                        </td>
                                        <td>
                                            @if ($TransHis->fromAccountId == $decId)
                                                {{ number_format($TransHis->fromAccountBalance, 2) }}
                                            @else
                                                {{ number_format($TransHis->toAccountBalance, 2) }}
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
    @endif

<div class="modal fade" id="viewTransferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-5">
            <div class="modal-body p-5 position-relative bg-white">

                <!-- Close Button -->
                <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                <!-- Modal Title -->
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-primary">💸 View Transfer Details</h2>
                    <p class="text-muted">Review the transaction information carefully.</p>
                </div>

                <!-- Detail Fields -->
                <div class="row g-4">

                    <!-- Transfer Account -->
                    <div class="col-md-12">
                        <div class="card bg-white border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <h6 class="card-title text-secondary fw-semibold mb-2">🏦 Transfer Account</h6>
                                <p id="transferAcc" class="card-text text-dark fs-5 mb-0">--</p>
                            </div>
                        </div>
                    </div>

                    <!-- Transfer Amount -->
                    <div class="col-md-12">
                        <div class="card bg-warning-subtle border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <h6 class="card-title text-secondary fw-semibold mb-2">💰 Transfer Amount</h6>
                                <p id="transferAM" class="card-text text-success fs-4 fw-bold mb-0">--</p>
                            </div>
                        </div>
                    </div>

                    <!-- Transfer Remarks -->
                    <div class="col-md-12">
                        <div class="card bg-primary-subtle border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <h6 class="card-title text-secondary fw-semibold mb-2">📝 Transfer Remarks</h6>
                                <p id="transferRemark" class="card-text text-dark fs-5 mb-0">--</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="text-center mt-5">
                    <button type="button" class="btn btn-outline-primary px-4 py-2 rounded-pill" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

