@php
    use Carbon\Carbon;
@endphp
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-group"></i> Withdrawal Report
                    </div>
                    <div class="card-body">


                        <div class="row mt-3">
                            <table class="table table-sm" id="tableWithApproveTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Member</th>
                                        <th>Withdrawal Id</th>
                                        <th>Approve User</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getWithdrawalData as $withdrawal)
                                        @php
                                            $cryptId = Crypt::encrypt($withdrawal->id);
                                            $formatted = Carbon::parse($withdrawal->created_at)->format('Y-m-d h:i:s A');
                                        @endphp
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{$formatted}}</td>
                                            <td>
                                                @foreach ($getAllMemberData as $mem)
                                                    @if ($mem->uniqueId == $withdrawal->memberId)
                                                        {{ $mem->firstName }} {{ $mem->lastName }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $withdrawal->withdrawalId }}</td>
                                            <td>
                                                @foreach ($getAllUser as $user)
                                                    @if ($user->id == $withdrawal->userId)
                                                        {{ $user->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ number_format($withdrawal->amount, 2) }}</td>
                                            <td>
                                                @if ($withdrawal->request == 0)
                                                    <span class="badge bg-warning">{{ $withdrawal->status }}</span>
                                                @elseif($withdrawal->request == 1)
                                                    <span class="badge bg-success">{{ $withdrawal->status }}</span>
                                                @elseif($withdrawal->request == 2)
                                                    <span class="badge bg-success">{{ $withdrawal->status }}</span>
                                                @elseif($withdrawal->request == 3)
                                                    <span class="badge bg-success">{{ $withdrawal->status }}</span>
                                                @elseif($withdrawal->request == 4)
                                                    <span class="badge bg-success">{{ $withdrawal->status }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $withdrawal->status }}</span>
                                                @endif

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
</div>
