<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow border border-primary">
                    <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                        <div>
                            <i class="menu-icon ti ti-users-group me-2"></i>
                            <strong class="text-uppercase">View Meeting</strong>
                        </div>
                        <span class="badge bg-light text-primary border border-primary fs-6 px-3 py-2 shadow-sm">
                            #{{ $meetingData->id ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="card-body px-4 py-4">
                        <!-- Section: Meeting Info -->
                        <h5 class="text-primary fw-bold border-bottom pb-2 mb-4">Meeting Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Meeting Title:</label>
                                <p class="form-control-plaintext border p-2 bg-light rounded">
                                    {{ $meetingData->meeting_title }}
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Meeting Type:</label>
                                <p class="form-control-plaintext border p-2 bg-light rounded">
                                    {{ $meetingData->meeting_type ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Date:</label>
                                <p class="form-control-plaintext border p-2 bg-light rounded">
                                    {{ \Carbon\Carbon::parse($meetingData->meeting_date)->format('d M Y') }}
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Time:</label>
                                <p class="form-control-plaintext border p-2 bg-light rounded">
                                    {{ \Carbon\Carbon::parse($meetingData->meeting_time)->format('h:i A') }}
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Resource Person:</label>
                                <p class="form-control-plaintext border p-2 bg-light rounded">
                                    {{ $meetingData->resource_person }}
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Resource Position:</label>
                                <p class="form-control-plaintext border p-2 bg-light rounded">
                                    {{ $meetingData->resource_position }}
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Resource Contact No:</label>
                                <p class="form-control-plaintext border p-2 bg-light rounded">
                                    {{ $meetingData->resource_contact_no }}
                                </p>
                            </div>
                        </div>

                        <!-- Section: Member Attendance Table -->
                        <hr class="mt-4 mb-4">
                        <h5 class="text-primary fw-bold border-bottom pb-2 mb-3">Member Attendance</h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>NIC</th>
                                        <th>Old Account Number</th>
                                        <th>Present / Absent</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach ($memRecord as $rec)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $rec['fullName'] }}</td>
                                            <td>{{ $rec['nicNumber'] }}</td>
                                            <td>{{ $rec['oldAccNo'] }}</td>
                                            <td>
                                                @if ($rec['absent'] == 0)
                                                    <span class="badge bg-danger px-3 py-2">Absent</span>
                                                @else
                                                    <span class="badge bg-success px-3 py-2">Present</span>
                                                @endif
                                            </td>
                                            <td>{{ $rec['remarks'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- .table-responsive -->
                    </div> <!-- .card-body -->
                </div> <!-- .card -->
            </div> <!-- .col -->
        </div> <!-- .row -->
    </div> <!-- .container -->
</div> <!-- .content-wrapper -->
