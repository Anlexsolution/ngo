<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>Create Meeting
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-3" style="width: 100%">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Meeting Title</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Resource Person</th>
                                        <th>Meeting Type</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($meetingData as $meeting)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td> <a href="{{ route('view_meetings', $meeting->id) }}">{{ $meeting->meeting_title }}</a> </td>
                                            <td>{{ $meeting->meeting_date }}</td>
                                            <td>  {{ \Carbon\Carbon::parse($meeting->meeting_time)->format('h:i A') }}</td>
                                            <td>{{ $meeting->resource_person }}</td>
                                            <td>{{ $meeting->meeting_type }}</td>
                                            <td>  <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">
                                                Edit</a>
                                        </div>
                                    </div></td>
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
