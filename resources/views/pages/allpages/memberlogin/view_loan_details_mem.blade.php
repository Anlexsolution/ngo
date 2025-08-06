<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-list"></i> Manage Loan Details
                        </div>

                    </div>
                    <div class="card-body">
                        <br>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="loanDetails-tab" data-bs-toggle="tab"
                                    data-bs-target="#loanDetails" type="button" role="tab"
                                    aria-controls="loanDetails" aria-selected="true">Loan Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="repaymentSchedule-tab" data-bs-toggle="tab"
                                    data-bs-target="#repaymentSchedule" type="button" role="tab"
                                    aria-controls="repaymentSchedule" aria-selected="false">Repayment</button>
                            </li>
                            {{-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="repaymentDetails-tab" data-bs-toggle="tab"
                                    data-bs-target="#repaymentDetails" type="button" role="tab"
                                    aria-controls="repaymentDetails" aria-selected="false">Repayment Details</button>
                            </li> --}}
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="loanDetails" role="tabpanel"
                                aria-labelledby="loanDetails-tab">
                                @include('pages.allpages.memberlogin.loan_details_view_mem')
                            </div>
                            <div class="tab-pane fade" id="repaymentSchedule" role="tabpanel"
                                aria-labelledby="repaymentSchedule-tab">
                                @include('pages.allpages.loan.repayment_schedule_view')
                            </div>
                            {{-- <div class="tab-pane fade" id="repaymentDetails" role="tabpanel"
                            aria-labelledby="repaymentDetails-tab">
                            @include('pages.allpages.loan.repayment_details')
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

