<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i> Member Saving Report
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Month Filter Dropdown --}}
                        <div class="row mb-3 mt-3">
                            <div class="col-md-4">
                                <label>Month Filter</label>
                                <select id="monthFilter" class="selectizeFilter">
                                    <option value="">-- Filter by Month --</option>
                                    @php
                                        $months = [];
                                        foreach ($getData as $d) {
                                            $month = \Carbon\Carbon::parse($d->created_at)->format('Y-m');
                                            $months[$month] = \Carbon\Carbon::parse($d->created_at)->format('F Y');
                                        }
                                    @endphp
                                    @foreach (collect($months)->sortKeysDesc() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                        {{-- Data Table --}}
                        <table id="savingReportTable" class="table table-sm mt-3">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Saving Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach ($getData as $data)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $data->created_at }}</td>
                                        <td>{{ $data->amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-end">Total:</th>
                                    <th id="totalAmountFooter">0.00</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
