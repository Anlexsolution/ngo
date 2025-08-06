<div class="row">
    <div class="col-12">
        <div class="col-12 d-flex justify-content-center">
            <h5>Create Note</h5>
        </div>
        <hr>
        <div class="col-12">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="txtTitleNote" placeholder="Enter title">
            </div>
        </div>
        <div class="col-12 mt-2">
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" id="txtDescription"></textarea>
            </div>
        </div>
        <div class="col-12 d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-primary" id="btnCreateNote">Create Note</button>
        </div>
        <br>
        <hr>
        <table class="table table-sm datatableView">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Id</th>
                    <th>Staff Name</th>
                    <th>Date & Time</th>
                    <th>Title</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 1;
                @endphp
                @foreach ($getMemberNotes as $note)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $note->randomId }}</td>
                        <td>
                            @foreach ($getAllUser as $user)
                                @if ($user->id == $note->createdBy)
                                    {{ $user->name }}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $note->created_at }}</td>
                        <td>{{ $note->title }}</td>
                        <td>{{ $note->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
