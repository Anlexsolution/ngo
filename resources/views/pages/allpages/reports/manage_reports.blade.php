@php
    $reports = [
        ['url' => '/member_report', 'title' => 'Member Report'],
        ['url' => '/withrawal_approve_reports', 'title' => 'Withdrawal Report'],
        ['url' => '/collection_reports', 'title' => 'Collection Report'],
        ['url' => '/collection_vs_deposit_reports', 'title' => 'Collection vs Deposit'],
        ['url' => '/loan_report', 'title' => 'Loan Report'],
        ['url' => '/loan_arreas_report', 'title' => 'Loan Arrears Report'],
        ['url' => '/group_report', 'title' => 'Group Report'],
        ['url' => '/group_leader_report', 'title' => 'Group Leader Report'],
        ['url' => '/member_savings_report', 'title' => 'Member Savings Report'],
    ];
@endphp

<style>
    .report-card {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease-in-out;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .report-card:hover {
        background-color: #0d6efd;
        color: white;
        transform: translateY(-3px);
    }

    .report-card .icon {
        font-size: 40px;
        color: #0d6efd;
        transition: color 0.3s;
    }

    .report-card:hover .icon {
        color: white;
    }

    .report-title {
        font-size: 1rem;
        font-weight: 600;
        text-align: center;
        text-transform: uppercase;
        margin-top: 10px;
        color: #212529;
    }

    .report-card:hover .report-title {
        color: white;
    }

    .card-link {
        text-decoration: none;
    }

    .card-body-custom {
        display: flex;
        align-items: center;
        padding: 20px;
        height: 100px;
    }
</style>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h4 class="text-primary fw-bold text-uppercase">Micro Finance Reports Dashboard</h4>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            @foreach($reports as $report)
                <div class="col">
                    <a href="{{ $report['url'] }}" class="card-link">
                        <div class="report-card p-3 h-100">
                            <div class="card-body-custom">
                                <div class="me-3">
                                    <i class="ti ti-report-search icon"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="report-title">{{ $report['title'] }}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
