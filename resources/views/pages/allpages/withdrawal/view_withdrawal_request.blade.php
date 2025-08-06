@php
    use Carbon\Carbon;
    $converted = Carbon::parse($getWithdrawalData->created_at)->format('Y-m-d h:i:s A');
@endphp
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                <div class="col-4">
                    <i class="menu-icon ti ti-list"></i> View Withdrawal Approval
                </div>
            </div>
            <div class="card-body">
                <input type="hidden" id="txtWithId" value="{{ $withId }}">
                <div class="row mt-3">
                    @if ($getWithdrawalData->request == 0)
                        <div class="col-12 d-flex justify-content-center">
                            <h4>First Approve Withdrawal</h4>
                        </div>
                        <div class="col-4">
                            <label>Member</label>
                            @foreach ($getAllMemberData as $mem)
                                @if ($mem->uniqueId == $getWithdrawalData->memberId)
                                    <p>{{ $mem->firstName }} {{ $mem->lastName }}</p>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-4">
                            <label>Amount</label>
                            <p>{{ number_format($getWithdrawalData->amount, 2) }}</p>
                        </div>
                        <div class="col-4">
                            <label>Account Number</label>
                            <p>
                                @foreach ($getSavingData as $sav)
                                    @if ($sav->id == $getWithdrawalData->savingId)
                                        {{ $sav->savingsId }}
                                    @endif
                                @endforeach
                            </p>

                        </div>
                        <div class="col-4">
                            <label>Request Date</label>
                            <p>
                                {{ $converted }}
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Status</label>
                            <p>
                                <span class="badge bg-primary">Withdrawal Request</span>
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Requested By</label>
                            <p>
                                @foreach ($getAllUser as $user)
                                    @foreach ($getWithHisData as $withHis)
                                        @if ($withHis->userId == $user->id)
                                            {{ $user->name }}
                                        @endif
                                    @endforeach
                                @endforeach
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Approved /Rejected</label>
                            <select class="selectize" id="txtApproveStatusFirst">
                                <option value="1">Approved</option>
                                <option value="5">Rejected</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">2nd Approve User type</label>
                            <select class="selectize" id="txtSecondApproveUserType">
                                @foreach ($getUserRole as $userRole)
                                    <option value="{{ $userRole->id }}">{{ $userRole->roleName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">Reason</label>
                            <textarea class="form-control" id="txtReasonFirst"></textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-end mt-3">
                            <button class="btn btn-primary" id="btnApproveFirst">1st Approve</button>
                        </div>
                    @elseif ($getWithdrawalData->request == 1)
                        <div class="col-12 d-flex justify-content-center">
                            <h4>second Approve Withdrawal</h4>
                        </div>
                        <div class="col-4">
                            <label>Member</label>
                            @foreach ($getAllMemberData as $mem)
                                @if ($mem->uniqueId == $getWithdrawalData->memberId)
                                    <p>{{ $mem->firstName }} {{ $mem->lastName }}</p>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-4">
                            <label>Amount</label>
                            <p>{{ number_format($getWithdrawalData->amount, 2) }}</p>
                        </div>
                        <div class="col-4">
                            <label>Account Number</label>
                            <p>
                                @foreach ($getSavingData as $sav)
                                    @if ($sav->id == $getWithdrawalData->savingId)
                                        {{ $sav->savingsId }}
                                    @endif
                                @endforeach
                            </p>

                        </div>
                        <div class="col-4">
                            <label>Request Date</label>
                            <p>
                                {{ $converted }}
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Status</label>
                            <p>
                                <span class="badge bg-primary">{{ $getWithdrawalData->status }}</span>
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Requested By</label>
                            <p>
                                @foreach ($getAllUser as $user)
                                    @foreach ($getWithHisData as $withHis)
                                        @if ($withHis->userId == $user->id)
                                            @if ($withHis->request == 0)
                                                {{ $user->name }}
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">1st approved By</label>
                            <p>
                                @foreach ($getAllUser as $user)
                                    @foreach ($getWithHisData as $withHis)
                                        @if ($withHis->userId == $user->id)
                                            @if ($withHis->request == 1)
                                                {{ $user->name }}
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Approved /Rejected</label>
                            <select class="selectize" id="txtApproveStatusSecond">
                                <option value="2">Approved</option>
                                <option value="5">Rejected</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">3rd Approve User type</label>
                            <select class="selectize" id="txtThirdApproveUserType">
                                @foreach ($getUserRole as $userRole)
                                    <option value="{{ $userRole->id }}">{{ $userRole->roleName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">Reason</label>
                            <textarea class="form-control" id="txtReasonSecond"></textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-end mt-3">
                            <button class="btn btn-primary" id="btnApproveSecond">2nd Approve</button>
                        </div>
                        @elseif ($getWithdrawalData->request == 2)
                        <div class="col-12 d-flex justify-content-center">
                            <h4>Third Approve Withdrawal</h4>
                        </div>
                        <div class="col-4">
                            <label>Member</label>
                            @foreach ($getAllMemberData as $mem)
                                @if ($mem->uniqueId == $getWithdrawalData->memberId)
                                    <p>{{ $mem->firstName }} {{ $mem->lastName }}</p>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-4">
                            <label>Amount</label>
                            <p>{{ number_format($getWithdrawalData->amount, 2) }}</p>
                        </div>
                        <div class="col-4">
                            <label>Account Number</label>
                            <p>
                                @foreach ($getSavingData as $sav)
                                    @if ($sav->id == $getWithdrawalData->savingId)
                                        {{ $sav->savingsId }}
                                    @endif
                                @endforeach
                            </p>

                        </div>
                        <div class="col-4">
                            <label>Request Date</label>
                            <p>
                                {{ $converted }}
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Status</label>
                            <p>
                                <span class="badge bg-primary">{{ $getWithdrawalData->status }}</span>
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Requested By</label>
                            <p>
                                @foreach ($getAllUser as $user)
                                    @foreach ($getWithHisData as $withHis)
                                        @if ($withHis->userId == $user->id)
                                            @if ($withHis->request == 0)
                                                {{ $user->name }}
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">1st approved By</label>
                            <p>
                                @foreach ($getAllUser as $user)
                                    @foreach ($getWithHisData as $withHis)
                                        @if ($withHis->userId == $user->id)
                                            @if ($withHis->request == 1)
                                                {{ $user->name }}
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">2nd approved By</label>
                            <p>
                                @foreach ($getAllUser as $user)
                                    @foreach ($getWithHisData as $withHis)
                                        @if ($withHis->userId == $user->id)
                                            @if ($withHis->request == 2)
                                                {{ $user->name }}
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Approved /Rejected</label>
                            <select class="selectize" id="txtApproveStatusThird">
                                <option value="3">Approved</option>
                                <option value="5">Rejected</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">4th Approve User type</label>
                            <select class="selectize" id="txtForthApproveUserType">
                                @foreach ($getUserRole as $userRole)
                                    <option value="{{ $userRole->id }}">{{ $userRole->roleName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">Reason</label>
                            <textarea class="form-control" id="txtReasonThird"></textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-end mt-3">
                            <button class="btn btn-primary" id="btnApproveThird">3rd Approve</button>
                        </div>
                        @elseif ($getWithdrawalData->request == 3)
                        <div class="col-12 d-flex justify-content-center">
                            <h4>Forth Approve Withdrawal</h4>
                        </div>
                        <div class="col-4">
                            <label>Member</label>
                            @foreach ($getAllMemberData as $mem)
                                @if ($mem->uniqueId == $getWithdrawalData->memberId)
                                    <p>{{ $mem->firstName }} {{ $mem->lastName }}</p>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-4">
                            <label>Amount</label>
                            <p>{{ number_format($getWithdrawalData->amount, 2) }}</p>
                        </div>
                        <div class="col-4">
                            <label>Account Number</label>
                            <p>
                                @foreach ($getSavingData as $sav)
                                    @if ($sav->id == $getWithdrawalData->savingId)
                                        {{ $sav->savingsId }}
                                    @endif
                                @endforeach
                            </p>

                        </div>
                        <div class="col-4">
                            <label>Request Date</label>
                            <p>
                                {{ $converted }}
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Status</label>
                            <p>
                                <span class="badge bg-primary">{{ $getWithdrawalData->status }}</span>
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Requested By</label>
                            <p>
                                @foreach ($getAllUser as $user)
                                    @foreach ($getWithHisData as $withHis)
                                        @if ($withHis->userId == $user->id)
                                            @if ($withHis->request == 0)
                                                {{ $user->name }}
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">1st approved By</label>
                            <p>
                                @foreach ($getAllUser as $user)
                                    @foreach ($getWithHisData as $withHis)
                                        @if ($withHis->userId == $user->id)
                                            @if ($withHis->request == 1)
                                                {{ $user->name }}
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">2nd approved By</label>
                            <p>
                                @foreach ($getAllUser as $user)
                                    @foreach ($getWithHisData as $withHis)
                                        @if ($withHis->userId == $user->id)
                                            @if ($withHis->request == 2)
                                                {{ $user->name }}
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">3rd approved By</label>
                            <p>
                                @foreach ($getAllUser as $user)
                                    @foreach ($getWithHisData as $withHis)
                                        @if ($withHis->userId == $user->id)
                                            @if ($withHis->request == 3)
                                                {{ $user->name }}
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </p>
                        </div>
                        <div class="col-4">
                            <label for="">Approved /Rejected</label>
                            <select class="selectize" id="txtApproveStatusForth">
                                <option value="4">Approved</option>
                                <option value="5">Rejected</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">Withdrawal Account</label>
                            <select class="selectize" id="txtWithAccount">
                                @foreach ($getAccountData as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }}  ({{number_format($account->balance, 2)}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">Reason</label>
                            <textarea class="form-control" id="txtReasonForth"></textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-end mt-3">
                            <button class="btn btn-primary" id="btnApproveForth">Withdrawal</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
