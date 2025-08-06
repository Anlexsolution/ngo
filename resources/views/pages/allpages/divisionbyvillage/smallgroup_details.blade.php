<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <input type="hidden" class="form-control" id="smallGroupId" value="{{ $smallGroupId }}">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <!-- About User -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#smallgroupDetailsModal"><i class="ti ti-edit"></i> Update Small Group
                                    Details</button>
                            </div>
                            <div class="col-6">
                                <small class="card-text text-uppercase text-muted small">Small Group Details</small>
                                <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Division Name:</span>
                                        <span>
                                           {{$getDivisionName}}
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Village Name :</span>
                                        <span>
                                          {{$getVillageName}}
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i>
                                        <span class="fw-medium mx-2">Group Leader:</span>
                                        <span>
                                            @if ($getSmallgroupFinalData != null)
                                            @foreach ($getAllMemberData as $get)
                                                @if ($get->id == $getSmallgroupFinalData->groupLeader)
                                                {{ $get->firstName }}  {{ $get->lastName }}
                                                @endif
                                            @endforeach
                                        @else
                                            {{ '-' }}
                                        @endif
                                        </span>
                                    </li>

                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i>
                                        <span class="fw-medium mx-2">Secretary:</span>
                                        <span>
                                            @if ($getSmallgroupFinalData != null)
                                            @foreach ($getAllMemberData as $get)
                                                @if ($get->id == $getSmallgroupFinalData->secretary)
                                                {{ $get->firstName }}  {{ $get->lastName }}
                                                @endif
                                            @endforeach
                                        @else
                                            {{ '-' }}
                                        @endif
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <!--/ About User -->
            </div>
            <div class="col-xl-12 mt-3 col-lg-12 col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-sm datatableView">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Member Name</th>
                                    <th>Address</th>
                                    <th>NIC</th>
                                    <th>Phone Number</th>
                                    <th>New Account Number</th>
                                    <th>Old Account Number</th>
                                    <th>Profession</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($memberData as $member)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        @php
                                            $encryptedId = encrypt($member->id);
                                        @endphp
                                        <td><a href="{{ route('view_member', $encryptedId) }}">{{ $member->firstName }} </a></td>
                                        <td>{{ $member->address }}</td>
                                        <td>{{ $member->nicNumber }}</td>
                                        <td>{{ $member->phoneNumber }}</td>
                                        <td>{{ $member->newAccountNumber }}</td>
                                        <td>{{ $member->oldAccountNumber }}</td>
                                        <td>{{ $member->profession }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!--/ Division Details Modal -->
<div class="modal fade" id="smallgroupDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Update Smallgroup</h4>
                    <p>Update the Smallgroup details</p>
                </div>
                <div class="row">
                    <div class="col-6 mb-4">
                        <label class="form-label" for="modalProfessionName">Group Leader</label> <span
                            class=" text-danger">*</span>
                        <select class="selectize" id="txtGroupLeader">
                            <option value="">---Select---</option>
                            @foreach ($memberData as $user)
                                @if ($getSmallgroupFinalData != null)
                                    @if ($getSmallgroupFinalData->groupLeader == $user->id)
                                        <option value="{{ $user->id }}" selected>{{ $user->firstName }}</option>
                                    @else
                                        <option value="{{ $user->id }}">{{ $user->firstName }}</option>
                                    @endif
                                @else
                                    <option value="{{ $user->id }}">{{ $user->firstName }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-4">
                        <label class="form-label" for="modalProfessionName">Secretary</label> <span
                            class=" text-danger">*</span>
                        <select class="selectize" id="txtSecretary">
                            <option value="">---Select---</option>
                            @foreach ($memberData as $user)
                                @if ($getSmallgroupFinalData != null)
                                    @if ($getSmallgroupFinalData->secretary == $user->id)
                                        <option value="{{ $user->id }}" selected>{{ $user->firstName }}</option>
                                    @else
                                        <option value="{{ $user->id }}">{{ $user->firstName }}</option>
                                    @endif
                                @else
                                    <option value="{{ $user->id }}">{{ $user->firstName }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                </div>


                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnUpdateSmallgroupDetails">Update smallgroup
                        Details</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Division Details Modal -->
