<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mt-3">

            <div class="col-12 col-sm-6 col-lg-4 mb-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="mb-4 text-heading ti ti-vocabulary ti-32px"></i>
                        <h5>Add New Division</h5>
                        <a href="/create_division">
                            <button type="button" class="btn btn-primary">
                                ADD
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 mb-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="mb-4 text-heading ti ti-map-search ti-32px"></i>
                        <h5>Add New Village</h5>
                        <a href="/create_village">
                            <button type="button" class="btn btn-primary">
                                ADD
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 mb-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="mb-4 text-heading ti ti-users-group ti-32px"></i>
                        <h5>Add New Small Group</h5>
                        <a href="/create_smallgroup">
                            <button type="button" class="btn btn-primary">
                                ADD
                            </button>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="card shadow">
            <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                <i class="menu-icon ti ti-users-group"></i> View
            </div>
            <div class="card-body">
                <div class="row mt-3">
                    <table class="table table-sm datatableView">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Division</th>
                                <th>Village</th>
                                <th>Small Group</th>
                                <th>No of Members</th>
                                <th>Total Savings</th>
                                <th>No of total loan</th>
                                <th>Loan Capital</th>
                                <th>No Of Active Loan</th>
                                <th>Active Loan Total Amount</th>
                                <th>Total Interest</th>
                                <th>Total Capital Collection</th>
                                <th>Total Interest Collection</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($getSmallGroup as $smallGroup)
                                <tr>
                                    <td>@php
                                        echo $i++;
                                    @endphp</td>

                                    <td>
                                        @foreach ($getDivision as $division)
                                            @php
                                                $divisionId = $division->id;
                                                $divIdEnc = Crypt::encrypt($divisionId);
                                            @endphp
                                            @if ($smallGroup->divisionId == $divisionId)
                                                <a
                                                    href="{{ route('division_details', $divIdEnc) }}">{{ $division->divisionName }}</a>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($getVillage as $village)
                                            @php
                                                $villageId = $village->id;
                                                $villageIdEnc = Crypt::encrypt($villageId);
                                            @endphp
                                            @if ($smallGroup->villageId == $villageId)
                                                <a
                                                    href="{{ route('village_details', $villageIdEnc) }}">{{ $village->villageName }}</a>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            $smallGroupId = $smallGroup->id;
                                            $smallgroupIdEnc = Crypt::encrypt($smallGroupId);
                                        @endphp
                                        <a
                                            href="{{ route('smallgroup_details', $smallgroupIdEnc) }}">{{ $smallGroup->smallGroupName }}</a>
                                    </td>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            if ($member->smallGroupId == $smallGroup->id) {
                                                $i++;
                                            }
                                        @endphp
                                    @endforeach
                                    <td>@php
                                        if ($i == 0) {
                                            echo '0';
                                        } else {
                                            echo $i;
                                        }
                                    @endphp</td>
                                    {{-- TOTAL SAVIGNS --}}
                                    @php
                                        $totalSav = 0;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            if ($member->smallGroupId == $smallGroup->id) {
                                                foreach ($getSavingData as $sav) {
                                                    if ($sav->memberId == $member->uniqueId) {
                                                        $totalSav += $sav->totalAmount;
                                                    }
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    <td>@php
                                        if ($totalSav == 0) {
                                            echo '0';
                                        } else {
                                            echo number_format($totalSav, 2);
                                        }
                                    @endphp</td>
                                    {{-- TOTAL SAVIGNS --}}
                                    {{-- TOTAL LOAN --}}
                                    @php
                                        $totalLoan = 0;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            if ($member->smallGroupId == $smallGroup->id) {
                                                foreach ($getLoansData as $loan) {
                                                    if ($loan->memberId == $member->id) {
                                                        $totalLoan++;
                                                    }
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    <td>@php
                                        if ($totalLoan == 0) {
                                            echo '0';
                                        } else {
                                            echo $totalLoan;
                                        }
                                    @endphp</td>
                                    {{-- TOTAL LOAN --}}
                                    @php
                                        $loanCap = 0;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            if ($member->smallGroupId == $smallGroup->id) {
                                                foreach ($getLoansData as $loan) {
                                                    if ($loan->memberId == $member->id) {
                                                        $loanCap += $loan->principal;
                                                    }
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    <td>@php
                                        if ($loanCap == 0) {
                                            echo '0';
                                        } else {
                                            echo number_format($loanCap, 2);
                                        }
                                    @endphp</td>
                                    {{-- TOTAL ACTIVE LOAN --}}
                                    @php
                                        $totalLoanActive = 0;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            if ($member->smallGroupId == $smallGroup->id) {
                                                foreach ($getLoansData as $loan) {
                                                    if (
                                                        $loan->memberId == $member->id &&
                                                        $loan->loanStatus == 'Active'
                                                    ) {
                                                        $totalLoanActive++;
                                                    }
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    <td>@php
                                        if ($totalLoanActive == 0) {
                                            echo '0';
                                        } else {
                                            echo $totalLoanActive;
                                        }
                                    @endphp</td>
                                    {{-- TOTAL ACTIVE LOAN --}}
                                    {{-- TOTAL ACTIVE LOAN Amount --}}
                                    @php
                                        $totalLoanActiveAm = 0;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            if ($member->smallGroupId == $smallGroup->id) {
                                                foreach ($getLoansData as $loan) {
                                                    if (
                                                        $loan->memberId == $member->id &&
                                                        $loan->loanStatus == 'Active'
                                                    ) {
                                                        $totalLoanActiveAm += $loan->principal;
                                                    }
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    <td>@php
                                        if ($totalLoanActiveAm == 0) {
                                            echo '0';
                                        } else {
                                            echo number_format($totalLoanActiveAm, 2);
                                        }
                                    @endphp</td>
                                    {{-- TOTAL ACTIVE LOAN Amount --}}
                                    @php
                                        $totalInterest = 0;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            if ($member->smallGroupId == $smallGroup->id) {
                                                foreach ($getLoansData as $loan) {
                                                    if ($loan->memberId == $member->id) {
                                                        foreach ($getLoanRepaymentData as $repayment) {
                                                            if ($loan->id == $repayment->loanId) {
                                                                $totalInterest += $repayment->interestPayment;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    <td>@php
                                        if ($totalInterest == 0) {
                                            echo '0';
                                        } else {
                                            echo number_format($totalInterest, 2);
                                        }
                                    @endphp</td>
                                    {{-- TOTAL CAPITAL COLLECTION --}}
                                    @php
                                        $totalcAPITALcollection = 0;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            if ($member->smallGroupId == $smallGroup->id) {
                                                foreach ($getRepaymentData as $reepayment) {
                                                    if ($reepayment->memberId == $member->id) {
                                                        $totalcAPITALcollection += $reepayment->principalAmount;
                                                    }
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    <td>@php
                                        if ($totalcAPITALcollection == 0) {
                                            echo '0';
                                        } else {
                                            echo number_format($totalcAPITALcollection, 2);
                                        }
                                    @endphp</td>
                                    {{-- TOTAL CAPITAL COLLECTION --}}

                                    {{-- TOTAL Interest COLLECTION --}}
                                    @php
                                        $totalInterestcollection = 0;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            if ($member->smallGroupId == $smallGroup->id) {
                                                foreach ($getRepaymentData as $reepayment) {
                                                    if ($reepayment->memberId == $member->id) {
                                                        $totalInterestcollection += $reepayment->interest;
                                                    }
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    <td>@php
                                        if ($totalInterestcollection == 0) {
                                            echo '0';
                                        } else {
                                            echo number_format($totalInterestcollection, 2);
                                        }
                                    @endphp</td>
                                    {{-- TOTAL Interest COLLECTION --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
