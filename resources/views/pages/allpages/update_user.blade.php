<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> Update User
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="row">
                                <input type="hidden" class="form-control " id="txtUserId" value="{{$userId}}">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="name" class="form-label fw-bold">Full Name</label>
                                        <input type="text" class="form-control" id="txtFullName"
                                            value="{{ $userData->fullName }}" placeholder="Enter your Full name"
                                            autofocus />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="name" class="form-label fw-bold">User Name</label>
                                        <input type="text" class="form-control" id="userName" name="name"
                                            value="{{ $userData->name }}" placeholder="Enter your user name"
                                            autofocus />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="email" class="form-label fw-bold">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            value="{{ $userData->email }}" placeholder="Enter your user Email"
                                            autofocus />
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="name" class="form-label fw-bold">NIC</label>
                                        <input type="text" class="form-control" id="txtNic"
                                            value="{{ $userData->nic }}" placeholder="Enter your NIC" autofocus />
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="name" class="form-label fw-bold">Phone Number</label>
                                        <input type="number" class="form-control" id="txtPhoneNumber"
                                            value="{{ $userData->phoneNumber }}" placeholder="Enter your Phone Number"
                                            autofocus />
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="name" class="form-label fw-bold">Date Of Birth</label>
                                        <input type="date" class="form-control" id="txtDOB"
                                            value="{{ $userData->DOB }}" placeholder="Enter your DOB" autofocus />
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="name" class="form-label fw-bold">Professional</label>
                                        <select class="selectize" id="txtProfessional">
                                            @foreach ($getProfessional as $pro)
                                                @if ($userData->professional == $pro->id)
                                                    <option value="{{ $pro->id }}" selected>{{ $pro->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="name" class="form-label fw-bold">EPF No</label>
                                        <input type="number" class="form-control" id="txtEpfNo"
                                            value="{{ $userData->epfNo }}" placeholder="Enter your EPF" autofocus />
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-6">
                                        <label for="name" class="form-label fw-bold">Gender</label>
                                        <input type="text" class="form-control" id="txtGender"
                                            value="{{ $userData->gender }}" placeholder="Enter your Gender"
                                            autofocus />
                                    </div>
                                </div>


                                <div class="col-sm-12 col-md-6">
                                    <label for="userType" class="form-label fw-bold">Select User Role</label>
                                    <select name="userType" id="userType" class="selectize">
                                        @foreach ($getUserRole as $users)
                                            @if ($userData->userType == $users->roleName)
                                                <option value="{{ $users->roleName }}" selected>{{ $users->roleName }}
                                                </option>
                                            @else
                                                <option value="{{ $users->roleName }}">{{ $users->roleName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                            </div>


                            <div class="col mt-3 d-flex justify-content-end">
                                <button class="btn btn-primary" id="btnUpdateUser">Update
                                    Users</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
