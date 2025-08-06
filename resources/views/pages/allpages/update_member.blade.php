<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> Update Member
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <form  action="/updatemembersdata" method="POST" enctype="multipart/form-data">
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
                                    <input type="hidden" name="memberId" class="form-control hidden" id="memberId" value="{{ $member->id }}">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="title" class="form-label fw-bold">Title</label>
                                            <select id="title" name="title" class="form-control">
                                                <option value="Mr"
                                                    @if ($member->title == 'Mr') {{ 'selected' }} @endif>Mr
                                                </option>
                                                <option value="Mrs"
                                                    @if ($member->title == 'Mrs') {{ 'selected' }} @endif>Mrs
                                                </option>
                                                <option value="Dr"
                                                    @if ($member->title == 'Dr') {{ 'selected' }} @endif>Dr
                                                </option>
                                                <option value="Ms"
                                                    @if ($member->title == 'Ms') {{ 'selected' }} @endif>Ms
                                                </option>
                                                <option value="Miss"
                                                    @if ($member->title == 'Miss') {{ 'selected' }} @endif>Miss
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="firstName" class="form-label fw-bold">First Name</label>
                                            <input type="text"
                                                class="form-control @if ($errors->has('firstName')) {{ 'is-invalid' }} @endif"
                                                id="firstName" name="firstName" placeholder="Enter your first name"
                                                value="{{ old('firstName', $member->firstName) }}" autofocus />
                                            @if ($errors->has('firstName'))
                                                <div class="invalid-feedback">{{ $errors->first('firstName') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="lastName" class="form-label fw-bold">Last Name</label>
                                            <input type="text" class="form-control " id="lastName" name="lastName"
                                                value="{{ old('lastName', $member->lastName) }}"
                                                placeholder="Enter your last name" autofocus />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="dateOfBirth" class="form-label fw-bold">DOB</label>
                                            <input type="date"
                                                class="form-control @if ($errors->has('dateOfBirth')) {{ 'is-invalid' }} @endif"
                                                id="dateOfBirth" name="dateOfBirth" placeholder="Enter your dob"
                                                value="{{ old('dateOfBirth', $member->dateOfBirth) }}" autofocus />
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
                                                value="{{ old('address', $member->address) }}" autofocus />
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
                                                value="{{ old('nicNumber', $member->nicNumber) }}" autofocus />
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
                                                value="{{ old('nicIssueDate', $member->nicIssueDate) }}" autofocus />
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
                                                value="{{ old('newAccountNumber', $member->newAccountNumber) }}"
                                                autofocus readonly />
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
                                            <input type="number" class="form-control" id="oldAccountNumber"
                                                name="oldAccountNumber"
                                                placeholder="Enter your user old account number"
                                                value="{{ old('oldAccountNumber', $member->oldAccountNumber) }}"
                                                autofocus />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="profession" class="form-label fw-bold">Profession</label>
                                            <input type="text" class="form-control" id="profession"
                                                name="profession" placeholder="Profession"
                                                value="{{ old('profession', $member->profession) }}" autofocus />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="gender" class="form-label fw-bold">Gender</label>
                                            <select id="gender" name="gender" class="form-control ">
                                                <option value="Male"
                                                    @if ($member->gender == 'Male') {{ 'selected' }} @endif>Male
                                                </option>
                                                <option value="Female"
                                                    @if ($member->gender == 'Female') {{ 'selected' }} @endif>
                                                    Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="maritalStatus" class="form-label fw-bold">Marital
                                                Status</label>
                                            <select id="maritalStatus" name="maritalStatus" class="form-control">
                                                <option value="Single"
                                                    @if ($member->maritalStatus == 'Single') {{ 'selected' }} @endif>
                                                    Single</option>
                                                <option value="Married"
                                                    @if ($member->maritalStatus == 'Married') {{ 'selected' }} @endif>
                                                    Married</option>
                                                <option value="Divorced"
                                                    @if ($member->maritalStatus == 'Divorced') {{ 'selected' }} @endif>
                                                    Divorced</option>
                                                <option value="Widowed"
                                                    @if ($member->maritalStatus == 'Widowed') {{ 'selected' }} @endif>
                                                    Widowed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="phoneNumber" class="form-label fw-bold">Phone Number</label>
                                            <input type="number"
                                                class="form-control  @if ($errors->has('phoneNumber')) {{ 'is-invalid' }} @endif"
                                                id="phoneNumber" name="phoneNumber"
                                                value="{{ old('phoneNumber', $member->phoneNumber) }}"
                                                placeholder="Enter your user phone number" autofocus />
                                            @if ($errors->has('phoneNumber'))
                                                <div class="invalid-feedback">{{ $errors->first('phoneNumber') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <label for="divisionId" class="form-label fw-bold">Select Division</label>
                                        <select name="divisionId" id="divisionId" class="form-control">
                                            <option value="">Select Division</option>
                                            @foreach ($getDivision as $division)
                                                @if ($member->divisionId == $division->id)
                                                    <option value="{{ $division->id }}" selected>
                                                        {{ $division->divisionName }}
                                                    </option>
                                                @else
                                                    <option value="{{ $division->id }}">{{ $division->divisionName }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
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
                                                id="smallGroupYes" value="Yes" @if ($member->smallGroupStatus == 'Yes')
                                                    {{'checked'}}
                                                @endif>
                                            <label class="form-check-label" for="smallGroupYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="smallGroup"
                                                id="smallGroupNo" value="No" @if ($member->smallGroupStatus == 'No')
                                                {{'checked'}}
                                            @endif>
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

                                </div>
                                <h4>A Follower</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="followerName" class="form-label fw-bold">Name</label>
                                            <input type="text" class="form-control " id="followerName"
                                                name="followerName" placeholder="enter your name"
                                                value="{{ old('followerName', $member->followerName) }}" autofocus />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="followerAddress" class="form-label fw-bold">Address</label>
                                            <input type="text" class="form-control " id="followerAddress"
                                                name="followerAddress" placeholder="enter your address"
                                                value="{{ old('followerAddress', $member->followerAddress) }}" autofocus />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="followerNicNumber" class="form-label fw-bold">NIC
                                                Number</label>
                                            <input type="number" class="form-control " id="followerNicNumber"
                                                name="followerNicNumber" placeholder="enter your nic number"
                                                value="{{ old('followerNicNumber', $member->followerNicNumber) }}" autofocus />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-6">
                                            <label for="followerIssueDate" class="form-label fw-bold">Issue
                                                Date</label>
                                            <input type="date" class="form-control " id="followerIssueDate"
                                                name="followerIssueDate" placeholder="enter your nic number"
                                                value="{{ old('followerIssueDate', $member->followerIssueDate) }}" autofocus />
                                        </div>
                                    </div>
                                </div>

                                <div class="col mt-3 d-flex justify-content-end">
                                    <button class="btn btn-primary" type="submit" value="updatemembersdata">Update
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
    document.addEventListener('DOMContentLoaded', function() {
        function loadVillages(divisionId, selectedVillageId = null) {
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
                            if (selectedVillageId && village.id == selectedVillageId) {
                                option.selected = true;
                            }
                            villageSelect.appendChild(option);
                        });

                        if (selectedVillageId) {
                            loadSmallGroups(selectedVillageId, divisionId, "{{ old('smallGroupId', $member->smallGroupId) }}");
                        }
                    })
                    .catch(error => console.error('Error fetching villages:', error));
            } else {
                document.getElementById('villageId').innerHTML = '<option value="">Select Village</option>';
                document.getElementById('smallGroupId').innerHTML = '<option value="">Select Small Group</option>';
            }
        }

        function loadSmallGroups(villageId, divisionId, selectedSmallGroupId = null) {
            if (villageId && divisionId) {
                fetch(`/get-smallgroup/${villageId}/${divisionId}`)
                    .then(response => response.json())
                    .then(data => {
                        var smallGroupSelect = document.getElementById('smallGroupId');
                        smallGroupSelect.innerHTML = '<option value="">Select Small Group</option>';

                        data.forEach(function(smallGroup) {
                            var option = document.createElement('option');
                            option.value = smallGroup.id;
                            option.text = smallGroup.smallGroupName;
                            if (selectedSmallGroupId && smallGroup.id == selectedSmallGroupId) {
                                option.selected = true;
                            }
                            smallGroupSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching small groups:', error));
            } else {
                document.getElementById('smallGroupId').innerHTML = '<option value="">Select Small Group</option>';
            }
        }

        document.getElementById('divisionId').addEventListener('change', function() {
            var divisionId = this.value;
            loadVillages(divisionId);
        });

        document.getElementById('villageId').addEventListener('change', function() {
            var villageId = this.value;
            var divisionId = document.getElementById('divisionId').value;
            loadSmallGroups(villageId, divisionId);
        });
        const radioButtons = document.querySelectorAll('input[name="smallGroup"]');
        const selectSmallGroupDiv = document.getElementById('selectSmallGroupDiv');

        function toggleSmallGroupDiv() {
            const selectedValue = document.querySelector('input[name="smallGroup"]:checked').value;
            if (selectedValue === 'Yes') {
                selectSmallGroupDiv.style.display = 'block';
            } else {
                selectSmallGroupDiv.style.display = 'none';
            }
        }

        radioButtons.forEach(radio => {
            radio.addEventListener('change', toggleSmallGroupDiv);
        });
        toggleSmallGroupDiv();
        var initialDivisionId = "{{ old('divisionId', $member->divisionId) }}";
        var initialVillageId = "{{ old('villageId', $member->villageId) }}";
        var initialSmallGroupId = "{{ old('smallGroupId', $member->smallGroupId) }}";

        if (initialDivisionId) {
            loadVillages(initialDivisionId, initialVillageId);
        }
        var initialSmallGroupValue = "{{ old('smallGroup', $member->smallGroup) }}";
        if (initialSmallGroupValue === 'Yes') {
            selectSmallGroupDiv.style.display = 'block';
        }
    });
</script>

