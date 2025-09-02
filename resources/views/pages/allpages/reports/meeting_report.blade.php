<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>Meeting Report
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
                                    <th>Title</th>
                                    <th> Date</th>
                                    <th>Time</th>
                                    <th>Type</th>
                                    <th>Resource Person</th>
                                    <th>Position</th>
                                    <th>Contact No</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($getMeeting as $meeting)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $meeting->divisionName }}</td>
                                    <td>{{ $meeting->villageName }}</td>
                                    <td>{{ $meeting->smallGroupName }}</td>
                                    <td>{{ $meeting->meeting_title }}</td>
                                    <td>{{ $meeting->meeting_date }}</td>
                                    <td>{{ $meeting->meeting_time }}</td>
                                    <td>{{ $meeting->meeting_type }}</td>
                                    <td>{{ $meeting->full_name }}</td>
                                    <td>{{ $meeting->resource_position }}</td>
                                    <td>{{ $meeting->resource_contact_no }}</td>
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
