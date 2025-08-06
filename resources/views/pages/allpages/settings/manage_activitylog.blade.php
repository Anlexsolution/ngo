<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Manage Login Activity Log
                    </div>
                    <div class="card-body">
                        <table class="table table-sm datatableView">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>user name</th>
                                    <th>user Email</th>
                                    <th>Location</th>
                                    <th>Country</th>
                                    <th>IP Address</th>
                                    <th>Login Time</th>
                                    <th>Logout Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                    use Carbon\Carbon;
                                @endphp
                                @foreach ($manageLoginActivity as $logActi)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$logActi->name}}</td>
                                        <td>{{$logActi->email}}</td>
                                        <td>{{$logActi->location}}</td>
                                        <td>{{$logActi->country}}</td>
                                        <td>{{$logActi->ipAddress}}</td>
                                        <td>{{ Carbon::parse($logActi->loginTime)->format('Y-m-d h:i:s A') }}</td>
                                        <td>{{ Carbon::parse($logActi->logoutTime)->format('Y-m-d h:i:s A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Manage system Activity Log
                    </div>
                    <div class="card-body">
                        <table class="table table-sm datatableView">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date Time</th>
                                    <th>user name</th>
                                    <th>user Email</th>
                                    <th>Location</th>
                                    <th>Country</th>
                                    <th>IP Address</th>
                                    <th>Status</th>
                                    <th>Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $count = 1;
                            @endphp
                            
                            @foreach ($systemActivityLog as $logActi)
                                @php
                                    $user = $userData->firstWhere('id', $logActi->userId);
                                    $userName = $user ? $user->name : '-';
                                    $userEmail = $user ? $user->email : '-';
                                @endphp
                                <tr>
                                    <td>{{ $logActi->created_at->format('d/m/Y h:i:s A') }}</td>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $userName }}</td>
                                    <td>{{ $userEmail }}</td>
                                    <td>{{ $logActi->location }}</td>
                                    <td>{{ $logActi->country }}</td>
                                    <td>{{ $logActi->ipAddress }}</td>
                                    <td>
                                        <span class="badge {{ $logActi->className }}">{{ $logActi->type }}</span>
                                    </td>
                                    <td>{{ $logActi->activity }}</td>
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