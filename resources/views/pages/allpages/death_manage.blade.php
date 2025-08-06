<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-group"></i> Manage Death Subscription
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>NIC number</th>
                                        <th>Division</th>
                                        <th>Village</th>
                                        <th>Small Group</th>
                                        <th>Profession</th>
                                        <th>Old Account Number</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getSavings as $savings)
                                        @php
                                            $encryptedId = encrypt($savings->deathId);
                                        @endphp
                                        @if (auth()->user()->userType == 'superAdmin')
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td> <a href="{{ route('view_death_history', $encryptedId) }}">
                                                        {{ $savings->deathId ?? 'N/A' }}
                                                    </a></td>
                                                <td>{{ $savings->member->firstName ?? 'N/A' }}</td>
                                                <td>{{ $savings->member->nicNumber ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($savings->member->divisionId == '')
                                                        -
                                                    @else
                                                        {{ $savings->member->division->divisionName }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($savings->member->villageId == '')
                                                        -
                                                    @else
                                                        {{ $savings->member->village->villageName }}
                                                    @endif
                                                </td>
                                                @if ($savings->member->smallGroupId == '')
                                                    <td>-</td>
                                                @else
                                                    <td>{{ $savings->member->smallgroup->smallGroupName }}</td>
                                                @endif
                                                <td>{{ $savings->member->profession }}</td>
                                                <td>{{ $savings->member->oldAccountNumber }}</td>

                                                <td>{{ $savings->totalAmount ?? 'N/A' }}</td>

                                            </tr>
                                        @else
                                        @php
                                                $divArray = auth()->user()->division;
                                                $vilArray = auth()->user()->village;
                                            @endphp
                                            @if ($divArray != '' || $divArray != null || $vilArray != '' || $vilArray != null)
                                                @if (in_array($savings->member->divisionId, json_decode(auth()->user()->division)) &&
                                                        in_array($savings->member->villageId, json_decode(auth()->user()->village)))
                                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td> <a href="{{ route('view_death_history', $encryptedId) }}">
                                                        {{ $savings->deathId ?? 'N/A' }}
                                                    </a></td>
                                                <td>{{ $savings->member->firstName ?? 'N/A' }}</td>
                                                <td>{{ $savings->member->nicNumber ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($savings->member->divisionId == '')
                                                        -
                                                    @else
                                                        {{ $savings->member->division->divisionName }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($savings->member->villageId == '')
                                                        -
                                                    @else
                                                        {{ $savings->member->village->villageName }}
                                                    @endif
                                                </td>
                                                @if ($savings->member->smallGroupId == '')
                                                    <td>-</td>
                                                @else
                                                    <td>{{ $savings->member->smallgroup->smallGroupName }}</td>
                                                @endif
                                                <td>{{ $savings->member->profession }}</td>
                                                <td>{{ $savings->member->oldAccountNumber }}</td>

                                                <td>{{ $savings->totalAmount ?? 'N/A' }}</td>

                                            </tr>
                                                @endif
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
</div>
