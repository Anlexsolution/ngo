@php
    $randomNumber = rand(1, 999999999);
    $formattedNumber = str_pad($randomNumber, 9, '0', STR_PAD_LEFT);
@endphp
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> Create Member
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <form id="usersForm" action="/createmembers" method="POST" enctype="multipart/form-data">
                                @csrf

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
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="title" class="form-label fw-bold">Title</label>
                                            <select id="title" name="title" class="form-control">
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Dr">Dr</option>
                                                <option value="Ms">Ms</option>
                                                <option value="Miss">Miss</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="firstName" class="form-label fw-bold">First Name</label>
                                            <input type="text"
                                                class="form-control @if ($errors->has('firstName')) {{ 'is-invalid' }} @endif"
                                                id="firstName" name="firstName" placeholder="Enter your first name"
                                                value="{{ old('firstName') }}" autofocus />
                                            @if ($errors->has('firstName'))
                                                <div class="invalid-feedback">{{ $errors->first('firstName') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="lastName" class="form-label fw-bold">Last Name</label>
                                            <input type="text"
                                                class="form-control @if ($errors->has('lastName')) {{ 'is-invalid' }} @endif "
                                                id="lastName" name="lastName" value="{{ old('lastName') }}"
                                                placeholder="Enter your last name" autofocus />
                                            @if ($errors->has('lastName'))
                                                <div class="invalid-feedback">{{ $errors->first('lastName') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="dateOfBirth" class="form-label fw-bold">DOB</label>
                                            <input type="date"
                                                class="form-control @if ($errors->has('dateOfBirth')) {{ 'is-invalid' }} @endif"
                                                id="dateOfBirth" name="dateOfBirth" placeholder="Enter your dob"
                                                value="{{ old('dateOfBirth') }}" autofocus />
                                            @if ($errors->has('dateOfBirth'))
                                                <div class="invalid-feedback">{{ $errors->first('dateOfBirth') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="address" class="form-label fw-bold">Address</label>
                                            <input type="text"
                                                class="form-control @if ($errors->has('address')) {{ 'is-invalid' }} @endif"
                                                id="address" name="address" placeholder="Enter your address"
                                                value="{{ old('address') }}" autofocus />
                                            @if ($errors->has('address'))
                                                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="nicNumber" class="form-label fw-bold">NIC Number</label>
                                            <input type="text"
                                                class="form-control @if ($errors->has('nicNumber')) {{ 'is-invalid' }} @endif"
                                                id="nicNumber" name="nicNumber" placeholder="Enter your user nic number"
                                                value="{{ old('nicNumber') }}" autofocus />
                                            @if ($errors->has('nicNumber'))
                                                <div class="invalid-feedback">{{ $errors->first('nicNumber') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="nicIssueDate" class="form-label fw-bold">NIC Issue Date</label>
                                            <input type="date"
                                                class="form-control @if ($errors->has('nicIssueDate')) {{ 'is-invalid' }} @endif"
                                                id="nicIssueDate" name="nicIssueDate"
                                                placeholder="Enter your user nic number"
                                                value="{{ old('nicIssueDate') }}" autofocus />
                                            @if ($errors->has('nicIssueDate'))
                                                <div class="invalid-feedback">{{ $errors->first('nicIssueDate') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="newAccountNumber" class="form-label fw-bold">New Account
                                                Number</label>
                                            <input type="text"
                                                class="form-control @if ($errors->has('newAccountNumber')) {{ 'is-invalid' }} @endif"
                                                id="newAccountNumber" name="newAccountNumber"
                                                placeholder="Enter your new account number"
                                                value="{{ old('newAccountNumber', $formattedNumber) }}" autofocus
                                                readonly />
                                            @if ($errors->has('newAccountNumber'))
                                                <div class="invalid-feedback">{{ $errors->first('newAccountNumber') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="oldAccountNumber" class="form-label fw-bold">Old Account
                                                Number</label>
                                            <input type="number"
                                                class="form-control @if ($errors->has('oldAccountNumber')) {{ 'is-invalid' }} @endif"
                                                id="oldAccountNumber" name="oldAccountNumber"
                                                placeholder="Enter your user old account number"
                                                value="{{ old('oldAccountNumber') }}" autofocus />
                                            @if ($errors->has('oldAccountNumber'))
                                                <div class="invalid-feedback">{{ $errors->first('oldAccountNumber') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="profession" class="form-label fw-bold">Profession</label>
                                            <select id="profession" name="profession"
                                                class="form-control @if ($errors->has('profession')) {{ 'is-invalid' }} @endif">
                                                <option value="">Select profession</option>
                                                @foreach ($managePro as $pro)
                                                    <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('profession'))
                                                <div class="invalid-feedback">{{ $errors->first('profession') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="subprofession" class="form-label fw-bold">Sub
                                                Profession</label>
                                            <select id="subprofession" class="form-control" name="subprofession">
                                                <option value="">Select Sub Profession</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="gender" class="form-label fw-bold">Gender</label>
                                            <select id="gender" name="gender" class="form-control ">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="maritalStatus" class="form-label fw-bold">Marital
                                                Status</label>
                                            <select id="maritalStatus" name="maritalStatus" class="form-control">
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Divorced">Divorced</option>
                                                <option value="Widowed">Widowed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="phoneNumber" class="form-label fw-bold">Phone Number</label>
                                            <input type="number"
                                                class="form-control  @if ($errors->has('phoneNumber')) {{ 'is-invalid' }} @endif"
                                                id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber') }}"
                                                placeholder="Enter your user phone number" autofocus />
                                            @if ($errors->has('phoneNumber'))
                                                <div class="invalid-feedback">{{ $errors->first('phoneNumber') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="profiePhoto" class="form-label fw-bold">Photo</label>
                                            <input type="file"
                                                class="form-control  @if ($errors->has('profiePhoto')) {{ 'is-invalid' }} @endif"
                                                id="profiePhoto" name="profiePhoto" placeholder="select your photo"
                                                value="{{ old('profiePhoto') }}" accept=".jpg,.png" autofocus />
                                            @if ($errors->has('profiePhoto'))
                                                <div class="invalid-feedback">{{ $errors->first('profiePhoto') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="signature" class="form-label fw-bold">Signature</label>
                                            <input type="file"
                                                class="form-control  @if ($errors->has('signature')) {{ 'is-invalid' }} @endif"
                                                id="signature" name="signature" placeholder="select your signature"
                                                value="{{ old('signature') }}" accept=".jpg,.png" autofocus />
                                            @if ($errors->has('signature'))
                                                <div class="invalid-feedback">{{ $errors->first('signature') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <h4 class="d-flex justify-content-center">Division By Village</h4>
                                    <div class="col-sm-12 col-md-6">
                                        <label for="divisionId" class="form-label fw-bold">Select Division</label>
                                        <select name="divisionId" id="divisionId"
                                            class="form-control @if ($errors->has('divisionId')) {{ 'is-invalid' }} @endif">
                                            <option value="">Select Division</option>
                                            @foreach ($getDivision as $division)
                                                <option value="{{ $division->id }}">{{ $division->divisionName }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('divisionId'))
                                            <div class="invalid-feedback">{{ $errors->first('divisionId') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label for="villageId" class="form-label fw-bold">Select Village</label>
                                        <select name="villageId" id="villageId" class="form-control">
                                            <option value="">Select Village</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt-3">
                                        <label for="smallGroup" class="form-label fw-bold">Small Group</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="smallGroup"
                                                id="smallGroupYes" value="Yes">
                                            <label class="form-check-label" for="smallGroupYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="smallGroup"
                                                id="smallGroupNo" value="No" checked>
                                            <label class="form-check-label" for="smallGroupNo">No</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt-3" id="selectSmallGroupDiv"
                                        style="display: none;">
                                        <label for="smallGroupId" class="form-label fw-bold">Select Small
                                            Group</label>
                                        <select name="smallGroupId" id="smallGroupId" class="form-control">
                                            <option value="">Select Small Group</option>
                                        </select>
                                    </div>
                                    <hr>
                                    <h4 class="d-flex justify-content-center">Division By GN</h4>
                                    <div class="col-sm-12 col-md-5">
                                        <label for="gnDivisionId" class="form-label fw-bold">GN Division</label>
                                        <select name="gnDivisionId" id="gnDivisionId" class="form-control">
                                            <option value="">Select GN Division</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-2 mt-3">
                                        <label for="smallGroup" class="form-label fw-bold">Small Group</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="smallGroupGN"
                                                id="smallGroupYesGN" value="Yes">
                                            <label class="form-check-label" for="smallGroupYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="smallGroupGN"
                                                id="smallGroupNoGN" value="No" checked>
                                            <label class="form-check-label" for="smallGroupNo">No</label>
                                        </div>
                                    </div>

                                       <div class="col-sm-12 col-md-5 mt-3" id="selectSmallGroupDivGN"
                                        style="display: none;">
                                        <label for="smallGroupId" class="form-label fw-bold">Select Small
                                            Group</label>
                                        <select name="smallGroupIdGN" id="smallGroupIdGN" class="form-control">
                                            <option value="">Select Small Group</option>
                                        </select>
                                    </div>

                                </div>
                                <h4>A Follower</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="followerName" class="form-label fw-bold">Name</label>
                                            <input type="text"
                                                class="form-control @if ($errors->has('followerName')) {{ 'is-invalid' }} @endif"
                                                id="followerName" name="followerName" placeholder="enter your name"
                                                value="{{ old('followerName') }}" autofocus />
                                            @if ($errors->has('followerName'))
                                                <div class="invalid-feedback">{{ $errors->first('followerName') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="followerAddress" class="form-label fw-bold">Address</label>
                                            <input type="text"
                                                class="form-control @if ($errors->has('followerAddress')) {{ 'is-invalid' }} @endif"
                                                id="followerAddress" name="followerAddress"
                                                placeholder="enter your address" value="{{ old('followerAddress') }}"
                                                autofocus />
                                            @if ($errors->has('followerAddress'))
                                                <div class="invalid-feedback">{{ $errors->first('followerAddress') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="followerNicNumber" class="form-label fw-bold">NIC
                                                Number</label>
                                            <input type="text"
                                                class="form-control @if ($errors->has('followerNicNumber')) {{ 'is-invalid' }} @endif"
                                                id="followerNicNumber" name="followerNicNumber"
                                                placeholder="enter your nic number"
                                                value="{{ old('followerNicNumber') }}" autofocus />
                                            @if ($errors->has('followerNicNumber'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('followerNicNumber') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="followerIssueDate" class="form-label fw-bold">Issue
                                                Date</label>
                                            <input type="date" class="form-control " id="followerIssueDate"
                                                name="followerIssueDate" placeholder="enter your nic number"
                                                value="{{ old('followerIssueDate') }}" autofocus />
                                        </div>
                                    </div>
                                </div>

                                <div class="col mt-3 d-flex justify-content-end">
                                    <button class="btn btn-primary" type="submit" value="createmembers">Create
                                        Member</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('divisionId').addEventListener('change', function() {
        var divisionId = this.value;

        if (divisionId) {
            fetch(`/get-villages/${divisionId}`)
                .then(response => response.json())
                .then(data => {
                    var villageSelect = document.getElementById('villageId');
                    villageSelect.innerHTML = '<option value="">Select Village</option>';

                    data.forEach(function(village) {
                        var option = document.createElement('option');
                        option.value = village.id;
                        option.text = village.villageName;
                        villageSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching villages:', error));

            fetch(`/get-gndivision/${divisionId}`)
                .then(response => response.json())
                .then(data => {
                    var villageSelect = document.getElementById('gnDivisionId');
                    villageSelect.innerHTML = '<option value="">Select Gn Division</option>';

                    data.forEach(function(gnDivision) {
                        var option = document.createElement('option');
                        option.value = gnDivision.id;
                        option.text = gnDivision.gnDivisionName;
                        villageSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching gnDivisionName:', error));
        } else {
            document.getElementById('villageId').innerHTML = '<option value="">Select Village</option>';
        }
    });

    document.getElementById('villageId').addEventListener('change', function() {
        var villageId = this.value;
        const divisionId = document.getElementById('divisionId');
        var divisionIdValue = divisionId.value;
        console.log(divisionIdValue);
        console.log(villageId);
        if (villageId) {
            fetch(`/get-smallgroup/${villageId}/${divisionIdValue}`)
                .then(response => response.json())
                .then(data => {
                    var villageSelect = document.getElementById('smallGroupId');
                    villageSelect.innerHTML = '<option value="">Select Small Group</option>';

                    data.forEach(function(smallGroup) {
                        var option = document.createElement('option');
                        option.value = smallGroup.id;
                        option.text = smallGroup.smallGroupName;
                        villageSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching villages:', error));
        } else {
            document.getElementById('smallGroupId').innerHTML = '<option value="">Select Small Group</option>';
        }
    });

        document.getElementById('gnDivisionId').addEventListener('change', function() {
        var villageId = this.value;
        const divisionId = document.getElementById('divisionId');
        var divisionIdValue = divisionId.value;
        console.log(divisionIdValue);
        console.log(villageId);
        if (villageId) {
            fetch(`/get-smallgroup-gn/${villageId}/${divisionIdValue}`)
                .then(response => response.json())
                .then(data => {
                    var villageSelect = document.getElementById('smallGroupIdGN');
                    villageSelect.innerHTML = '<option value="">Select Small Group</option>';

                    data.forEach(function(smallGroup) {
                        var option = document.createElement('option');
                        option.value = smallGroup.id;
                        option.text = smallGroup.smallGroupName;
                        villageSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching group:', error));
        } else {
            document.getElementById('smallGroupIdGN').innerHTML = '<option value="">Select Small Group</option>';
        }
    });

    document.getElementById('profession').addEventListener('change', function() {
        var professionId = this.value;
        if (professionId) {
            fetch(`/get-sub-profession/${professionId}`)
                .then(response => response.json())
                .then(data => {
                    var villageSelect = document.getElementById('subprofession');
                    villageSelect.innerHTML = '<option value="">Select sub profession</option>';

                    data.forEach(function(smallGroup) {
                        var option = document.createElement('option');
                        option.value = smallGroup.id;
                        option.text = smallGroup.name;
                        villageSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching sub profession:', error));
        } else {
            document.getElementById('subprofession').innerHTML =
                '<option value="">Select sub profession</option>';
        }
    });


    document.addEventListener('DOMContentLoaded', function() {
        const radioButtons = document.querySelectorAll('input[name="smallGroup"]');
        const selectSmallGroupDiv = document.getElementById('selectSmallGroupDiv');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedValue = document.querySelector('input[name="smallGroup"]:checked')
                    .value;
                if (selectedValue == 'Yes') {
                    selectSmallGroupDiv.style.display = 'block';
                } else {
                    selectSmallGroupDiv.style.display = 'none';
                }
            });
        });
    });

        document.addEventListener('DOMContentLoaded', function() {
        const radioButtons = document.querySelectorAll('input[name="smallGroupGN"]');
        const selectSmallGroupDiv = document.getElementById('selectSmallGroupDivGN');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedValue = document.querySelector('input[name="smallGroupGN"]:checked')
                    .value;
                if (selectedValue == 'Yes') {
                    selectSmallGroupDiv.style.display = 'block';
                } else {
                    selectSmallGroupDiv.style.display = 'none';
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const gnDivRadio = document.querySelectorAll('input[name="gnDiv"]');
        gnDivRadio.forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedValue = document.querySelector('input[name="gnDiv"]:checked')
                    .value;
                if (selectedValue == 'Yes') {
                    const divisionId = document.getElementById('divisionId');
                    var divisionIdValue = divisionId.value;
                    console.log(divisionIdValue);
                    if (divisionIdValue) {
                        fetch(`/get-smallgroup-by-gn/${divisionIdValue}`)
                            .then(response => response.json())
                            .then(data => {
                                var villageSelect = document.getElementById('smallGroupId');
                                villageSelect.innerHTML =
                                    '<option value="">Select Small Group</option>';

                                data.forEach(function(allSmallGroups) {
                                    var option = document.createElement('option');
                                    option.value = allSmallGroups.id;
                                    option.text = allSmallGroups.smallGroupName;
                                    villageSelect.appendChild(option);
                                });
                            })
                            .catch(error => console.error('Error fetching villages:', error));
                    } else {
                        document.getElementById('smallGroupId').innerHTML =
                            '<option value="">Select Small Group</option>';
                    }
                } else {
                    var villageId = document.getElementById('villageId');
                    const divisionId = document.getElementById('divisionId');
                    var divisionIdValue = divisionId.value;
                    var villageId = villageId.value;
                    console.log(divisionIdValue);
                    console.log(villageId);
                    if (villageId) {
                        fetch(`/get-smallgroup/${villageId}/${divisionIdValue}`)
                            .then(response => response.json())
                            .then(data => {
                                var villageSelect = document.getElementById('smallGroupId');
                                villageSelect.innerHTML =
                                    '<option value="">Select Small Group</option>';

                                data.forEach(function(smallGroup) {
                                    var option = document.createElement('option');
                                    option.value = smallGroup.id;
                                    option.text = smallGroup.smallGroupName;
                                    villageSelect.appendChild(option);
                                });
                            })
                            .catch(error => console.error('Error fetching villages:', error));
                    } else {
                        document.getElementById('smallGroupId').innerHTML =
                            '<option value="">Select Small Group</option>';
                    }
                }
            });
        });
    });
</script>
