<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <input type="hidden" class="form-control" id="divisionId" value="{{ $divisionId }}">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <!-- About User -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#divisionDetailsModal"><i class="ti ti-edit"></i> Update Division
                                    Details</button>
                            </div>
                            <div class="col-6">
                                <small class="card-text text-uppercase text-muted small">Division Details</small>
                                <ul class="list-unstyled my-3 py-1">
                                      <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">
                                            Division Name:</span>
                                        <span>
                                            {{$getDeviData->divisionName}}
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Division
                                            Head:</span>
                                        <span>
                                            @if ($getDivisionFinalData != null)
                                                @foreach ($getUsers as $get)
                                                    @if ($get->id == $getDivisionFinalData->divisionHead)
                                                        {{ $get->name }}
                                                    @endif
                                                @endforeach
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">DM Name:</span>
                                        <span>
                                            @if ($getDivisionFinalData != null)
                                                @foreach ($getUsers as $get)
                                                    @if ($get->id == $getDivisionFinalData->dmName)
                                                        {{ $get->name }}
                                                    @endif
                                                @endforeach
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i>
                                        <span class="fw-medium mx-2">FO Name:</span>
                                        <span>
                                            @if ($getDivisionFinalData != null)
                                                @php
                                                    $foNameArray = json_decode($getDivisionFinalData->foName, true);
                                                @endphp
                                                @if (is_array($foNameArray) && count($foNameArray) > 0)
                                                    @php
                                                        $foNames = [];
                                                    @endphp
                                                    @foreach ($getUsers as $get)
                                                        @if (in_array($get->id, $foNameArray))
                                                            @php
                                                                $foNames[] = $get->name;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    {{ implode(', ', $foNames) }}
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </span>
                                    </li>



                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">RC Name:</span>
                                        <span>
                                            @if ($getDivisionFinalData != null)
                                                @foreach ($getUsers as $get)
                                                    @if ($get->id == $getDivisionFinalData->rcName)
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
                                        <i class="ti ti-address-book ti-lg"></i><span
                                            class="fw-medium mx-2">Address:</span>
                                        <span>
                                            @if ($getDivisionFinalData != null)
                                                {{ $getDivisionFinalData->address }}
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-phone-call ti-lg"></i><span class="fw-medium mx-2">Phone
                                            Number:</span>
                                        <span>
                                            @if ($getDivisionFinalData != null)
                                                {{ $getDivisionFinalData->phone }}
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
                                    <th>Old Account Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($memberData as $member)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        @php
                                            $encryptedId = encrypt($member->id);
                                        @endphp
                                        <td><a href="{{ route('view_member', $encryptedId) }}">{{ $member->firstName }} </a></td>
                                        <td>{{$member->address}}</td>
                                        <td>{{$member->nicNumber}}</td>
                                        <td>{{$member->phoneNumber}}</td>
                                        <td>{{$member->oldAccountNumber}}</td>
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
<div class="modal fade" id="divisionDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Update Division</h4>
                    <p>Update the division details</p>
                </div>
                <div class="row">
                    <div class="col-6 mb-4">
                        <label class="form-label" for="modalProfessionName">Division Head</label> <span
                            class=" text-danger">*</span>
                        <select class="selectize" id="txtDivisionHead">
                            <option value="">---Select---</option>
                            @foreach ($userDetails as $user)
                                @if ($getDivisionFinalData != null)
                                    @if ($getDivisionFinalData->divisionHead == $user->id)
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
                    <div class="col-6 mb-4">
                        <label class="form-label" for="modalProfessionName">DM Name</label> <span
                            class=" text-danger">*</span>
                        <select class="selectize" id="txtDMName">
                            <option value="">---Select---</option>
                            @foreach ($userDetails as $user)
                                @if ($getDivisionFinalData != null)
                                    @if ($getDivisionFinalData->dmName == $user->id)
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
                    <div class="col-6 mb-4">
                        <label class="form-label" for="modalProfessionName">FO Name</label>
                        <span class="text-danger">*</span>
                        <select class="selectize" id="txtFoName" multiple>
                            <option value="">---Select---</option>
                            @php
                                $selectedFoNames = $getDivisionFinalData
                                    ? json_decode($getDivisionFinalData->foName, true)
                                    : [];
                            @endphp
                            @foreach ($userDetails as $user)
                                @if ($user->userType == 'Field Officer')
                                    <option value="{{ $user->id }}"
                                        @if (is_array($selectedFoNames) && in_array($user->id, $selectedFoNames)) selected @endif>
                                        {{ $user->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 mb-4">
                        <label class="form-label" for="modalProfessionName">RC Name</label> <span
                            class=" text-danger">*</span>
                        <select class="selectize" id="txtRCName">
                            <option value="">---Select---</option>
                            @foreach ($userDetails as $user)
                                @if ($getDivisionFinalData != null)
                                    @if ($getDivisionFinalData->rcName == $user->id)
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
                            value="@if ($getDivisionFinalData != null) {{ $getDivisionFinalData->phone }}@else{{ '' }} @endif">
                    </div>
                    <div class="col-12 mb-4">
                        <label class="form-label" for="modalProfessionName">Address</label> <span
                            class=" text-danger">*</span>
                        <textarea class="form-control" id="txtAddress">
@if ($getDivisionFinalData != null)
{{ $getDivisionFinalData->address }}@else{{ '' }}
@endif
</textarea>
                    </div>
                </div>


                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnUpdateDivisionDetails">Update Division
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
