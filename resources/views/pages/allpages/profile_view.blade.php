<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="user-profile-header-banner">
                        <img src="../../assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top" />
                    </div>
                    <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                            <img src="../uploads/{{ $userData->profileImage }}?v={{ $user->updated_at->timestamp ?? time() }} alt="user image"
                                class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" />
                        </div>
                        <div class="flex-grow-1 mt-3 mt-lg-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4 class="mb-2 mt-lg-6">
                                        @if ($userData->fullName == '')
                                        {{ $userData->name }}
                                        @else
                                        {{ $userData->fullName }}
                                        @endif
                                    </h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">
                                        <li class="list-inline-item d-flex gap-2 align-items-center">
                                            <i class="ti ti-calendar ti-lg"></i><span class="fw-medium"> Joined
                                                {{ \Carbon\Carbon::parse($userData->created_at)->format('d F Y') }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-primary mb-1"
                                    data-bs-toggle="modal" data-bs-target="#uploadProfileModal">
                                    <i class="ti ti-user-check ti-xs me-2"></i>Upload Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Header -->

        <!-- Navbar pills -->
        <div class="row">
            <div class="col-md-12">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-sm-row mb-6 gap-2 gap-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#updateProfileDataModal"><i
                                    class="ti-sm ti ti-user-check me-1_5"></i>Update Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#changePasswordModal"><i
                                    class="ti ti-lock me-2"></i> Change Password</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Navbar pills -->

        <!-- User Profile Content -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <!-- About User -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <small class="card-text text-uppercase text-muted small">About</small>
                                <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Full Name:</span>
                                        <span>
                                            @if ($userData->fullName == '')
                                            {{ $userData->name }}
                                            @else
                                            {{ $userData->fullName }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-calendar-month ti-lg"></i><span class="fw-medium mx-2">DOB:</span>
                                        <span>{{$userData->DOB}}</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-man ti-lg"></i><span class="fw-medium mx-2">Gender:</span>
                                        <span>{{$userData->gender}}</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-crown ti-lg"></i><span class="fw-medium mx-2">Role:</span>
                                        <span>{{$userData->userType}}</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-2">
                                        <i class="ti ti-certificate ti-lg"></i><span
                                            class="fw-medium mx-2">NIC:</span>
                                        <span>{{$userData->nic}}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <small class="card-text text-uppercase text-muted small">Contacts</small>
                                <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-phone-call ti-lg"></i><span
                                            class="fw-medium mx-2">Contact:</span>
                                        <span>{{$userData->phoneNumber}}</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-mail ti-lg"></i><span class="fw-medium mx-2">Email:</span>
                                        <span>{{$userData->email}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <!--/ About User -->
            </div>

        </div>

        <!--/Profile Image Upload -->
        <div class="modal fade" id="uploadProfileModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-simple">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="text-center mb-6">
                            <h4 class="mb-2">Upload Profile</h4>
                            <p>Profile</p>
                        </div>
                        <input type="text" class="form-control" id="txtUserId" name="txtUserId"
                            value="{{ $userData->id ?? '' }}" hidden />
                        <div class="col-12 mb-4">
                            <label class="form-label">Choose Profile</label>
                            <input type="file" class="form-control" id="txtUploadProfile" name="txtUploadProfile"
                                accept="image/*" />
                        </div>

                        <div class="col-12 text-center demo-vertical-spacing">
                            <button class="btn btn-primary me-4" id="btnUploadProfile">Update</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                Discard
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /Profile Data Update -->
        <div class="modal fade" id="updateProfileDataModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-simple">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-6">
                            <h4 class="mb-2">Update Profile</h4>
                            <p>Update your personal info</p>
                        </div>

                        <input type="hidden" class="form-control" id="txtUpdateUserId" name="txtUpdateUserId"
                            value="{{ $userData->id ?? '' }}" />

                        <div class="col-12 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control text-start" id="txtFullname" name="txtFullname"
                                value="@if ($userData->fullName == '')
                                            {{ $userData->name }}
                                            @else
                                            {{ $userData->fullName }}
                                            @endif" />
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">DOB</label>
                            <input type="date"
                                class="form-control @error('dateOfBirth') is-invalid @enderror"
                                id="dateOfBirth" name="dateOfBirth"
                                value="{{ $userData->DOB ?? old('dateOfBirth') }}" />
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Gender</label>
                            <select id="gender" name="gender" class="form-control">
                                <option value="Male" {{ (isset($userData->gender) && $userData->gender === 'Male') ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ (isset($userData->gender) && $userData->gender === 'Female') ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="number"
                                class="form-control @error('phoneNumber') is-invalid @enderror"
                                id="txtPhoneNumber" name="txtPhoneNumber"
                                value="{{ $userData->phoneNumber ?? old('phoneNumber') }}"
                                placeholder="Enter your user phone number" />
                        </div>

                        <div class="col-12 text-center demo-vertical-spacing">
                            <button class="btn btn-primary me-4" id="btnUpdateProfileData">Update</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                                Discard
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- /Change Password Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-simple">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h4 class="mb-2">Change Password</h4>
                            <p>Update your account password</p>
                        </div>

                        <input type="hidden" id="changePasswordUserId" value="{{ auth()->user()->id }}" />

                        <div class="col-12 mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" placeholder="Current Password" />
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" placeholder="New Password" />
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" />
                        </div>

                        <div class="col-12 text-center">
                            <button class="btn btn-primary me-2" id="btnChangePassword">Update</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal">Discard</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ User Profile Content -->
    </div>
</div>