<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> Create User
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="name" class="form-label fw-bold">Full Name</label>
                                            <input type="text" class="form-control" id="txtFullName"
                                                placeholder="Enter your Full name" autofocus />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="name" class="form-label fw-bold">User Name</label>
                                            <input type="text" class="form-control" id="userName" name="name"
                                                placeholder="Enter your user name" autofocus />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="email" class="form-label fw-bold">Email</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                placeholder="Enter your user Email" autofocus />
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="name" class="form-label fw-bold">NIC</label>
                                            <input type="text" class="form-control" id="txtNic"
                                                placeholder="Enter your NIC" autofocus />
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="name" class="form-label fw-bold">Phone Number</label>
                                            <input type="number" class="form-control" id="txtPhoneNumber"
                                                placeholder="Enter your Phone Number" autofocus />
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="name" class="form-label fw-bold">Date Of Birth</label>
                                            <input type="date" class="form-control" id="txtDOB"
                                                placeholder="Enter your DOB" autofocus />
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="name" class="form-label fw-bold">Professional</label>
                                            <select class="selectize" id="txtProfessional">
                                                @foreach ($getProfessional as $pro)
                                                    <option value="{{$pro->id}}">{{$pro->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="name" class="form-label fw-bold">EPF No</label>
                                            <input type="number" class="form-control" id="txtEpfNo"
                                                placeholder="Enter your EPF" autofocus />
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="name" class="form-label fw-bold">Gender</label>
                                            <select class="selectize" id="txtGender">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                           
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6 form-password-toggle">
                                            <label class="form-label" for="password">Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" class="form-control"
                                                    name="password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="ti ti-eye-off"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6 form-password-toggle">
                                            <label class="form-label" for="password_confirmation">Confirm
                                                Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="confirmPassword" class="form-control"
                                                    name="confirm-password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="confirmPassword" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="ti ti-eye-off"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <label for="userType" class="form-label fw-bold">Select User Role</label>
                                        <select name="userType" id="userType" class="selectize">
                                            @foreach ($getUserRole as $users)
                                                <option value="{{ $users->roleName }}">{{ $users->roleName }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>


                                <div class="col mt-3 d-flex justify-content-end">
                                    <button class="btn btn-primary" id="btnCreateUser">Create
                                        Users</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
