<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-group"></i> Create New Small Group
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form action="/createsmallgroupdata" method="POST">
                                @csrf
                                @if ($errors->any())
                                    <div class="row">
                                        {!! implode(
                                            '',
                                            $errors->all('<div class="mt-3 alert alert-danger col-sm-12 col-md-12" role="alert">:message</div>'),
                                        ) !!}
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="mt-3 alert alert-success success-alert">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="mt-3 alert alert-danger danger-alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-6">
                                        <label for="divisionId" class="form-label fw-bold">Select Division</label>
                                        <select name="divisionId" id="divisionId" class="form-control">
                                            <option value="">Select Division</option>
                                            @foreach ($getDivision as $division)
                                                <option value="{{ $division->id }}">{{ $division->divisionName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label for="villageId" class="form-label fw-bold">Select Village</label>
                                        <select name="villageId" id="villageId" class="form-control">
                                            <option value="">Select Village</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt-2">
                                        <label class="form-label w-100" for="smallGroupName">Small Group Name</label>
                                        <div class="input-group input-group-merge">
                                            <input id="smallGroupName" name="smallGroupName" class="form-control"
                                                type="text" placeholder="Small Group Name" />
                                        </div>
                                    </div>
                                    <div class="col-12 text-center d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-primary me-3"
                                            value="createsmallgroupdata">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                <i class="menu-icon ti ti-users-group"></i> View
            </div>
            <div class="card-body">
                <div class="row mt-3">
                    <table class="table table-sm datatableView">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Group ID</th>
                                <th>Division</th>
                                <th>Village</th>
                                <th>Small Group</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($getSmallGroup as $smallGroup)
                                <tr>
                                    <td>@php
                                        echo $i++;
                                    @endphp</td>
                                    <td>{{ $smallGroup->id }}</td>
                                    <td>
                                        @foreach ($getDivision as $division)
                                            @php
                                                $divisionId = $division->id;
                                                if ($smallGroup->divisionId == $divisionId) {
                                                    echo $division->divisionName;
                                                }
                                            @endphp
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($getVillage as $village)
                                            @php
                                                $villageId = $village->id;
                                                if ($smallGroup->villageId == $villageId) {
                                                    echo $village->villageName;
                                                }
                                            @endphp
                                        @endforeach
                                    </td>
                                    <td>{{ $smallGroup->smallGroupName }}</td>

                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item text-black" href="#"><i
                                                        class="ti ti-edit me-1"></i> Edit</a>
                                                <a class="dropdown-item text-danger" href="#"><i
                                                        class="ti ti-trash me-1"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('divisionId').addEventListener('change', function() {
        var divisionId = this.value;
        console.log(divisionId)
        if (divisionId) {
            fetch(`/get-villages/${divisionId}`)
                .then(response => response.json())
                .then(data => {
                    var villageSelect = document.getElementById('villageId');
                    villageSelect.innerHTML = '<option value="">Select Village</option>';

                    data.forEach(function(village) {
                        var option = document.createElement('option');
                        option.value = village.id;
                        option.text = village.villageName;
                        villageSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching villages:', error));
        } else {
            document.getElementById('villageId').innerHTML = '<option value="">Select Village</option>';
        }
    });
</script>
