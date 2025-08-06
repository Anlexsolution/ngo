<div class="row">
    <div class="col-12 d-flex justify-content-center">
        <h5>Create Documents</h5>
    </div>
    <hr>
    <div class="col-6">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="txtTitle" placeholder="Enter title">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Select File</label>
            <input type="file" class="form-control" id="txtDocument">
        </div>
    </div>
    <div class="col-12 d-flex justify-content-end mt-3">
        <button type="button" class="btn btn-primary" id="btnCreateDocument">Create Document</button>
    </div>
    <br>
    <hr>
    <table class="table table-sm datatableView">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Staff Name</th>
                <th>Date & Time</th>
                <th>Document Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
                $count = 1;
            @endphp
            @foreach ($getMemberDocument as $documents)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $documents->randomId }}</td>
                    <td>
                        @foreach ($getAllUser as $user)
                            @if ($user->id == $documents->createdBy)
                                {{ $user->name }}
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $documents->created_at }}</td>
                    <td>{{ $documents->documentName }}</td>
                    <td class=" text-center"> <a href="{{ asset($documents->documentPath) }}"
                            class="btn btn-success btn-sm" download>Download</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
