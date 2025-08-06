<div class="row mt-3">
   
    <div class="col-12 d-flex justify-content-center">
        <h5 class="text-center text-uppercase">Member Information</h5>
    </div>
    <hr>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Member Name</label>
            <p>{{ $getMember->firstName }} {{ $getMember->lastName }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Member NIC</label>
            <p>{{ $getMember->nicNumber }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Member Profession</label>
            <p>{{ $getMember->profession }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Member Gender</label>
            <p>{{ $getMember->gender }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Member New Account Number</label>
            <p>{{ $getMember->newAccountNumber }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Member Old Account Number</label>
            <p>{{ $getMember->oldAccountNumber }}</p>
        </div>
    </div>
     <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Member Division</label>
            <p>{{ $getMember->division->divisionName }}</p>
        </div>
    </div>
     <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Member Village</label>
            <p>@if ($getMember->village != null)
                {{ $getMember->village->villageName }}
            @endif</p>
        </div>
    </div>
     <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Member Small Group</label>
            <p>@if ($getMember->smallgroup != null)
                {{ $getMember->smallgroup->smallGroupName }}
            @endif</p>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center mt-3">
        <h5 class="text-center text-uppercase">Loan Information</h5>
    </div>
    <hr>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Loan Id</label>
            <p>{{ $loanDetails->loanId }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Loan Amount</label>
            <p>{{ number_format($loanDetails->principal, 2) }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Loan Term</label>
            <p>{{ $loanDetails->loanterm }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">First RepaymentDate</label>
            <p>{{ $loanDetails->firstRepaymentDate }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Interest Rate</label>
            <p>{{ $loanDetails->interestRate }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Repayment Period</label>
            <p>{{ $loanDetails->repaymentPeriod }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Interest type</label>
            <p>{{ $loanDetails->interestType }}</p>
        </div>
    </div>
    <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Loan Officer</label>
            <p>{{ $getLoanOfficer->name }}</p>
        </div>
    </div>
     <div class="col-6 mt-2">
        <div class="form-group">
            <label class="fw-bold">Cheque No</label>
            <p>{{ $loanDetails->checkNo ?? "-" }}</p>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center">
        <h5 class="text-center text-uppercase">Loan Approval Information</h5>
    </div>
    <hr>

    @foreach ($getLoanApproval as $approval)
        <div class="col-6 mt-2">
            <div class="form-group">
                <label class="fw-bold">{{ $approval->approvalType }}</label>
                <p>
                    @foreach ($getAllUser as $user)
                        @if ($user->id == $approval->userId)
                            {{ $user->name }}
                        @endif
                    @endforeach
                </p>
                <p>
                    {{ $approval->reason }}
                </p>
            </div>
        </div>
    @endforeach

</div>
