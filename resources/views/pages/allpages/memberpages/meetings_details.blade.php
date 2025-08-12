@php
    $tables = [
        ['title' => 'Present Meetings', 'color' => 'success', 'data' => $presentMembers],
        ['title' => 'Absent Meetings',  'color' => 'danger',  'data' => $absentMembers],
    ];
@endphp

@foreach ($tables as $table)
    <h3 class="text-{{ $table['color'] }}">{{ $table['title'] }}</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-{{ $table['color'] }}">
                <tr>
                    <th>Meeting Title</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Meeting Type</th>
                    <th>Resource Person</th>
                </tr>
            </thead>
            <tbody>
                @forelse($table['data'] as $m)
                    <tr>
                        <td>{{ $m['meeting_title'] }}</td>
                        <td>{{ $m['meeting_date'] }}</td>
                        <td>{{ $m['meeting_time'] }}</td>
                        <td>{{ $m['meeting_end_time'] }}</td>
                        <td>{{ $m['meeting_type'] }}</td>
                        <td>{{ $m['resource_person'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No {{ strtolower($table['title']) }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endforeach
