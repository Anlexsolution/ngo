@php
    $permissions = $userData->permissions;
    $userId = $userData->id;
@endphp
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> Update User Role
                    </div>
                    <div class="card-body">
                        <input type="hidden" value="{{$userId}}" id="txtUserId">
                        <div class="row mt-3">
                              <div class="row mb-6">
                                    <!-- Member Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                @if (in_array('member', json_decode($permissions))) checked @endif value="member"
                                                id="member"
                                                onchange="toggleSubPermissions(this, '#addMember, #viewMember, #ManageMember, #ManageMemberEdit, #ManageMemberDelete')">
                                            <label class="form-check-label" for="member">
                                                Member
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="addMember" id="addMember"
                                                @if (in_array('addMember', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="addMember">
                                                Add Member
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="viewMember" id="viewMember"
                                                @if (in_array('viewMember', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="viewMember">
                                                View Member
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageMember" id="ManageMember"
                                                @if (in_array('ManageMember', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageMember">
                                                Manage Member
                                            </label>
                                        </div>
                                        <div class="form-check ms-6">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageMemberEdit" id="ManageMemberEdit"
                                                @if (in_array('ManageMemberEdit', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageMemberEdit">
                                                Edit
                                            </label>
                                        </div>
                                        <div class="form-check ms-6">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageMemberDelete" id="ManageMemberDelete"
                                                @if (in_array('ManageMemberDelete', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageMemberDelete">
                                                Delete
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Division Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="division" id="division"
                                                @if (in_array('division', json_decode($permissions))) checked @endif
                                                onchange="toggleSubPermissions(this, '#DivisionByVillage, #divisionByGn')">
                                            <label class="form-check-label" for="division">
                                                Division
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="DivisionByVillage" id="DivisionByVillage"
                                                @if (in_array('DivisionByVillage', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="DivisionByVillage">
                                                Division by village
                                            </label>
                                        </div>
                                        {{-- <div class="form-check ms-4">
                                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                                value="viewDivision" id="viewDivision">
                                            <label class="form-check-label" for="viewDivision">
                                                View Division
                                            </label>
                                        </div> --}}
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="divisionByGn" id="divisionByGn"
                                                @if (in_array('divisionByGn', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="divisionByGn">
                                                Division By GN
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Account Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                @if (in_array('account', json_decode($permissions))) checked @endif value="account"
                                                id="account"
                                                onchange="toggleSubPermissions(this, '#addAccount, #viewAccount, #ManageAccount, #ManageAccountEdit, #ManageAccountDelete, #transferAccount, #addExpensiveIncome, #collectionTransfer')">
                                            <label class="form-check-label" for="account">
                                                Account
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="addAccount" id="addAccount"
                                                @if (in_array('addAccount', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="addAccount">
                                                Add Account
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="viewAccount" id="viewAccount"
                                                @if (in_array('viewAccount', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="viewAccount">
                                                View Account
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="transferAccount" id="transferAccount"
                                                @if (in_array('transferAccount', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="transferAccount">
                                                Transfer Account
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="addExpensiveIncome"
                                                id="addExpensiveIncome"
                                                @if (in_array('addExpensiveIncome', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="addExpensiveIncome">
                                                Expensive Income
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="collectionTransfer"
                                                id="collectionTransfer"
                                                @if (in_array('collectionTransfer', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="collectionTransfer">
                                                Collection Transfer
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageAccount" id="ManageAccount"
                                                @if (in_array('ManageAccount', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageAccount">
                                                Manage Account
                                            </label>
                                        </div>
                                        <div class="form-check ms-6">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageAccountEdit" id="ManageAccountEdit"
                                                @if (in_array('ManageAccountEdit', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageAccountEdit">
                                                Edit
                                            </label>
                                        </div>
                                        <div class="form-check ms-6">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageAccountDelete" id="ManageAccountDelete"
                                                @if (in_array('ManageAccountDelete', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageAccountDelete">
                                                Delete
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Loan Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="loan" id="loan"
                                                @if (in_array('loan', json_decode($permissions))) checked @endif
                                                onchange="toggleSubPermissions(this, '#addLoan, #loanProduct, #loanCalculator, #ManageLoan, #ManageLoanEdit , #ManageLoanRquest, #addOldLoan')">
                                            <label class="form-check-label" for="loan">
                                                Loan
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="addLoan" id="addLoan"
                                                @if (in_array('addLoan', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="addLoan">
                                                Add Loan
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="addOldLoan" id="addOldLoan"
                                                @if (in_array('addOldLoan', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="addOldLoan">
                                                Add Old Loan
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageLoanRquest" id="ManageLoanRquest"
                                                @if (in_array('ManageLoanRquest', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageLoanRquest">
                                                Request of Loan
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="loanProduct" id="loanProduct"
                                                @if (in_array('loanProduct', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="loanProduct">
                                                Loan Product
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="loanCalculator" id="loanCalculator"
                                                @if (in_array('loanCalculator', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="loanCalculator">
                                                Loan Calculator
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageLoan" id="ManageLoan"
                                                @if (in_array('ManageLoan', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageLoan">
                                                Manage Loan
                                            </label>
                                        </div>
                                        <div class="form-check ms-6">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageLoanEdit" id="ManageLoanEdit"
                                                @if (in_array('ManageLoanEdit', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageLoanEdit">
                                                Edit
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- Savings Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="savings" id="savings"
                                                @if (in_array('savings', json_decode($permissions))) checked @endif
                                                onchange="toggleSubPermissions(this, '#savingsSettings,#addSavings, #viewSavings, #ManageSavings, #ManageSavingsEdit, #ManageSavingsDelete, #ImportSavingHistory, #Withdrawal')">
                                            <label class="form-check-label" for="savings">
                                                Savings
                                            </label>
                                        </div>
                                        <div class="form-check ms-4" hidden>
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="addSavings" id="addSavings"
                                                @if (in_array('addSavings', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="addSavings">
                                                Add Savings
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="viewSavings" id="viewSavings"
                                                @if (in_array('viewSavings', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="viewSavings">
                                                View Savings
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageSavings" id="ManageSavings"
                                                @if (in_array('ManageSavings', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageSavings">
                                                Manage Savings
                                            </label>
                                        </div>

                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="savingsSettings" id="savingsSettings"
                                                @if (in_array('savingsSettings', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="savingsSettings">
                                                Settings
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="Withdrawal" id="Withdrawal"
                                                @if (in_array('Withdrawal', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="Withdrawal">
                                                Withdrawal
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="ImportSavingHistory"
                                                id="ImportSavingHistory"
                                                @if (in_array('ImportSavingHistory', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ImportSavingHistory">
                                                Import Saving History
                                            </label>
                                        </div>
                                            <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="transferSavings"
                                                id="ImportSavingHistory"
                                                @if (in_array('transferSavings', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="transferSavings">
                                               Transfer Savings
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Death Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="death" id="death"
                                                @if (in_array('death', json_decode($permissions))) checked @endif
                                                onchange="toggleSubPermissions(this, '#addDeath, #viewDeath, #ManageDeath, #ManageDeathEdit, #ManageDeathDelete, #ImportDeathHistory')">
                                            <label class="form-check-label" for="death">
                                                Death Subscription
                                            </label>
                                        </div>
                                        <div class="form-check ms-4" hidden>
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="addDeath" id="addDeath"
                                                @if (in_array('addDeath', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="addDeath">
                                                Add Death
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="viewDeath" id="viewDeath"
                                                @if (in_array('viewDeath', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="viewDeath">
                                                View Death
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageDeath" id="ManageDeath"
                                                @if (in_array('ManageDeath', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageDeath">
                                                Manage Death
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="ImportDeathHistory"
                                                id="ImportDeathHistory"
                                                @if (in_array('ImportDeathHistory', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ImportDeathHistory">
                                                Import Death History
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="deathDonation" id="deathDonation"
                                                @if (in_array('deathDonation', json_decode($permissions))) checked @endif
                                                onchange="toggleSubPermissions(this, '#manageDeathDonation')">
                                            <label class="form-check-label" for="deathDonation">
                                                Death Donation
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="manageDeathDonation" id="manageDeathDonation"
                                                @if (in_array('manageDeathDonation', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="manageDeathDonation">
                                                Manage Death Donation
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Other Income Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="otherIncome" id="otherIncome"
                                                @if (in_array('otherIncome', json_decode($permissions))) checked @endif
                                                onchange="toggleSubPermissions(this, '#manageIncome, #importOtherIncome')">
                                            <label class="form-check-label" for="otherIncome">
                                                Other Income
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="manageIncome" id="manageIncome"
                                                @if (in_array('manageIncome', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="manageIncome">
                                                Manage Income
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="importOtherIncome" id="importOtherIncome"
                                                @if (in_array('importOtherIncome', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="importOtherIncome">
                                                Import Income
                                            </label>
                                        </div>
                                    </div>


                                    <!-- Repayment Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="repayment" id="repayment"
                                                 @if (in_array('repayment', json_decode($permissions))) checked @endif
                                                onchange="toggleSubPermissions(this, '#directSavings, #loanRepayment, #openingBalance, #collectionDeposit')">
                                            <label class="form-check-label" for="repayment">
                                                Collection
                                            </label>
                                        </div>
                                        {{-- <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="directSavings" id="directSavings"
                                                @if (in_array('directSavings', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="directSavings">
                                                Direct Savings
                                            </label>
                                        </div> --}}
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="loanRepayment" id="loanRepayment"
                                                @if (in_array('loanRepayment', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="loanRepayment">
                                                Loan Repayment
                                            </label>
                                        </div>
                                        {{-- <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="openingBalance" id="openingBalance"
                                                @if (in_array('openingBalance', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="openingBalance">
                                                Opening Balance
                                            </label>
                                        </div> --}}
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="collectionDeposit" id="collectionDeposit"
                                                @if (in_array('collectionDeposit', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="collectionDeposit">
                                                Collection Deposit
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Meetings Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="meetings" id="meetings"
                                                @if (in_array('meetings', json_decode($permissions))) checked @endif
                                                onchange="toggleSubPermissions(this, '#addMeetings, #viewMeetings, #ManageMeetings, #ManageMeetingsEdit, #ManageMeetingsDelete')">
                                            <label class="form-check-label" for="meetings">
                                                Meetings
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="addMeetings" id="addMeetings"
                                                @if (in_array('addMeetings', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="addMeetings">
                                                Add Meetings
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="viewMeetings" id="viewMeetings"
                                                @if (in_array('viewMeetings', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="viewMeetings">
                                                View Meetings
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageMeetings" id="ManageMeetings"
                                                @if (in_array('ManageMeetings', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageMeetings">
                                                Manage Meetings
                                            </label>
                                        </div>
                                        <div class="form-check ms-6">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="ManageMeetingsEdit" id="ManageMeetingsEdit"
                                                @if (in_array('ManageMeetingsEdit', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="ManageMeetingsEdit">
                                                Edit
                                            </label>
                                        </div>

                                    </div>
                                    <hr>
                                    <!-- Reports Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="report" id="report"
                                                @if (in_array('report', json_decode($permissions))) checked @endif
                                                onchange="toggleSubPermissions(this, '#openingBalanceReport, #memberReport, #withdrawalReport, #collectionReport, #collectionvsdeposit, #loanReport')">
                                            <label class="form-check-label" for="report">
                                                Reports
                                            </label>
                                        </div>
                                        {{-- <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="openingBalanceReport"
                                                id="openingBalanceReport"
                                                @if (in_array('openingBalanceReport', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="openingBalanceReport">
                                                Opening Balance Report
                                            </label>
                                        </div> --}}
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="memberReport" id="memberReport"
                                                @if (in_array('memberReport', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="memberReport">
                                                Member Report
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="withdrawalReport" id="withdrawalReport"
                                                @if (in_array('withdrawalReport', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="withdrawalReport">
                                                Withdrawal Report
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="collectionReport" id="collectionReport"
                                                @if (in_array('collectionReport', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="collectionReport">
                                                Collection Report
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="collectionvsdeposit"
                                                id="collectionvsdeposit"
                                                @if (in_array('collectionvsdeposit', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="collectionvsdeposit">
                                                Collection VS Deposit Report
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="loanReport" id="loanReport"
                                                @if (in_array('loanReport', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="loanReport">
                                                Loan Report
                                            </label>
                                        </div>
                                         <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox"
                                                name="permissions[]" value="loanArreasReport" id="loanArreasReport"
                                                @if (in_array('loanArreasReport', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="loanArreasReport">
                                                Loan Arreas Report
                                            </label>
                                        </div>
                                    </div>

                                    <!-- User Manage Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="userManage" id="userManage"
                                                @if (in_array('userManage', json_decode($permissions))) checked @endif
                                                onchange="toggleSubPermissions(this, '#addUsers, #manageUsers, #userRole')">
                                            <label class="form-check-label" for="userManage">
                                                User Manage
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="addUsers" id="addUsers"
                                                @if (in_array('addUsers', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="addUsers">
                                                Add Users
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="manageUsers" id="manageUsers"
                                                @if (in_array('manageUsers', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="manageUsers">
                                                Manage Users
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="userRole" id="userRole"
                                                @if (in_array('userRole', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="userRole">
                                                User Role
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Settings Module -->
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="settings" id="settings"
                                                @if (in_array('settings', json_decode($permissions))) checked @endif
                                                onchange="toggleSubPermissions(this, '#manage, #activityLog')">
                                            <label class="form-check-label" for="settings">
                                                Settings
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="manage" id="manage"
                                                @if (in_array('manage', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="manage">
                                                Manage
                                            </label>
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input userPermissions" type="checkbox" name="permissions[]"
                                                value="activityLog" id="activityLog"
                                                @if (in_array('activityLog', json_decode($permissions))) checked @endif>
                                            <label class="form-check-label" for="activityLog">
                                                activity Log
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col mt-3 d-flex justify-content-end">
                                    <button class="btn btn-primary" id="btnUpdateUserPermission">Update
                                       User Role</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSubPermissions(mainCheckbox, subPermissionIds) {
            const subMenuCheckboxes = document.querySelectorAll(subPermissionIds);
            subMenuCheckboxes.forEach(checkbox => {
                checkbox.checked = mainCheckbox.checked;
            });
        }

        function memberCheck(memberCheckBox) {
            toggleSubPermissions(memberCheckBox,
                '#addMember, #viewMember, #ManageMember, #ManageMemberEdit, #ManageMemberDelete');
        }

        function divisionCheck(divisionCheckBox) {
            toggleSubPermissions(divisionCheckBox, '#divisionByGn, #DivisionByVillage');
        }

        function accountCheck(accountCheckBox) {
            toggleSubPermissions(accountCheckBox,
                '#addAccount, #viewAccount, #ManageAccount, #ManageAccountEdit, #ManageAccountDelete');
        }

        function loanCheck(loanCheckBox) {
            toggleSubPermissions(loanCheckBox, '#addLoan, #viewLoan, #ManageLoan, #ManageLoanEdit, #ManageLoanDelete');
        }

        function savingsCheck(savingsCheckBox) {
            toggleSubPermissions(savingsCheckBox,
                '#savingsSettings,#addSavings, #viewSavings, #ManageSavings, #ManageSavingsEdit, #ManageSavingsDelete');
        }

        function deathCheck(deathCheckBox) {
            toggleSubPermissions(deathCheckBox,
            '#addDeath, #viewDeath, #ManageDeath, #ManageDeathEdit, #ManageDeathDelete');
        }

        function repaymentCheck(repaymentCheckBox) {
            toggleSubPermissions(repaymentCheckBox, '#directSavings, #loanRepayment, #openingBalance');

        }

        function meetingsCheck(meetingsCheckBox) {
            toggleSubPermissions(meetingsCheckBox,
                '#addMeetings, #viewMeetings, #ManageMeetings, #ManageMeetingsEdit, #ManageMeetingsDelete');
        }

        function reportCheck(reportCheckBox) {
            toggleSubPermissions(reportCheckBox, '#openingBalanceReport');
        }

        function userManageCheck(userManageCheckBox) {
            toggleSubPermissions(userManageCheckBox, '#addUsers, #manageUsers, #userRole');
        }

        function settingsCheck(settingsCheckBox) {
            toggleSubPermissions(settingsCheckBox, '#manage', '#activityLog');
        }
    </script>
