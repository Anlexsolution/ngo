<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>Group Leader Report
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm datatableView">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Division</th>
                                    <th>Division Head</th>
                                    <th>Village</th>
                                    <th>Village Leader</th>
                                    <th>SmallGroup</th>
                                    <th>SmallGroup Leader</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                    $shownVillageIds = [];
                                @endphp

                                {{-- Loop through Small Groups --}}
                                @foreach ($getSmallGroup as $smallGroup)
                                    <tr>
                                        <td>{{ $i++ }}</td>

                                        {{-- Division --}}
                                        <td>
                                            @php
                                                $division = $getDivision->firstWhere('id', $smallGroup->divisionId);
                                                $divIdEnc = Crypt::encrypt($division->id);
                                            @endphp
                                            <a href="{{ route('division_details', $divIdEnc) }}">{{ $division->divisionName }}</a>
                                        </td>

                                        {{-- Division Head --}}
                                        <td>
                                            @php
                                                $divisionDetail = $getDivisionDetails->firstWhere('divisionId', $smallGroup->divisionId);
                                                $divisionHead = $getAllMemberData->firstWhere('id', $divisionDetail->divisionHead ?? null);
                                            @endphp
                                            {{ $divisionHead->firstName ?? '-'  }}  {{ $divisionHead->lastName ?? '-'  }} 
                                        </td>

                                        {{-- Village --}}
                                        <td>
                                            @php
                                                $village = $getVillage->firstWhere('id', $smallGroup->villageId);
                                                $villageIdEnc = Crypt::encrypt($village->id);
                                                $shownVillageIds[] = $village->id; // Mark as shown
                                            @endphp
                                            <a href="{{ route('village_details', $villageIdEnc) }}">{{ $village->villageName }}</a>
                                        </td>

                                        {{-- Village Leader --}}
                                        <td>
                                            @php
                                                $villageDetail = $getVillageDetails->firstWhere('villageId', $village->id);
                                                $villageLeader = $getAllMemberData->firstWhere('id', $villageDetail->villageLeader ?? null);
                                            @endphp
                                            {{ $villageLeader->firstName ?? '-'  }}  {{ $villageLeader->lastName ?? '-'  }} 
                                        </td>

                                        {{-- Small Group --}}
                                        <td>
                                            @php
                                                $smallgroupIdEnc = Crypt::encrypt($smallGroup->id);
                                            @endphp
                                            <a href="{{ route('smallgroup_details', $smallgroupIdEnc) }}">{{ $smallGroup->smallGroupName }}</a>
                                        </td>

                                        {{-- Small Group Leader --}}
                                        <td>
                                            @php
                                                $sgDetail = $getSmallGroupDetails->firstWhere('smallgroupId', $smallGroup->id);
                                                $groupLeader = $getAllMemberData->firstWhere('id', $sgDetail->groupLeader ?? null);
                                            @endphp
                                            {{ $groupLeader->firstName ?? '-'  }}  {{ $groupLeader->lastName ?? '-'  }} 
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- Loop through Villages not already shown --}}
                                @foreach ($getVillage as $village)
                                    @continue(in_array($village->id, $shownVillageIds)) {{-- Skip if already shown --}}
                                    <tr>
                                        <td>{{ $i++ }}</td>

                                        {{-- Division --}}
                                        <td>
                                            @php
                                                $division = $getDivision->firstWhere('id', $village->divisionId);
                                                $divIdEnc = Crypt::encrypt($division->id);
                                            @endphp
                                            <a href="{{ route('division_details', $divIdEnc) }}">{{ $division->divisionName }}</a>
                                        </td>

                                        {{-- Division Head --}}
                                        <td>
                                            @php
                                                $divisionDetail = $getDivisionDetails->firstWhere('divisionId', $village->divisionId);
                                                $divisionHead = $getAllMemberData->firstWhere('id', $divisionDetail->divisionHead ?? null);
                                            @endphp
                                            {{ $divisionHead->firstName ?? '-'  }}  {{ $divisionHead->lastName ?? '-'  }} 
                                        </td>

                                        {{-- Village --}}
                                        <td>
                                            @php
                                                $villageIdEnc = Crypt::encrypt($village->id);
                                            @endphp
                                            <a href="{{ route('village_details', $villageIdEnc) }}">{{ $village->villageName }}</a>
                                        </td>

                                        {{-- Village Leader --}}
                                        <td>
                                            @php
                                                $villageDetail = $getVillageDetails->firstWhere('villageId', $village->id);
                                                $villageLeader = $getAllMemberData->firstWhere('id', $villageDetail->villageLeader ?? null);
                                            @endphp
                                            {{ $villageLeader->firstName ?? '-'  }}  {{ $villageLeader->lastName ?? '-'  }} 
                                        </td>

                                        {{-- Small Group & Leader --}}
                                        <td>-</td>
                                        <td>-</td>
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
