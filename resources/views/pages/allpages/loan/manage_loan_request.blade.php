<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-list"></i> Manage Loan Request
                        </div>
                        <div class="col-6 d-flex justify-content-end">

                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addLoanRequestModal"><i class="menu-icon ti ti-circle-plus"></i>
                                Create Request</button>

                        </div>
                    </div>
                    <div class="card-body ">
                        <br>
                        <table class="table table-sm datatableView ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Id</th>
                                    <th>Member Name</th>
                                    <th>Division</th>
                                    <th>Village</th>
                                    <th>SmallGroup</th>
                                    <th>Loan Amount</th>
                                    <th>User Type</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($getLoanRequetData as $data)
                                    @php
                                        $decId = Crypt::encrypt($data->id);
                                    @endphp
                                    @if (auth()->user()->userType == 'superAdmin')
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>
                                                @if ($data->uniqueId == null)
                                                    -
                                                @else
                                                    <a
                                                        href="{{ route('view_request', $decId) }}">{{ $data->uniqueId }}</a>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($getAllMemberData as $getMem)
                                                    @if ($getMem->id == $data->memberId)
                                                        {{ $getMem->firstName }} {{ $getMem->lastName }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getAllMemberData as $getMem)
                                                    @if ($getMem->id == $data->memberId)
                                                        @php
                                                            $divIdEnc = Crypt::encrypt($getMem->divisionId);
                                                        @endphp
                                                        <a href="{{ route('division_details', $divIdEnc) }}">
                                                            {{ $getMem->division->divisionName }} </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getAllMemberData as $getMem)
                                                    @if ($getMem->id == $data->memberId)
                                                        @php
                                                            $villageIdEnc = Crypt::encrypt($getMem->villageId);
                                                        @endphp
                                                        <a href="{{ route('village_details', $villageIdEnc) }}">
                                                            {{ $getMem->village->villageName }} </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getAllMemberData as $getMem)
                                                    @if ($getMem->id == $data->memberId)
                                                        @php
                                                            $smallgroupIdEnc = Crypt::encrypt($getMem->smallGroupId);
                                                        @endphp
                                                        <a href="{{ route('smallgroup_details', $smallgroupIdEnc) }}">
                                                            {{ $getMem->smallgroup->smallGroupName }} </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ number_format($data->loanAmount, 2) }}</td>
                                            <td>
                                                @foreach ($getUserRole as $user)
                                                    @if ($user->id == $data->userTypeId)
                                                        {{ $user->roleName }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($data->status == 1)
                                                    <span class="badge bg-primary">Request</span>
                                                @elseif ($data->status == 2)
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif ($data->status == 3)
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning">Loan Created</span>
                                                @endif
                                            </td>
                                            @if ($data->status == 2)
                                                <td>
                                                    <a href="{{ route('create_loan_request', $decId) }}">
                                                        <button class="btn btn-success btn-sm">Create Loan</button>
                                                    </a>
                                                </td>
                                            @else
                                                <td>
                                                    -
                                                </td>
                                            @endif
                                            {{-- <td>
                                            <div class="dropdown">
                                                <button type="button"
                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="#"><i
                                                            class="ti ti-eye me-1"></i> View</a>
                                                    <a class="dropdown-item"
                                                        href="#"><i
                                                            class="ti ti-pencil me-1"></i> Edit</a>
                                                </div>
                                            </div>
                                        </td> --}}
                                        </tr>
                                    @else
                                        @php
                                            $divArray = auth()->user()->division;
                                            $vilArray = auth()->user()->village;
                                        @endphp
                                        @if ($divArray != '' || $divArray != null || $vilArray != '' || $vilArray != null)
                                            @foreach ($getAllMemberData as $getMem)
                                                @if ($getMem->id == $data->memberId)
                                                    @if (in_array($getMem->divisionId, json_decode(auth()->user()->division)) &&
                                                            in_array($getMem->villageId, json_decode(auth()->user()->village)))
                                                        <tr>
                                                            <td>{{ $count++ }}</td>
                                                            <td>
                                                                @if ($data->uniqueId == null)
                                                                    -
                                                                @else
                                                                    <a
                                                                        href="{{ route('view_request', $decId) }}">{{ $data->uniqueId }}</a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @foreach ($getAllMemberData as $getMem)
                                                                    @if ($getMem->id == $data->memberId)
                                                                        {{ $getMem->firstName }}
                                                                        {{ $getMem->lastName }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach ($getAllMemberData as $getMem)
                                                                    @if ($getMem->id == $data->memberId)
                                                                        @php
                                                                            $divIdEnc = Crypt::encrypt(
                                                                                $getMem->divisionId,
                                                                            );
                                                                        @endphp
                                                                        <a
                                                                            href="{{ route('division_details', $divIdEnc) }}">
                                                                            {{ $getMem->division->divisionName }} </a>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach ($getAllMemberData as $getMem)
                                                                    @if ($getMem->id == $data->memberId)
                                                                        @php
                                                                            $villageIdEnc = Crypt::encrypt(
                                                                                $getMem->villageId,
                                                                            );
                                                                        @endphp
                                                                        <a
                                                                            href="{{ route('village_details', $villageIdEnc) }}">
                                                                            {{ $getMem->village->villageName }} </a>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach ($getAllMemberData as $getMem)
                                                                    @if ($getMem->id == $data->memberId)
                                                                        @php
                                                                            $smallgroupIdEnc = Crypt::encrypt(
                                                                                $getMem->smallGroupId,
                                                                            );
                                                                        @endphp
                                                                        <a
                                                                            href="{{ route('smallgroup_details', $smallgroupIdEnc) }}">
                                                                            {{ $getMem->smallgroup->smallGroupName }}
                                                                        </a>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ number_format($data->loanAmount, 2) }}</td>
                                                            <td>
                                                                @foreach ($getUserRole as $user)
                                                                    @if ($user->id == $data->userTypeId)
                                                                        {{ $user->roleName }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @if ($data->status == 1)
                                                                    <span class="badge bg-primary">Request</span>
                                                                @elseif ($data->status == 2)
                                                                    <span class="badge bg-success">Approved</span>
                                                                @elseif ($data->status == 3)
                                                                    <span class="badge bg-danger">Rejected</span>
                                                                @else
                                                                    <span class="badge bg-warning">Loan Created</span>
                                                                @endif
                                                            </td>
                                                            @if ($data->status == 2)
                                                                <td>
                                                                    <a
                                                                        href="{{ route('create_loan_request', $decId) }}">
                                                                        <button class="btn btn-success btn-sm">Create
                                                                            Loan</button>
                                                                    </a>
                                                                </td>
                                                            @else
                                                                <td>
                                                                    -
                                                                </td>
                                                            @endif
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

<!-- Add Permission Modal -->
<div class="modal fade" id="addLoanRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add New Loan Request</h4>
                    <p>Create a new loan request</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">Member</label>
                    <select class="selectize" id="txtMember">
                        <option value="">---Select---</option>
                        @foreach ($getAllMemberData as $member)
                            @if (auth()->user()->userType == 'superAdmin')
                                <option value="{{ $member->id }}">{{ $member->firstName }}</option>
                            @else
                                @php
                                    $divArray = auth()->user()->division;
                                    $vilArray = auth()->user()->village;
                                @endphp
                                @if ($divArray != '' || $divArray != null || $vilArray != '' || $vilArray != null)
                                    @if (in_array($member->divisionId, json_decode(auth()->user()->division)) &&
                                            in_array($member->villageId, json_decode(auth()->user()->village)))
                                             <option value="{{ $member->id }}">{{ $member->firstName }}</option>
                                    @endif
                                @endif
                            @endif

                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">Loan Amount</label>
                    <input type="text" class="form-control" id="txtLoanAmount">
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">Main Category</label>
                    <select class="selectize" id="txtMainCategory">
                        <option value="">---Select---</option>
                        @foreach ($getAllMainPurpose as $main)
                            <option value="{{ $main->id }}">{{ $main->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">Sub Category</label>
                    <select id="txtSubCategory">
                        <option value="">---Select---</option>
                    </select>
                </div>

                <div class="col-12 mb-4">
                    <label>Loan Documents</label>
                    <div id="viewDocuments"></div>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">User Type</label>
                    <select class="selectize" id="txUserType">
                        <option value="">---Select---</option>
                        @foreach ($getUserRole as $userRole)
                            <option value="{{ $userRole->id }}">{{ $userRole->roleName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateLoanRequest">Create loan request</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->
