@php
    use Carbon\Carbon;
@endphp
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                <div class="col-6">
                    <i class="menu-icon ti ti-device-desktop-cog"></i> Manage Collection VS Deposit Reports
                </div>

            </div>
            <div class="card-body">
                <br>
                <a href="{{ route('view_collection_vs_deposit_report') }}" class="mt-3" target="_blank">
                    <button class="btn btn-secondary ">
                        PDF
                    </button>
                </a>

                <table class="table table-sm" id="collectionvsdeposittable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>User</th>
                            <th>Collection Amount</th>
                            <th>Deposit Amount</th>
                            <th>Diffrent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @foreach ($collectionData as $collection)
                            @php
                                $datetime = $collection->created_at;
                                $dateOnly = Carbon::parse($datetime)->format('Y-m-d');
                        
                                // Find user name
                                $userName = '';
                                foreach ($getUser as $user) {
                                    if ($user->id == $collection->depositBy) {
                                        $userName = $user->name;
                                        break;
                                    }
                                }
                        
                                // Calculate total collection amount for this user on this date, excluding "Saving from Loan Overpayment"
                                $totalCollectionAmount = 0;
                                foreach ($accountTransectionHis as $trans) {
                                    if (
                                        $trans->collectionBy == $collection->depositBy &&
                                        Carbon::parse($trans->created_at)->format('Y-m-d') == $dateOnly &&
                                        $trans->description !== 'Saving from Loan Overpayment'
                                    ) {
                                        $totalCollectionAmount += $trans->amount;
                                    }
                                }
                        
                                // If totalCollectionAmount is 0 and deposit is 0, skip this row
                                $depositAmount = $collection->amount ?? 0;
                                if ($totalCollectionAmount == 0 && $depositAmount == 0) continue;
                        
                                $difference = $totalCollectionAmount - $depositAmount;
                            @endphp
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $dateOnly }}</td>
                                <td>{{ $userName }}</td>
                                <td>{{ number_format($totalCollectionAmount, 2) }}</td>
                                <td>{{ number_format($depositAmount, 2) }}</td>
                                <td>{{ number_format($difference, 2) }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 mt-3">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Collection Amount</label>
                                    <p class="total-collection-amount">0</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Total Deposit Amount</label>
                                    <p class="total-deposit-amount">0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
