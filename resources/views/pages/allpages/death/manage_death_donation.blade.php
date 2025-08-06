<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-device-desktop-cog"></i> Manage Death Donation
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end mt-3">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addDonationModal">Create</button>
                            </div>
                            <div class="col-12 mt-3">
                                <table class="table table-striped" id="deathDonationTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Donation Id</th>
                                            <th>Member Name</th>
                                            <th>Name</th>
                                            <th>Relative</th>
                                            <th>Remark</th>
                                            <th>Account</th>
                                            <th>Cheq No</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 1;
                                        @endphp
                                        @foreach ($getDonationData as $data)
                                            @php
                                                $encId = Crypt::encrypt($data->id);
                                            @endphp
                                            @if (auth()->user()->userType == 'superAdmin')
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td><a href="{{ route('view_death_donation_history', $encId) }}">
                                                            {{ $data->donationId }}
                                                        </a></td>
                                                    <td>
                                                        @foreach ($getAllMemberData as $mem)
                                                            @if ($mem->id == $data->memberId)
                                                                {{ $mem->firstName }} {{ $mem->lastName }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>
                                                        @foreach ($getrelative as $rel)
                                                            @if ($rel->id == $data->relativeId)
                                                                {{ $rel->name }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $data->remarks }}</td>
                                                    <td>
                                                        @if ($data->account == null)
                                                            -
                                                        @else
                                                            @foreach ($getAllAccount as $acc)
                                                                @if ($acc->id == $data->account)
                                                                    {{ $acc->name }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->cheqNo }}</td>
                                                    <td>
                                                        @if ($data->status == 1)
                                                            <span class="badge bg-primary">Requested</span>
                                                        @elseif ($data->status == 2)
                                                            <span class="badge bg-primary">Recommand</span>
                                                        @elseif ($data->status == 3)
                                                            <span class="badge bg-primary">Approved</span>
                                                        @elseif ($data->status == 4)
                                                            <span class="badge bg-success">Distributed</span>
                                                        @elseif ($data->status == 5)
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @else
                                                @php
                                                    $divArray = auth()->user()->division;
                                                    $vilArray = auth()->user()->village;
                                                @endphp
                                                @if ($divArray != '' || $divArray != null || $vilArray != '' || $vilArray != null)
                                                    @foreach ($getAllMemberData as $mem)
                                                        @if ($mem->id == $data->memberId)
                                                            @if (in_array($mem->divisionId, json_decode(auth()->user()->division)) &&
                                                                    in_array($mem->villageId, json_decode(auth()->user()->village)))
                                                                <tr>
                                                                    <td>{{ $count++ }}</td>
                                                                    <td><a
                                                                            href="{{ route('view_death_donation_history', $encId) }}">
                                                                            {{ $data->donationId }}
                                                                        </a></td>
                                                                    <td>
                                                                        @foreach ($getAllMemberData as $mem)
                                                                            @if ($mem->id == $data->memberId)
                                                                                {{ $mem->firstName }}
                                                                                {{ $mem->lastName }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td>{{ $data->name }}</td>
                                                                    <td>
                                                                        @foreach ($getrelative as $rel)
                                                                            @if ($rel->id == $data->relativeId)
                                                                                {{ $rel->name }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td>{{ $data->remarks }}</td>
                                                                    <td>
                                                                        @if ($data->account == null)
                                                                            -
                                                                        @else
                                                                            @foreach ($getAllAccount as $acc)
                                                                                @if ($acc->id == $data->account)
                                                                                    {{ $acc->name }}
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $data->cheqNo }}</td>
                                                                    <td>
                                                                        @if ($data->status == 1)
                                                                            <span
                                                                                class="badge bg-primary">Requested</span>
                                                                        @elseif ($data->status == 2)
                                                                            <span
                                                                                class="badge bg-primary">Recommand</span>
                                                                        @elseif ($data->status == 3)
                                                                            <span
                                                                                class="badge bg-primary">Approved</span>
                                                                        @elseif ($data->status == 4)
                                                                            <span
                                                                                class="badge bg-success">Distributed</span>
                                                                        @elseif ($data->status == 5)
                                                                            <span
                                                                                class="badge bg-danger">Rejected</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add Donation Modal -->
<div class="modal fade" id="addDonationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add New Donation</h4>
                    <p>Create a member Donation</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label">Member</label>
                    <select class="selectize" id="txtMember">
                        <option value="">---Select Member---</option>
                        @foreach ($getAllMemberData as $member)
                            <option value="{{ $member->id }}">{{ $member->firstName }} {{ $member->lastName }}
                                ({{ $member->nicNumber }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Relative</label>
                    <select class="selectize" id="txtRelative">
                        <option value="">---Select Relative---</option>
                        @foreach ($getrelative as $relative)
                            <option value="{{ $relative->id }}">{{ $relative->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" id="txtName" placeholder="Enter Name">
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control" id="txtRemarks"></textarea>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">User Type</label>
                    <select class="selectize" id="txtUserType">
                        <option value="">---Select User Type---</option>
                        @foreach ($getUserRole as $userRole)
                            <option value="{{ $userRole->roleName }}">{{ $userRole->roleName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateDonation">Create Donation</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add Donation Modal -->
