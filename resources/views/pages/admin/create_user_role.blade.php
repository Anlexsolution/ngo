<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-list"></i> manage User Role
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <a href="/user_role">
                                <button class="btn btn-success btn-sm">
                                    <i class="menu-icon ti ti-square-rounded-plus"></i> create user role
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Role Name</th>
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
                                    @foreach ($getUserRole as $userrol)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $userrol->roleName }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @php
                                                            $userRoleId = Crypt::encrypt($userrol->id);
                                                        @endphp
                                                        <a class="dropdown-item" href="{{route('update_user_role', $userRoleId)}}"><i
                                                                class="ti ti-pencil me-1"></i> Edit</a>
                                                    </div>
                                                </div>
                                            </td>
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
</div>

<script>
    function memberCheck(memberCheckBox) {
        const subMenuCheckboxes = document.querySelectorAll('#addMember, #viewMember, #ManageMember');

        subMenuCheckboxes.forEach(checkbox => {
            checkbox.checked = memberCheckBox.checked;
        });
    }

    function divisionCheck(divisionCheckBox) {
        const subMenuCheckboxes = document.querySelectorAll('#addDivision, #viewDivision, #ManageDivision');

        subMenuCheckboxes.forEach(checkbox => {
            checkbox.checked = divisionCheckBox.checked;
        });
    }

    function accountCheck(accountCheckBox) {
        const subMenuCheckboxes = document.querySelectorAll('#addAccount, #viewAccount, #ManageAccount');

        subMenuCheckboxes.forEach(checkbox => {
            checkbox.checked = accountCheckBox.checked;
        });
    }

    function loanCheck(loanCheckBox) {
        const subMenuCheckboxes = document.querySelectorAll('#addLoan, #viewLoan, #ManageLoan');

        subMenuCheckboxes.forEach(checkbox => {
            checkbox.checked = loanCheckBox.checked;
        });
    }

    function savingsCheck(savingCheckBox) {
        const subMenuCheckboxes = document.querySelectorAll('#addSavings, #viewSavings, #ManageSavings');

        subMenuCheckboxes.forEach(checkbox => {
            checkbox.checked = savingCheckBox.checked;
        });
    }

    function deathCheck(deathCheckBox) {
        const subMenuCheckboxes = document.querySelectorAll('#addDeath, #viewDeath, #ManageDeath');

        subMenuCheckboxes.forEach(checkbox => {
            checkbox.checked = deathCheckBox.checked;
        });
    }

    function repaymentCheck(repaymentCheckBox) {
        const subMenuCheckboxes = document.querySelectorAll('#addRepayment, #viewRepayment, #ManageRepayment');

        subMenuCheckboxes.forEach(checkbox => {
            checkbox.checked = repaymentCheckBox.checked;
        });
    }

    function meetingsCheck(meetingCheckBox) {
        const subMenuCheckboxes = document.querySelectorAll('#addMeetings, #viewMeetings, #ManageMeetings');

        subMenuCheckboxes.forEach(checkbox => {
            checkbox.checked = meetingCheckBox.checked;
        });
    }

    function reportCheck(reportCheckBox) {
        const subMenuCheckboxes = document.querySelectorAll('#viewReports');

        subMenuCheckboxes.forEach(checkbox => {
            checkbox.checked = reportCheckBox.checked;
        });
    }

    function userManageCheck(userManageCheckBox) {
        const subMenuCheckboxes = document.querySelectorAll('#addUsers, #manageUsers, #userRole');

        subMenuCheckboxes.forEach(checkbox => {
            checkbox.checked = userManageCheckBox.checked;
        });
    }

    function settingsCheck(settingsCheckBox) {
        const subMenuCheckboxes = document.querySelectorAll('#manage');

        subMenuCheckboxes.forEach(checkbox => {
            checkbox.checked = settingsCheckBox.checked;
        });
    }
</script>
