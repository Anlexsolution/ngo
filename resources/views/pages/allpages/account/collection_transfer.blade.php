<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                <i class="menu-icon ti ti-device-desktop-cog"></i> Collection Transfer
            </div>
            <div class="card-body">
                <table class="table table-striped" id="collectionTransferTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Deposit By</th>
                            <th>Amount</th>
                            <th>Slip No</th>
                            <th>Approved By</th>
                            <th>Approved Date</th>
                            <th>Bank</th>
                            <td>Status</td>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($getCollectionTransferData as $data)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    @foreach ($getUser as $user)
                                        @if ($user->id == $data->depositBy)
                                            {{ $user->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ number_format($data->amount, 2) }}</td>
                                <td>{{ $data->slipNo }}</td>
                                <td>
                                    @foreach ($getUser as $user)
                                        @if ($user->id == $data->approveBy)
                                            {{ $user->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if ($data->approveDate != null)
                                        {{ \Carbon\Carbon::parse($data->approveDate)->format('Y-m-d') }}
                                    @endif
                                </td>
                                <td>
                                    @foreach ($getAccountData as $accdata)
                                        @if ($accdata->id == $data->bank)
                                            {{ $accdata->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if ($data->status == 'Pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-success">Approved</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($data->status == 'Pending')
                                        <button class="btn btn-primary btn-sm btnApproveModal"
                                            data-id="{{ $data->id }}">Approve</button>
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


<!-- Import Death History Modal -->
<div class="modal fade" id="collectionTransferApproveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h4 class="mb-2">Collection Transfer Approve</h4>
                    <p>Collection Transfer function</p>
                </div>
                <input type="text" id="txtCollectionTransferId" hidden>
                <!-- File Input -->
                <div class="col-12 mb-4">
                    <label class="form-label">Choose Bank</label>
                    <select class="selectize" id="txtBank">
                        @foreach ($getAccountData as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCollectionApprove">Collection Approve</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Import Death History Modal -->
