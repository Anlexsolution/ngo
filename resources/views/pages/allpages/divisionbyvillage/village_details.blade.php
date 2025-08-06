<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <input type="hidden" class="form-control" id="villageId" value="{{ $villageId }}">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <!-- About User -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#villageDetailsModal"><i class="ti ti-edit"></i> Update Village
                                    Details</button>
                            </div>



                            <div class="col-6">
                                <small class="card-text text-uppercase text-muted small">Village Details</small>
                                <ul class="list-unstyled my-3 py-1">

                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Village Name :</span>
                                        <span>
                                          {{$getVillageData->villageName}}
                                        </span>
                                    </li>


                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Village Leader:</span>
                                        <span>
                                            @if ($getVillageFinalData != null)
                                                @foreach ($getAllMemberData as $get)
                                                    @if ($get->id == $getVillageFinalData->villageLeader)
                                                        {{ $get->firstName }}  {{ $get->lastName }}
                                                    @endif
                                                @endforeach
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Secretary :</span>
                                        <span>
                                            @if ($getVillageFinalData != null)
                                                @foreach ($getAllMemberData as $get)
                                                    @if ($get->id == $getVillageFinalData->secretary)
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
                                        <span class="fw-medium mx-2">Staff:</span>
                                        <span>
                                            @if ($getVillageFinalData != null)
                                                @php
                                                    $staffArray = json_decode($getVillageFinalData->staff, true);
                                                @endphp
                                                @if (is_array($staffArray) && count($staffArray) > 0)
                                                    @php
                                                        $staffNames = [];
                                                    @endphp
                                                    @foreach ($getAllMemberData as $get)
                                                        @if (in_array($get->id, $staffArray))
                                                            @php
                                                                $staffNames[] = $get->firstName;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    {{ implode(', ', $staffNames) }}
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </span>
                                    </li>



                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">FO Name:</span>
                                        <span>
                                            @if ($getVillageFinalData != null)
                                                @foreach ($getUsers as $get)
                                                    @if ($get->id == $getVillageFinalData->foName)
                                                        {{ $get->name }}
                                                    @endif
                                                @endforeach
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </span>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-6">
                                <small class="card-text text-uppercase text-muted small">Contacts</small>
                                <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-phone-call ti-lg"></i><span class="fw-medium mx-2">Phone
                                            Number:</span>
                                        <span>
                                            @if ($getVillageFinalData != null)
                                                {{ $getVillageFinalData->phone }}
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
<div class="modal fade" id="villageDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Update Village</h4>
                    <p>Update the village details</p>
                </div>
                <div class="row">
                    <div class="col-6 mb-4">
                        <label class="form-label" for="modalProfessionName">Village Leader</label> <span
                            class=" text-danger">*</span>
                        <select class="selectize" id="txtVillageLeader">
                            <option value="">---Select---</option>
                            @foreach ($memberData as $user)
                                @if ($getVillageFinalData != null)
                                    @if ($getVillageFinalData->villageLeader == $user->id)
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
                                @if ($getVillageFinalData != null)
                                    @if ($getVillageFinalData->secretary == $user->id)
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
                        <label class="form-label" for="modalProfessionName">Staff</label>
                        <span class="text-danger">*</span>
                        <select class="selectize" id="txtStaff" multiple>
                            <option value="">---Select---</option>
                            @php
                                $selectStaff = $getVillageFinalData
                                    ? json_decode($getVillageFinalData->staff, true)
                                    : [];
                            @endphp
                            @foreach ($memberData as $user)
                                    <option value="{{ $user->id }}"
                                        @if (is_array($selectStaff) && in_array($user->id, $selectStaff)) selected @endif>
                                        {{ $user->firstName }}
                                    </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 mb-4">
                        <label class="form-label" for="modalProfessionName">FO Name</label> <span
                            class=" text-danger">*</span>
                        <select class="selectize" id="txtFoName">
                            <option value="">---Select---</option>
                            @foreach ($userDetails as $user)
                                @if ($getVillageFinalData != null)
                                    @if ($getVillageFinalData->foName == $user->id)
                                        <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                    @else
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @else
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mb-4">
                        <label class="form-label" for="modalProfessionName">Phone Number</label> <span
                            class=" text-danger">*</span>
                        <input type="text" class="form-control" id="txtPhoneNumber"
                            value="@if ($getVillageFinalData != null) {{ $getVillageFinalData->phone }}@else{{ '' }} @endif">
                    </div>
                </div>


                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnUpdateVillageDetails">Update Village
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
