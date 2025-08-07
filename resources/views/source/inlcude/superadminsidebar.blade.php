<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <img src="../../assets/img/logo.png" alt="" height="50" width="70" style="margin-left: 10px;">


        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>

    @php
        $permissions = Auth::user()->permissions;
    @endphp

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item active">
            <a href="/dashboard" class="menu-link ">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>



        <!-- Menu -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Menu">Menu</span>
        </li>

        <!-- Members start -->
        @if ($userType == 'superAdmin')
            <li class="menu-item">
                <a href="/manage_member" class="menu-link">
                    <i class="menu-icon ti ti-user-circle"></i>
                    <div data-i18n="Member">Member</div>
                </a>
            </li>
            {{-- <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ti ti-user-circle"></i>
                    <div data-i18n="Members">Members</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/create_member" class="menu-link">
                            <div data-i18n="Add Member">Add Member</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="View Member">View Member</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/manage_member" class="menu-link">
                            <div data-i18n="Manage Member">Manage Member</div>
                        </a>
                    </li>
                </ul>
            </li> --}}
        @else
            @php
                $userRolesArray = $getUserRole->pluck('roleName')->toArray();
            @endphp

            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('member', $usersDataPer) ||
                        in_array('addMember', $usersDataPer) ||
                        in_array('viewMember', $usersDataPer) ||
                        in_array('ManageMember', $usersDataPer))
                    <li class="menu-item">
                        <a href="/manage_member" class="menu-link">
                            <i class="menu-icon ti ti-user-circle"></i>
                            <div data-i18n="Member">Member</div>
                        </a>
                    </li>
                    {{-- <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon ti ti-user-circle"></i>
                            <div data-i18n="Members">Members</div>
                        </a>
                        <ul class="menu-sub">
                            @if (in_array('addMember', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/create_member" class="menu-link">
                                        <div data-i18n="Add Member">Add Member</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('viewMember', $usersDataPer))
                                <li class="menu-item">
                                    <a href="#" class="menu-link">
                                        <div data-i18n="View Member">View Member</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('ManageMember', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/manage_member" class="menu-link">
                                        <div data-i18n="Manage Member">Manage Member</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li> --}}
                @endif
            @endif
        @endif
        <!-- Members end -->

        <!-- Division start -->
        @if ($userType == 'superAdmin')
            <li class="menu-item">
                <a href="/division_by_village" class="menu-link">
                    <i class="menu-icon ti ti-building"></i>
                    <div data-i18n="Division">Division</div>
                </a>
            </li>
            {{-- <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ti ti-building"></i>
                    <div data-i18n="Division">Division</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/division_by_village" class="menu-link">
                            <div data-i18n="Division by village">Division by village</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="View Division">View Division</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/division_by_gn" class="menu-link">
                            <div data-i18n="Division By GN">Division By GN</div>
                        </a>
                    </li>
                </ul>
            </li> --}}
        @else
            @php
                $userRolesArray = $getUserRole->pluck('roleName')->toArray();
            @endphp

            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('division', $usersDataPer) ||
                        in_array('DivisionByVillage', $usersDataPer) ||
                        in_array('divisionByGn', $usersDataPer))
                    <li class="menu-item">
                        <a href="/division_by_village" class="menu-link">
                            <i class="menu-icon ti ti-building"></i>
                            <div data-i18n="Division">Division</div>
                        </a>
                    </li>
                    {{-- <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon ti ti-building"></i>
                            <div data-i18n="Division">Division</div>
                        </a>
                        <ul class="menu-sub">
                            @if (in_array('DivisionByVillage', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/division_by_village" class="menu-link">
                                        <div data-i18n="Division by village">Division by village</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('viewDivision', $usersDataPer))
                                <li class="menu-item">
                                    <a href="#" class="menu-link">
                                        <div data-i18n="View Division">View Division</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('divisionByGn', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/division_by_gn" class="menu-link">
                                        <div data-i18n="Division By GN">Division By GN</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li> --}}
                @endif
            @endif
        @endif
        <!-- Division end -->

        <!-- Accounts start -->
        @if ($userType == 'superAdmin')

            <li class="menu-item">
                <a href="/manage_account" class="menu-link ">
                    <i class="menu-icon tf-icons ti ti-calculator"></i>
                    <div data-i18n="Chart of Accounts">Chart of Accounts</div>
                </a>
            </li>
        @else
            @php
                $userRolesArray = $getUserRole->pluck('roleName')->toArray();
            @endphp

            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('account', $usersDataPer) ||
                        in_array('addAccount', $usersDataPer) ||
                        in_array('viewAccount', $usersDataPer) ||
                        in_array('ManageAccount', $usersDataPer))
                    <li class="menu-item ">
                        <a href="/manage_account" class="menu-link ">
                            <i class="menu-icon tf-icons ti ti-calculator"></i>
                            <div data-i18n="Chart of Accounts">Chart of Accounts</div>
                        </a>
                    </li>
                @endif
            @endif
        @endif
        <!-- Accounts end -->

        <!-- Loan start -->
        @if ($userType == 'superAdmin')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ti ti-building-bank"></i>
                    <div data-i18n="Loan">Loan</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/list_of_loan" class="menu-link">
                            <div data-i18n="List Of Loan">List Of Loan</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/manage_loan_request" class="menu-link">
                            <div data-i18n="Request Of Loan">Request Of Loan</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/manage_loan_product" class="menu-link">
                            <div data-i18n="Loan Product">Loan Product</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="Loan Calculator">Loan Calculator</div>
                        </a>
                    </li>
                </ul>
            </li>
        @else
            @php
                $userRolesArray = $getUserRole->pluck('roleName')->toArray();
            @endphp

            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('loan', $usersDataPer) ||
                        in_array('addLoan', $usersDataPer) ||
                        in_array('viewLoan', $usersDataPer) ||
                        in_array('ManageLoanRquest', $usersDataPer) ||
                        in_array('ManageLoan', $usersDataPer))
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon ti ti-building-bank"></i>
                            <div data-i18n="Loan">Loan</div>
                        </a>
                        <ul class="menu-sub">
                            @if (in_array('ManageLoan', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/list_of_loan" class="menu-link">
                                        <div data-i18n="List Of Loan">List Of Loan</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('ManageLoanRquest', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/manage_loan_request" class="menu-link">
                                        <div data-i18n="Request Of Loan">Request Of Loan</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('loanProduct', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/manage_loan_product" class="menu-link">
                                        <div data-i18n="Loan Product">Loan Product</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('loanCalculator', $usersDataPer))
                                <li class="menu-item">
                                    <a href="#" class="menu-link">
                                        <div data-i18n="Loan Calculator">Loan Calculator</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif
        @endif
        <!-- Loan end -->

        <!-- Savings start -->
        @if ($userType == 'superAdmin')

            <li class="menu-item">
                <a href="/manage_savings" class="menu-link">
                    <i class="menu-icon ti ti-notebook"></i>
                    <div data-i18n="Savings">Savings</div>
                </a>
            </li>
        @else
            @php
                $userRolesArray = $getUserRole->pluck('roleName')->toArray();
            @endphp

            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('savings', $usersDataPer) ||
                        in_array('addSavings', $usersDataPer) ||
                        in_array('viewSavings', $usersDataPer) ||
                        in_array('ManageSavings', $usersDataPer))
                    <li class="menu-item">
                        <a href="/manage_savings" class="menu-link">
                            <i class="menu-icon ti ti-notebook"></i>
                            <div data-i18n="Savings">Savings</div>
                        </a>
                    </li>
                @endif
            @endif
        @endif
        <!-- Savings end -->

        <!-- Death Subscription start -->
        @if ($userType == 'superAdmin')
            <li class="menu-item">
                <a href="/manage_death" class="menu-link">
                    <i class="menu-icon ti ti-users"></i>
                    <div data-i18n="Death Subscription">Death Subscription</div>
                </a>
            </li>
        @else
            @php
                $userRolesArray = $getUserRole->pluck('roleName')->toArray();
            @endphp

            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('death', $usersDataPer) ||
                        in_array('addDeath', $usersDataPer) ||
                        in_array('viewDeath', $usersDataPer) ||
                        in_array('ManageDeath', $usersDataPer))
                    <li class="menu-item">
                        <a href="/manage_death" class="menu-link">
                            <i class="menu-icon ti ti-users"></i>
                            <div data-i18n="Death Subscription">Death Subscription</div>
                        </a>
                    </li>
                @endif
            @endif
        @endif
        <!-- Death Subscription end -->

        <!-- Death Donation start -->
        @if ($userType == 'superAdmin')
            <li class="menu-item">
                <a href="/manage_death_donation" class="menu-link">
                    <i class="menu-icon ti ti-users"></i>
                    <div data-i18n="Death Donation">Death Donation</div>
                </a>
            </li>
        @else
            @php
                $userRolesArray = $getUserRole->pluck('roleName')->toArray();
            @endphp

            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('deathDonation', $usersDataPer) || in_array('manageDeathDonation', $usersDataPer))
                    <li class="menu-item">
                        <a href="/manage_death_donation" class="menu-link">
                            <i class="menu-icon ti ti-users"></i>
                            <div data-i18n="Death Donation">Death Donation</div>
                        </a>
                    </li>
                @endif
            @endif
        @endif
        <!-- Death Donation end -->

        <!-- Other Income start -->
        @if ($userType == 'superAdmin')
            <li class="menu-item">
                <a href="/manage_other_incomes" class="menu-link">
                    <i class="menu-icon ti ti-users"></i>
                    <div data-i18n="Other Incomes">Other Incomes</div>
                </a>
            </li>
        @else
            @php
                $userRolesArray = $getUserRole->pluck('roleName')->toArray();
            @endphp

            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('otherIncome', $usersDataPer) || in_array('manageIncome', $usersDataPer))
                    <li class="menu-item">
                        <a href="/manage_other_incomes" class="menu-link">
                            <i class="menu-icon ti ti-users"></i>
                            <div data-i18n="Other Incomes">Other Incomes</div>
                        </a>
                    </li>
                @endif
            @endif
        @endif
        <!-- Death Subscription end -->

        <!-- Repayment start -->
        @if ($userType == 'superAdmin')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ti ti-coins"></i>
                    <div data-i18n="Collection">Collection </div>
                </a>
                <ul class="menu-sub">
                    {{-- <li class="menu-item">
                        <a href="/direct_savings" class="menu-link">
                            <div data-i18n="Direct Savings">Direct Savings</div>
                        </a>
                    </li> --}}
                    <li class="menu-item">
                        <a href="/loan_repayment" class="menu-link">
                            <div data-i18n="Loan Repayment">Loan Repayment</div>
                        </a>
                    </li>
                    {{-- <li class="menu-item">
                        <a href="/opening_balance" class="menu-link">
                            <div data-i18n="Opening Balance">Opening Balance</div>
                        </a>
                    </li> --}}
                    <li class="menu-item">
                        <a href="/collection_deposit" class="menu-link">
                            <div data-i18n="Collection Deposit">Collection Deposit</div>
                        </a>
                    </li>
                </ul>
            </li>
        @else
            @php
                $userRolesArray = $getUserRole->pluck('roleName')->toArray();
            @endphp

            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('repayment', $usersDataPer) ||
                        in_array('directSavings', $usersDataPer) ||
                        in_array('loanRepayment', $usersDataPer) ||
                        in_array('openingBalance', $usersDataPer))
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon ti ti-coins"></i>
                            <div data-i18n="Repayment">Repayment </div>
                        </a>
                        <ul class="menu-sub">
                            {{-- @if (in_array('directSavings', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/direct_savings" class="menu-link">
                                        <div data-i18n="Direct Savings">Direct Savings</div>
                                    </a>
                                </li>
                            @endif --}}
                            @if (in_array('loanRepayment', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/loan_repayment" class="menu-link">
                                        <div data-i18n="Loan Repayment">Loan Repayment</div>
                                    </a>
                                </li>
                            @endif
                            {{-- @if (in_array('openingBalance', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/opening_balance" class="menu-link">
                                        <div data-i18n="Opening Balance">Opening Balance</div>
                                    </a>
                                </li>
                            @endif --}}
                            @if (in_array('collectionDeposit', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/collection_deposit" class="menu-link">
                                        <div data-i18n="Collection Deposit">Collection Deposit</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif
        @endif
        <!-- Repayment end -->

        <!-- Meetings start -->
        @if ($userType == 'superAdmin')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ti ti-brand-zoom"></i>
                    <div data-i18n="Meetings">Meetings </div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/add_meeting" class="menu-link">
                            <div data-i18n="Add Meetings">Add Meetings</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/manage_meetings" class="menu-link">
                            <div data-i18n="Manage Meetings"> Meetings</div>
                        </a>
                    </li>
                </ul>
            </li>
        @else
            @php
                $userRolesArray = $getUserRole->pluck('roleName')->toArray();
            @endphp

            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('meetings', $usersDataPer) ||
                        in_array('addMeetings', $usersDataPer) ||
                        in_array('viewMeetings', $usersDataPer) ||
                        in_array('ManageMeetings', $usersDataPer))
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon ti ti-brand-zoom"></i>
                            <div data-i18n="Meetings">Meetings </div>
                        </a>
                        <ul class="menu-sub">
                            @if (in_array('addMeetings', $usersDataPer))
                                <li class="menu-item">
                                    <a href="#" class="menu-link">
                                        <div data-i18n="Add Meetings">Add Meetings</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('viewMeetings', $usersDataPer))
                                <li class="menu-item">
                                    <a href="#" class="menu-link">
                                        <div data-i18n="View Meetings">View Meetings</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('ManageMeetings', $usersDataPer))
                                <li class="menu-item">
                                    <a href="#" class="menu-link">
                                        <div data-i18n="Manage Meetings"> Meetings</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif
        @endif
        <!-- Meetings end -->

        <!-- Reports start -->
        @if ($userType == 'superAdmin')
            <li class="menu-item">
                <a href="/manage_reports" class="menu-link">
                    <i class="menu-icon ti ti-report-search"></i>
                    <div data-i18n="Reports">Reports</div>
                </a>
            </li>
        @else
            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('report', $usersDataPer) || in_array('openingBalanceReport', $usersDataPer))
                    <li class="menu-item">
                        <a href="/manage_reports" class="menu-link">
                            <i class="menu-icon ti ti-report-search"></i>
                            <div data-i18n="Reports">Reports</div>
                        </a>
                    </li>
                @endif
            @endif
        @endif
        <!-- Reports end -->

        <!-- Users Manage start -->
        @if ($userType == 'superAdmin')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ti ti-users-group"></i>
                    <div data-i18n="Users Manage">Users Manage </div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/manage_users" class="menu-link">
                            <div data-i18n="Manage Users">Manage Users</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/manage_user_role" class="menu-link">
                            <div data-i18n="User Role">User Role</div>
                        </a>
                    </li>
                </ul>
            </li>
        @else
            @if (in_array($userType, $userRolesArray))
                @php
                    $usersDataPer = $permissions;
                    $usersDataPer = json_decode($usersDataPer, true);
                @endphp

                @if (in_array('userManage', $usersDataPer) ||
                        in_array('addUsers', $usersDataPer) ||
                        in_array('manageUsers', $usersDataPer) ||
                        in_array('userRole', $usersDataPer))
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon ti ti-users-group"></i>
                            <div data-i18n="Users Manage">Users Manage </div>
                        </a>
                        <ul class="menu-sub">

                            @if (in_array('manageUsers', $usersDataPer) || in_array('addUsers', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/manage_users" class="menu-link">
                                        <div data-i18n="Manage Users">Manage Users</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('userRole', $usersDataPer))
                                <li class="menu-item">
                                    <a href="/user_role" class="menu-link">
                                        <div data-i18n="User Role">User Role</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif
        @endif
        <!-- Users Manage end -->

        <!-- Settings start -->
        @if ($userType == 'superAdmin')
            <li class="menu-item">
                <a href="/manage_settings" class="menu-link">
                    <i class="menu-icon ti ti-settings"></i>
                    <div data-i18n="Manage Settings">Manage Settings</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/manage_activitylog" class="menu-link">
                    <i class="menu-icon ti ti-settings"></i>
                    <div data-i18n="ActivityLog">ActivityLog</div>
                </a>
            </li>
        @elseif (in_array($userType, $userRolesArray))
            @php
                $usersDataPer = $permissions;
                $usersDataPer = json_decode($usersDataPer, true);
            @endphp

            @if (in_array('manage', $usersDataPer))
                <li class="menu-item">
                    <a href="/manage_settings" class="menu-link">
                        <i class="menu-icon ti ti-settings"></i>
                        <div data-i18n="Manage Settings">Manage Settings</div>
                    </a>
                </li>
            @endif

            @if (in_array('activityLog', $usersDataPer))
                <li class="menu-item">
                    <a href="/manage_activitylog" class="menu-link">
                        <i class="menu-icon ti ti-settings"></i>
                        <div data-i18n="ActivityLog">ActivityLog</div>
                    </a>
                </li>
            @endif
        @endif
        <!-- Settings end -->
    </ul>
</aside>
