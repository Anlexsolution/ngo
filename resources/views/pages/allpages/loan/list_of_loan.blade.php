<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-list"></i> Manage Loan
                        </div>
                        <div class="col-6 d-flex justify-content-end">

                            @if ($userType == 'superAdmin')
                                <a href="/create_old_loan">
                                    <button class="btn btn-success btn-sm me-2"><i
                                            class="menu-icon ti ti-circle-plus"></i>
                                        Create Old Loan</button>
                                </a>
                                <a href="/create_loan">
                                    <button class="btn btn-success btn-sm"><i class="menu-icon ti ti-circle-plus"></i>
                                        Create New Loan</button>
                                </a>
                            @else
                                @php
                                    $userRolesArray = $getUserRole->pluck('roleName')->toArray();
                                @endphp

                                @if (in_array($userType, $userRolesArray))
                                    @php
                                        $usersDataPer = $permissions;
                                        $usersDataPer = json_decode($usersDataPer, true);
                                    @endphp

                                    @if (in_array('addOldLoan', $usersDataPer))
                                        <a href="/create_old_loan">
                                            <button class="btn btn-success btn-sm me-2"><i
                                                    class="menu-icon ti ti-circle-plus"></i>
                                                Create Old Loan</button>
                                    @endif
                                    @if (in_array('addLoan', $usersDataPer))
                                        <a href="/create_loan">
                                            <button class="btn btn-success btn-sm"><i
                                                    class="menu-icon ti ti-circle-plus"></i>
                                                Create New Loan</button>
                                        </a>
                                    @endif
                                @endif
                            @endif


                        </div>
                    </div>

                    <div class="card-body">
                        <br>
                        <a href="{{ route('view_pdf_loan') }}" class="mt-3" target="_blank">
                            <button class="btn btn-secondary ">
                                PDF
                            </button>
                        </a>

                        <table class="table table-sm " id="loanTableView">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Loan Id</th>
                                    <th>Member Name</th>
                                    <th>Product Name</th>
                                    <th>Division</th>
                                    <th>Village</th>
                                    <th>SmallGroup</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($getData as $data)
                                    @php
                                        $loanEncId = Crypt::encrypt($data->id);
                                    @endphp
                                    @if (auth()->user()->userType == 'superAdmin')
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td> <a
                                                    href="{{ route('view_loan_details', $loanEncId) }}">{{ $data->loanId }}</a>
                                            </td>
                                            <td>
                                                @foreach ($getMember as $mem)
                                                    @if ($mem->id == $data->memberId)
                                                        {{ $mem->firstName }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getproduct as $pro)
                                                    @if ($pro->id == $data->loanProductId)
                                                        {{ $pro->productName }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getMember as $mem)
                                                    @if ($mem->id == $data->memberId)
                                                        @php
                                                            $divIdEnc = Crypt::encrypt($mem->divisionId);
                                                        @endphp
                                                        <a href="{{ route('division_details', $divIdEnc) }}">
                                                            {{ $mem->division->divisionName }} </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getMember as $mem)
                                                    @if ($mem->id == $data->memberId)
                                                        @php
                                                            $villageIdEnc = Crypt::encrypt($mem->villageId);
                                                        @endphp
                                                        <a href="{{ route('village_details', $villageIdEnc) }}">
                                                            {{ $mem->village->villageName }} </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getMember as $mem)
                                                    @if ($mem->id == $data->memberId)
                                                        @php
                                                            $smallgroupIdEnc = Crypt::encrypt($mem->smallGroupId);
                                                        @endphp
                                                        <a href="{{ route('smallgroup_details', $smallgroupIdEnc) }}">
                                                            {{ $mem->smallgroup->smallGroupName ?? null }} </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ number_format($data->principal, 2) }}</td>
                                            <td>
                                                @php
                                                    if ($data->loanStatus == 'Active') {
                                                        $statusClass = 'bg-success';
                                                    } elseif ($data->loanStatus == 'Rejected') {
                                                        $statusClass = 'bg-danger';
                                                    } else {
                                                        $statusClass = 'bg-primary';
                                                    }

                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ $data->loanStatus }}</span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('view_loan_details', $loanEncId) }}"><i
                                                                class="ti ti-eye me-1"></i> View</a>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="ti ti-pencil me-1"></i> Edit</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                     @php
                                            $divArray = auth()->user()->division;
                                            $vilArray = auth()->user()->village;
                                        @endphp
                                        @if ($divArray != '' || $divArray != null || $vilArray != '' || $vilArray != null)
                                            @foreach ($getAllMemberData as $getMem)
                                                @if ($getMem->id == $data->memberId)
                                                    @if (in_array($getMem->divisionId, json_decode(auth()->user()->division)) &&
                                                            in_array($getMem->villageId, json_decode(auth()->user()->village)))
                                                        <tr>
                                                            <td>{{ $count++ }}</td>
                                                            <td> <a
                                                                    href="{{ route('view_loan_details', $loanEncId) }}">{{ $data->loanId }}</a>
                                                            </td>
                                                            <td>
                                                                @foreach ($getMember as $mem)
                                                                    @if ($mem->id == $data->memberId)
                                                                        {{ $mem->firstName }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach ($getproduct as $pro)
                                                                    @if ($pro->id == $data->loanProductId)
                                                                        {{ $pro->productName }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach ($getMember as $mem)
                                                                    @if ($mem->id == $data->memberId)
                                                                        @php
                                                                            $divIdEnc = Crypt::encrypt(
                                                                                $mem->divisionId,
                                                                            );
                                                                        @endphp
                                                                        <a
                                                                            href="{{ route('division_details', $divIdEnc) }}">
                                                                            {{ $mem->division->divisionName }} </a>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach ($getMember as $mem)
                                                                    @if ($mem->id == $data->memberId)
                                                                        @php
                                                                            $villageIdEnc = Crypt::encrypt(
                                                                                $mem->villageId,
                                                                            );
                                                                        @endphp
                                                                        <a
                                                                            href="{{ route('village_details', $villageIdEnc) }}">
                                                                            {{ $mem->village->villageName }} </a>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach ($getMember as $mem)
                                                                    @if ($mem->id == $data->memberId)
                                                                        @php
                                                                            $smallgroupIdEnc = Crypt::encrypt(
                                                                                $mem->smallGroupId,
                                                                            );
                                                                        @endphp
                                                                        <a
                                                                            href="{{ route('smallgroup_details', $smallgroupIdEnc) }}">
                                                                            {{ $mem->smallgroup->smallGroupName ?? null }}
                                                                        </a>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ number_format($data->principal, 2) }}</td>
                                                            <td>
                                                                @php
                                                                    if ($data->loanStatus == 'Active') {
                                                                        $statusClass = 'bg-success';
                                                                    } elseif ($data->loanStatus == 'Rejected') {
                                                                        $statusClass = 'bg-danger';
                                                                    } else {
                                                                        $statusClass = 'bg-primary';
                                                                    }

                                                                @endphp
                                                                <span
                                                                    class="badge {{ $statusClass }}">{{ $data->loanStatus }}</span>
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button type="button"
                                                                        class="btn p-0 dropdown-toggle hide-arrow"
                                                                        data-bs-toggle="dropdown">
                                                                        <i class="ti ti-dots-vertical"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('view_loan_details', $loanEncId) }}"><i
                                                                                class="ti ti-eye me-1"></i> View</a>
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="ti ti-pencil me-1"></i> Edit</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
