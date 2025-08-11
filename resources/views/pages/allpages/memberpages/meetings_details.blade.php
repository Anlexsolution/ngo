<div class="row mt-3">
<div class="container my-4">

    {{-- Meeting Cards --}}
    @foreach($meetings as $meeting)
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 text-white">{{ $meeting->meeting_title }}</h5>
                <small>
                    {{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d M Y') }} |
                    {{ \Carbon\Carbon::parse($meeting->meeting_time)->format('h:i A') }} -
                    {{ \Carbon\Carbon::parse($meeting->meeting_end_time)->format('h:i A') }}
                </small>
            </div>
            <div class="card-body">
                <p><strong>Type:</strong> {{ ucfirst($meeting->meeting_type) }}</p>
                <p><strong>Resource Person:</strong> {{ $meeting->resource_person }} ({{ $meeting->resource_position }})</p>
                <p><strong>Contact:</strong> {{ $meeting->resource_contact_no }}</p>
            </div>
        </div>
    @endforeach

    <hr>

    {{-- Present Meetings Table --}}
    <h3 class="text-success">Present Meetings</h3>
    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>Meeting Title</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse($presentMembers as $m)
                <tr>
                    <td>{{ $m['meeting_title'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($m['meeting_date'])->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($m['meeting_time'])->format('h:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($m['meeting_end_time'])->format('h:i A') }}</td>
                    <td>{{ $m['remarks'] }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">No present members</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Absent Meetings Table --}}
    <h3 class="text-danger">Absent Meetings</h3>
    <table class="table table-bordered table-hover">
        <thead class="table-danger">
            <tr>
                <th>Meeting Title</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absentMembers as $m)
                <tr>
                    <td>{{ $m['meeting_title'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($m['meeting_date'])->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($m['meeting_time'])->format('h:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($m['meeting_end_time'])->format('h:i A') }}</td>
                    <td>{{ $m['remarks'] }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">No absent members</td></tr>
            @endforelse
        </tbody>
    </table>

</div>
</div>
