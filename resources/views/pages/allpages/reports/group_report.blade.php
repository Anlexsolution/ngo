<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>Group Report
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm datatableView">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Division</th>
                                    <th>Village</th>
                                    <th>Small Group</th>
                                    <th>No of Members</th>
                                    <th>Total Savings</th>
                                    <th>Total Death Subscription</th>
                                    <th>Total Death Donation</th>
                                    <th>Total Other Income</th>
                                    <th>Loan Capital</th>
                                    <th>Entry Fees</th>
                                    <th>Total Interest</th>
                                    <th>Grand Total</th>
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
                                        @php
                                            $totalDeathSub = 0;
                                        @endphp
                                        @foreach ($getMember as $member)
                                            @php
                                                if ($member->smallGroupId == $smallGroup->id) {
                                                    foreach ($getDeathSubscription as $deathSub) {
                                                        if ($deathSub->memberId == $member->uniqueId) {
                                                            $totalDeathSub += $deathSub->totalAmount;
                                                        }
                                                    }
                                                }
                                            @endphp
                                        @endforeach
                                        <td>@php
                                            if ($totalDeathSub == 0) {
                                                echo '0';
                                            } else {
                                                echo number_format($totalDeathSub, 2);
                                            }
                                        @endphp</td>
                                          @php
                                            $totalDeathDonation = 0;
                                        @endphp
                                        @foreach ($getMember as $member)
                                            @php
                                                if ($member->smallGroupId == $smallGroup->id) {
                                                    foreach ($getDeathDonation as $deathDonation) {
                                                        if ($deathDonation->memberId == $member->id) {
                                                            $totalDeathDonation += 10000;
                                                        }
                                                    }
                                                }
                                            @endphp
                                        @endforeach
                                        <td>@php
                                            if ($totalDeathDonation == 0) {
                                                echo '0';
                                            } else {
                                                echo number_format($totalDeathDonation, 2);
                                            }
                                        @endphp</td>
                                          @php
                                            $totalOtherIncome = 0;
                                        @endphp
                                        @foreach ($getMember as $member)
                                            @php
                                                if ($member->smallGroupId == $smallGroup->id) {
                                                    foreach ($getOtherIncome as $otherIncome) {
                                                        if ($otherIncome->memberId == $member->uniqueId) {
                                                            $totalOtherIncome += $otherIncome->totalAmount;
                                                        }
                                                    }
                                                }
                                            @endphp
                                        @endforeach
                                        <td>@php
                                            if ($totalOtherIncome == 0) {
                                                echo '0';
                                            } else {
                                                echo number_format($totalOtherIncome, 2);
                                            }
                                        @endphp</td>
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
                                        <td>-</td>
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
                                        <td>
                                            @php
                                                $total = $loanCap + $totalSav + $totalInterest;
                                            @endphp
                                            @php
                                                if ($total == 0) {
                                                    echo '0';
                                                } else {
                                                    echo number_format($total, 2);
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($getVillage as $village)
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
                                                @if ($village->divisionId == $divisionId)
                                                    <a
                                                        href="{{ route('division_details', $divIdEnc) }}">{{ $division->divisionName }}</a>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                                $villageId = $village->id;
                                                $villageIdEnc = Crypt::encrypt($villageId);
                                            @endphp
                                            <a
                                                href="{{ route('village_details', $villageIdEnc) }}">{{ $village->villageName }}</a>
                                        </td>
                                        <td>-</td>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($getMember as $member)
                                            @php
                                                if ($member->smallGroupStatus == 'No') {
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
                                        @php
                                            $totalSav = 0;
                                        @endphp
                                        @foreach ($getMember as $member)
                                            @php
                                                if ($member->smallGroupStatus == 'No') {
                                                    if ($member->villageId == $village->id) {
                                                        foreach ($getSavingData as $sav) {
                                                            if ($sav->memberId == $member->uniqueId) {
                                                                $totalSav += $sav->totalAmount;
                                                            }
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
                                        @php
                                            $totalDeathSub = 0;
                                        @endphp
                                        @foreach ($getMember as $member)
                                            @php
                                                if ($member->smallGroupStatus == 'No') {
                                                    if ($member->villageId == $village->id) {
                                                        foreach ($getDeathSubscription as $deathSub) {
                                                            if ($deathSub->memberId == $member->uniqueId) {
                                                                $totalDeathSub += $deathSub->totalAmount;
                                                            }
                                                        }
                                                    }
                                                }
                                            @endphp
                                        @endforeach
                                        <td>@php
                                            if ($totalDeathSub == 0) {
                                                echo '0';
                                            } else {
                                                echo number_format($totalDeathSub, 2);
                                            }
                                        @endphp</td>
                                          @php
                                            $totalDeathDonation = 0;
                                        @endphp
                                        @foreach ($getMember as $member)
                                            @php
                                                if ($member->smallGroupStatus == 'No') {
                                                    if ($member->villageId == $village->id) {
                                                        foreach ($getDeathDonation as $deathDonation) {
                                                            if ($deathDonation->memberId == $member->id) {
                                                                $totalDeathDonation += 10000;
                                                            }
                                                        }
                                                    }
                                                }
                                            @endphp
                                        @endforeach
                                        <td>@php
                                            if ($totalDeathDonation == 0) {
                                                echo '0';
                                            } else {
                                                echo number_format($totalDeathDonation, 2);
                                            }
                                        @endphp</td>
                                                @php
                                            $totalOtherIncome = 0;
                                        @endphp
                                        @foreach ($getMember as $member)
                                            @php
                                                if ($member->smallGroupStatus == 'No') {
                                                    if ($member->villageId == $village->id) {
                                                        foreach ($getOtherIncome as $otherrIncome) {
                                                            if ($otherrIncome->memberId == $member->uniqueId) {
                                                                $totalOtherIncome += $otherrIncome->totalAmount;
                                                            }
                                                        }
                                                    }
                                                }
                                            @endphp
                                        @endforeach
                                        <td>@php
                                            if ($totalOtherIncome == 0) {
                                                echo '0';
                                            } else {
                                                echo number_format($totalOtherIncome, 2);
                                            }
                                        @endphp</td>
                                        @php
                                            $loanCap = 0;
                                        @endphp
                                        @foreach ($getMember as $member)
                                            @php
                                                if ($member->smallGroupStatus == 'No') {
                                                    if ($member->villageId == $village->id) {
                                                        foreach ($getLoansData as $loan) {
                                                            if ($loan->memberId == $member->id) {
                                                                $loanCap += $loan->principal;
                                                            }
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
                                        <td>-</td>

                                        @php
                                            $totalInterest = 0;
                                        @endphp
                                        @foreach ($getMember as $member)
                                            @php
                                                if ($member->smallGroupStatus == 'No') {
                                                    if ($member->villageId == $village->id) {
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
                                        <td>
                                            @php
                                                $total = $loanCap + $totalSav + $totalInterest;
                                            @endphp
                                            @php
                                                if ($total == 0) {
                                                    echo '0';
                                                } else {
                                                    echo number_format($total, 2);
                                                }
                                            @endphp
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
