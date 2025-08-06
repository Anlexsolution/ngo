<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-group"></i> Opening balance report
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col d-flex justify-content-end">
                                <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample"
                                    role="button" aria-expanded="false" aria-controls="collapseExample">

                                    <i class="ti ti-filter-pause"></i> Filter
                                </a>
                            </div>
                            <div class="collapse mt-3" id="collapseExample">
                                <div class="card card-body">
                                    <div class="col-md-3 me-2">
                                        <div class="form-group">
                                            <label for="divisionId" class="form-label fw-bold">Select Division</label>
                                            <select name="divisionId" id="divisionId" class="selectize">
                                                <option value="">Select Division</option>
                                                @foreach ($getDivision as $division)
                                                    <option value="{{ $division->divisionName }}">
                                                        {{ $division->divisionName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <table class="table table-sm" id="tableOpeningBalance">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>NIC number</th>
                                        <th>Division</th>
                                        <th>Village</th>
                                        <th>Small Group</th>
                                        <th>Profession</th>
                                        <th>Old Account Number</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getMember as $member)
                                        @php
                                            $encryptedId = encrypt($member->id);
                                        @endphp
                                        @if (auth()->user()->userType == 'superAdmin')
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td> <a href="{{ route('view_member', $encryptedId) }}">
                                                        {{ $member->firstName }}</a></td>
                                                <td>{{ $member->nicNumber }}</td>
                                                <td>
                                                    @if ($member->divisionId == '')
                                                        -
                                                    @else
                                                        {{ $member->division->divisionName }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($member->villageId == '')
                                                        -
                                                    @else
                                                        {{ $member->village->villageName }}
                                                    @endif
                                                </td>
                                                @if ($member->smallGroupId == '')
                                                    <td>-</td>
                                                @else
                                                    <td>{{ $member->smallgroup->smallGroupName }}</td>
                                                @endif
                                                <td>{{ $member->profession }}</td>
                                                <td>{{ $member->oldAccountNumber }}</td>
                                                <td>
                                                    @foreach ($getsavings as $sav)
                                                        @if ($sav->memberId == $member->uniqueId)
                                                            {{ $sav->totalAmount }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @else
                                            @php
                                                $divArray = auth()->user()->division;
                                                $vilArray = auth()->user()->village;
                                            @endphp
                                            @if ($divArray != '' || $divArray != null || $vilArray != '' || $vilArray != null)
                                                @if (in_array($member->divisionId, json_decode(auth()->user()->division)) ||
                                                        in_array($member->villageId, json_decode(auth()->user()->village)))
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>
                                                            @if ($userType != 'superAdmin')
                                                                @if (in_array('viewMember', $usersDataPer))
                                                                    <a href="{{ route('view_member', $encryptedId) }}">
                                                                        {{ $member->firstName }}</a>
                                                                @else
                                                                    {{ $member->firstName }}
                                                                @endif
                                                            @else
                                                                <a href="{{ route('view_member', $encryptedId) }}">
                                                                    {{ $member->firstName }}</a>
                                                            @endif
                                                        </td>
                                                        <td>{{ $member->nicNumber }}</td>
                                                        <td>{{ empty($member->division->divisionName) ? 'N/A' : $member->division->divisionName }}</td>
                                                        <td>{{ empty($member->village->villageName) ? 'N/A' : $member->village->villageName }}</td>
                                                        @if ($member->smallGroupId == '')
                                                            <td>-</td>
                                                        @else
                                                            <td>{{ $member->smallgroup->smallGroupName }}</td>
                                                        @endif
                                                        <td>{{ $member->profession }}</td>
                                                        <td>{{ $member->oldAccountNumber }}</td>
                                                        <td>
                                                            @foreach ($getsavings as $sav)
                                                                @if ($sav->memberId == $member->uniqueId)
                                                                    {{ $sav->totalAmount }}
                                                                @endif
                                                            @endforeach
                                                        </td>
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