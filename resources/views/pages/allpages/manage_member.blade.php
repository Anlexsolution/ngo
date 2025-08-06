<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i> Manage Member
                        </div>
                        @if ($userType == 'superAdmin')
                            <div class="col-6 d-flex justify-content-end">
                                <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#importMemberModal"><i
                                        class="menu-icon ti ti-square-rounded-plus"></i> Import Member</button>
                                <a href="/create_member">
                                    <button class="btn btn-success btn-sm"><i
                                            class="menu-icon ti ti-square-rounded-plus"></i> Create Member</button>
                                </a>
                            </div>
                        @else
                            @php
                                $userRolesArray = $getUserRole->pluck('roleName')->toArray();
                            @endphp
                            @if (in_array($userType, $userRolesArray))
                                @php
                                    $usersDataPer = $permissions;
                                    $usersDataPer = json_decode($usersDataPer, true);
                                @endphp

                                <div class="col-6 d-flex justify-content-end">
                                    @if (in_array('importMember', $usersDataPer))
                                        <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                            data-bs-target="#importMemberModal"><i
                                                class="menu-icon ti ti-square-rounded-plus"></i> Import Member</button>
                                    @endif
                                    @if (in_array('addMember', $usersDataPer))
                                        <a href="/create_member">
                                            <button class="btn btn-success btn-sm"><i
                                                    class="menu-icon ti ti-square-rounded-plus"></i> Create
                                                Member</button>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endif

                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <form method="GET" action="{{ route('filter_members_by_village') }}"
                                class="d-flex justify-content-between w-100">
                                <div class="col-md-3 me-2">
                                    <div class="form-group">
                                        <label for="divisionId" class="form-label fw-bold">Select Division</label>
                                        <select name="divisionId" id="divisionId" class="form-control"
                                            onchange="this.form.submit()">
                                            <option value="">Select Division</option>
                                            @foreach ($getDivision as $division)
                                                <option value="{{ $division->id }}"
                                                    {{ request('divisionId') == $division->id ? 'selected' : '' }}>
                                                    {{ $division->divisionName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 me-2">
                                    <div class="form-group">
                                        <label for="villageId" class="form-label fw-bold">Select Village</label>
                                        <select name="villageId" id="villageId" class="form-control"
                                            onchange="this.form.submit()">
                                            <option value="">Select Village</option>
                                            @foreach ($villages as $village)
                                                <option value="{{ $village->id }}"
                                                    {{ request('villageId') == $village->id ? 'selected' : '' }}>
                                                    {{ $village->villageName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 me-2">
                                    <div class="form-group">
                                        <label for="professionName" class="form-label fw-bold">Select Profession</label>
                                        <select name="professionName" id="professionName" class="form-control"
                                            onchange="this.form.submit()">
                                            <option value="">Select Profession</option>
                                            @foreach ($getProfession as $profession)
                                                <option value="{{ $profession->name }}"
                                                    {{ request('professionName') == $profession->name ? 'selected' : '' }}>
                                                    {{ $profession->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 me-2" id="selectSmallGroupDiv" style="display: none;">
                                    <div class="form-group">
                                        <label for="smallGroupId" class="form-label fw-bold">Select Small Group</label>
                                        <select name="smallGroupId" id="smallGroupId" class="form-control"
                                            onchange="this.form.submit()">
                                            <option value="">Select Small Group</option>
                                            @foreach ($smallGroups as $smallGroup)
                                                <option value="{{ $smallGroup->id }}"
                                                    {{ request('smallGroupId') == $smallGroup->id ? 'selected' : '' }}>
                                                    {{ $smallGroup->smallGroupName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </form>
                        </div>



                        <div class="row mt-3">
                            <table class="table table-sm " id="memberTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>NIC number</th>
                                        <th>Division</th>
                                        <th>Village</th>
                                        <th>Small Group</th>
                                        <th>Profession</th>
                                        <th>Old Account Number</th>
                                        <th>Status Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (session('success'))
                                        <div class="mt-3 alert alert-success success-alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="mt-3 alert alert-danger danger-alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            $encryptedId = encrypt($member->id);
                                        @endphp
                                        @if (auth()->user()->userType == 'superAdmin')
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td> <a href="{{ route('view_member', $encryptedId) }}">
                                                        {{ $member->firstName }}</a></td>
                                                <td>{{ $member->nicNumber }}</td>
                                                <td>
                                                    @if ($member->divisionId == '')
                                                        -
                                                    @else
                                                    @php
                                                        $divIdEnc = Crypt::encrypt($member->divisionId);
                                                    @endphp
                                                      <a href="{{route('division_details', $divIdEnc)}}">  {{ $member->division->divisionName }} </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($member->villageId == '')
                                                        -
                                                    @else
                                                    @php
                                                        $villageIdEnc = Crypt::encrypt($member->villageId);
                                                    @endphp
                                                        <a href="{{route('village_details', $villageIdEnc)}}"> {{ $member->village->villageName }} </a>
                                                    @endif
                                                </td>
                                                @if ($member->smallGroupId == '')
                                                    <td>-</td>
                                                @else
                                                @php
                                                    $smallgroupIdEnc = Crypt::encrypt($member->smallGroupId);
                                                @endphp
                                                    <td>
                                                        <a href="{{route('smallgroup_details', $smallgroupIdEnc)}}">{{ $member->smallgroup->smallGroupName }} </a></td>
                                                @endif
                                                <td>
                                                    @foreach ($getProfession as $pro)
                                                        @if ($pro->id == $member->profession)
                                                            {{ $pro->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $member->oldAccountNumber }}</td>
                                                <td>{{ $member->statusType }}</td>
                                                <td>
                                                    @if ($member->status == 1)
                                                        <span class="badge bg-label-success">Active</span>
                                                    @else
                                                        <span class="badge bg-label-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button"
                                                            class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"
                                                                href="{{ route('view_member', $encryptedId) }}"><i
                                                                    class="ti ti-eye me-1"></i> View</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('update_member', $encryptedId) }}"><i
                                                                    class="ti ti-pencil me-1"></i> Edit</a>
                                                            <a class="dropdown-item btnshowStatusModal"
                                                                data-id="{{ $member->id }}" href="#"><i
                                                                    class="ti ti-edit me-1"></i> Change Status</a>

                                                            {{-- <form id="deleteForm"
                                                                action="{{ route('delete_member', $member->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="dropdown-item text-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#confirmModal">
                                                                    <i class="ti ti-trash me-1"></i> Delete
                                                                </button>
                                                            </form> --}}

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            @php
                                                $divArray = auth()->user()->division;
                                                $vilArray = auth()->user()->village;
                                            @endphp
                                            @if ($divArray != '' || $divArray != null || $vilArray != '' || $vilArray != null)
                                                @if (in_array($member->divisionId, json_decode(auth()->user()->division)) &&
                                                        in_array($member->villageId, json_decode(auth()->user()->village)))
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>
                                                            @if ($userType != 'superAdmin')
                                                                @if (in_array('viewMember', $usersDataPer))
                                                                    <a href="{{ route('view_member', $encryptedId) }}">
                                                                        {{ $member->firstName }}</a>
                                                                @else
                                                                    {{ $member->firstName }}
                                                                @endif
                                                            @else
                                                                <a href="{{ route('view_member', $encryptedId) }}">
                                                                    {{ $member->firstName }}</a>
                                                            @endif
                                                        </td>
                                                        <td>{{ $member->nicNumber }}</td>
                                                        <td>{{ empty($member->division->divisionName) ? 'N/A' : $member->division->divisionName }}
                                                        </td>
                                                        <td>{{ empty($member->village->villageName) ? 'N/A' : $member->village->villageName }}
                                                        </td>
                                                        @if ($member->smallGroupId == '')
                                                            <td>-</td>
                                                        @else
                                                            <td>{{ $member->smallgroup->smallGroupName }}</td>
                                                        @endif
                                                        <td>{{ $member->profession }}</td>
                                                        <td>{{ $member->oldAccountNumber }}</td>
                                                        <td>{{ $member->uniqueId }}</td>
                                                        <td>{{ $member->statusType }}</td>
                                                        <td>
                                                            @if ($member->status == 1)
                                                                <span class="badge bg-label-success">Active</span>
                                                            @else
                                                                <span class="badge bg-label-danger">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    @if ($userType != 'superAdmin')
                                                                        @if (in_array('viewMember', $usersDataPer))
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('view_member', $encryptedId) }}"><i
                                                                                    class="ti ti-eye me-1"></i>
                                                                                View</a>
                                                                        @endif
                                                                    @else
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('view_member', $encryptedId) }}"><i
                                                                                class="ti ti-eye me-1"></i> View</a>
                                                                    @endif

                                                                    @if ($userType != 'superAdmin')
                                                                        @if (in_array('ManageMemberEdit', $usersDataPer))
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('update_member', $encryptedId) }}"><i
                                                                                    class="ti ti-pencil me-1"></i>
                                                                                Edit</a>
                                                                        @endif
                                                                    @else
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('update_member', $encryptedId) }}"><i
                                                                                class="ti ti-pencil me-1"></i> Edit</a>
                                                                    @endif

                                                                    <a class="dropdown-item btnshowStatusModal"
                                                                        href="#"
                                                                        data-id="{{ $member->id }}"><i
                                                                            class="ti ti-eye me-1"></i> Change
                                                                        Status</a>

                                                                    {{-- @if ($userType != 'superAdmin')
                                                                        @if (in_array('ManageMemberDelete', $usersDataPer))
                                                                            <form id="deleteForm"
                                                                                action="{{ route('delete_member', $member->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="button"
                                                                                    class="dropdown-item text-danger"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#confirmModal">
                                                                                    <i class="ti ti-trash me-1"></i>
                                                                                    Delete
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    @else
                                                                        <form id="deleteForm"
                                                                            action="{{ route('delete_member', $member->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                class="dropdown-item text-danger"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#confirmModal">
                                                                                <i class="ti ti-trash me-1"></i> Delete
                                                                            </button>
                                                                        </form>
                                                                    @endif --}}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
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


<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this member?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var divisionId = document.getElementById('divisionId');
        var villageId = document.getElementById('villageId');
        var smallGroupDiv = document.getElementById('selectSmallGroupDiv');

        function toggleSmallGroupDropdown() {
            if (divisionId.value || villageId.value) {
                smallGroupDiv.style.display = 'block';
            } else {
                smallGroupDiv.style.display = 'none';
            }
        }

        toggleSmallGroupDropdown();

        divisionId.addEventListener('change', toggleSmallGroupDropdown);
        villageId.addEventListener('change', toggleSmallGroupDropdown);
    });
</script>


<!-- Import member Modal -->
<div class="modal fade" id="importMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h4 class="mb-2">Import Member</h4>
                    <p>Member import function</p>
                </div>

                <!-- Sample Excel Download -->
                <div class="col-12 mb-3 text-center">
                    <a href="{{ asset('excelimportfile/member.xlsx') }}" class="btn btn-outline-info" download>
                        Download Sample Excel
                    </a>
                </div>

                <!-- File Input -->
                <div class="col-12 mb-4">
                    <label class="form-label" for="txtImportFile">Choose Excel file</label>
                    <input type="file" id="txtImportFile" class="form-control" accept=".xlsx, .xls, .csv" />
                </div>

                <!-- Action Buttons -->
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnImportMember">Import Member</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Import member Modal -->


<!-- Change Status  Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h4 class="mb-2">Change Status</h4>
                    <p>Change Status function</p>
                </div>

                <input type="text" id="txtMemberId" hidden>

                <div class="col-12 mb-4">
                    <label class="form-label">Status</label>
                    <select class="selectize" id="txtStatus">
                        <option value="">---Select---</option>
                        <option value="1">Active</option>
                        <option value="0">In Active</option>
                    </select>
                </div>

                <div class="col-12 mb-4" hidden id="txtStatusTypeDiv">
                    <label class="form-label">Status Type</label>
                    <select class="selectize" id="txtStatusType">
                        <option value="Loan Member">Loan Member</option>
                        <option value="Saving Member">Saving Member</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnChangeStatusMember">Change Status Member</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Change Status Modal -->
