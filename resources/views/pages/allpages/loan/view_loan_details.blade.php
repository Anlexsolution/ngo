<style>
    .section-title {
        border-left: 5px solid #007bff;
        padding-left: 10px;
        margin-bottom: 15px;
        font-weight: 600;
        font-size: clamp(1rem, 1.5vw, 1.25rem);
        color: #343a40;
    }

    .profile-card .form-control-plaintext {
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }

    .btn-styled {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        vertical-align: middle;
    }

    .profile-photo {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 50%;
        object-fit: cover;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    @media (max-width: 350px) {

        body,
        .container-fluid {
            padding-left: 0.05rem !important;
            padding-right: 0.05rem !important;
        }

        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .col-12,
        .col-sm-12 {
            padding-left: 0.25rem !important;
            padding-right: 0.25rem !important;
        }

        .profile-card {
            padding: 0.75rem !important;
        }

        .btn-styled {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>
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
                                @include('pages.allpages.loan.loan_details_view')
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

