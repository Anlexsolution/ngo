@php
    use Illuminate\Support\Facades\Session;

    $member = Auth::user();

    $encMemId = Session::get('encMemId');
    $userId = Session::get('userId');
    $userEmail = Session::get('userEmail');
    $userName = Session::get('userName');
    $userRole = Session::get('userRole');
    $memberUniqueId = Session::get('memberUniqueId');

    // Main related data
    $loanRequest = Session::get('loanRequest');
    $withdrawal = Session::get('withdrawal');
    $withdrawalHistory = Session::get('withdrawalHistory');
    $userRoles = Session::get('userRoles');
    $deathDonation = Session::get('deathDonation');

    // Member details
    $getPro = Session::get('getPro');
    $getSubPro = Session::get('getSubPro');
    $getGnDivision = Session::get('getGnDivision');
    $gndivisionSmallgroup = Session::get('gndivisionSmallgroup');

    // Loan details
    $getData = Session::get('getData');
    $getDataActive = Session::get('getDataActive');

    // Redundant user role data (if needed)
    $getuserRole = Session::get('getuserRole');

    // Financial data
    $getSavings = Session::get('getSavings');
    $totalSavings = Session::get('totalSavings');
    $totalDeath = Session::get('totalDeath');
    $totalOtherIncome = Session::get('totalOtherIncome');
    $totalLoanAmount = Session::get('totalLoanAmount');
    $totalLoanArrears = Session::get('totalLoanArrears');
@endphp

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> {{ $member->firstName }} {{ $member->lastName }} - {{ $member->nicNumber }} -
                        {{ $member->oldAccountNumber }}
                    </div>
                    <div class="card-body">
                        <input type="hidden" value="{{ $member->id }}" id="txtMemberId">
                        <div class="nav-align-top mt-3">
                            <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab"
                                            data-bs-toggle="tab" data-bs-target="#navs-justified-personal"
                                            aria-controls="navs-justified-personal" aria-selected="true">
                                            Personal Details
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-savings"
                                            aria-controls="navs-justified-link-savings" aria-selected="false">
                                            Savings
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-loan"
                                            aria-controls="navs-justified-link-loan" aria-selected="false">
                                            Loan
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-death"
                                            aria-controls="navs-justified-link-death" aria-selected="false">
                                            Death
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-meetings"
                                            aria-controls="navs-justified-link-meetings" aria-selected="false">
                                            Meetings
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-link-location"
                                            aria-controls="navs-justified-link-location" aria-selected="false">
                                            Location
                                        </button>
                                    </li>
                              

                            </ul>
                            <div class="tab-content border-0 mx-1">
                                <div class="tab-pane fade show active" id="navs-justified-personal" role="tabpanel">
                                    @include('pages.allpages.memberpages.personal_details')
                                </div>
                                <div class="tab-pane fade show " id="navs-justified-link-savings" role="tabpanel">
                                    @include('pages.allpages.memberpages.saving_details')
                                </div>
                                <div class="tab-pane fade show " id="navs-justified-link-loan" role="tabpanel">
                                    @include('pages.allpages.memberpages.loan_details')
                                </div>
                                <div class="tab-pane fade show " id="navs-justified-link-death" role="tabpanel">
                                    @include('pages.allpages.memberpages.death_details')
                                </div>
                                <div class="tab-pane fade show " id="navs-justified-link-meetings" role="tabpanel">
                                    @include('pages.allpages.memberpages.meetings_details')
                                </div>
                                 <div class="tab-pane fade show " id="navs-justified-link-location" role="tabpanel">
                                    @include('pages.allpages.memberpages.manage_location')
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>