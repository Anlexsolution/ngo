<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-map-search"></i> Create New Gn Division
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form id="gnDivisionForm" action="/createGnDivisiondata" method="POST">
                                @csrf
                                @if ($errors->any())
                                    <div class="row">
                                        {!! implode('', $errors->all('<div class="alert alert-danger col-sm-12 col-md-12" role="alert">:message</div>')) !!}
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
                                    <div class="col-sm-12 col-md-6 mt-3">
                                        <label for="divisionId" class="form-label fw-bold">Select Division</label>
                                        <select name="divisionId" id="divisionId" class="selectize">
                                            @foreach ($getDivision as $division)
                                                <option value="{{ $division->id }}">{{ $division->divisionName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label class="form-label w-100" for="villageName">Gn Division Name</label>
                                        <div class="input-group input-group-merge mt-2">
                                            <input id="gnDivisionName" name="gnDivisionName" class="form-control"
                                                type="text" placeholder="GN Division Name" />
                                        </div>
                                    </div>
                                    <div class="col-12 text-center d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-primary me-3"
                                            value="createGnDivisiondata">Create</button>
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
