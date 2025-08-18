<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Manage Resource Person
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-end">

                                <a href="/create_resource">
                                    <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                        data-bs-target="#addProfessionModal">Create Resource Person</button>
                                </a>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Division</th>
                                        <th>VIllage</th>
                                        <th>NIC</th>
                                        <th>Qualification</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getResourcePerson as $pro)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td><a href="{{ route('view_person', $pro->id) }}">{{ $pro->full_name }}</a></td>
                                            <td>
                                                @foreach ($getDivisionData as $data)
                                                    @if ($data->id == $pro->division_id)
                                                        {{ $data->divisionName }} <br>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($getVillageData as $data)
                                                    @if ($data->id == $pro->village_id)
                                                        {{ $data->villageName }} <br>
                                                    @endif
                                                @endforeach
                                            </td>
                                              <td>{{ $pro->nic }}</td>
                                               <td>
                                                @foreach ($getQualification as $data)
                                                    @if ($data->id == $pro->main_qualification)
                                                        {{ $data->qualificationName }} <br>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="d-flex justify-content-center">
                                                <button class="btn btn-success btn-sm me-2 ">
                                                    <i class="ti ti-edit"></i> Edit
                                                </button>
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
    </div>
</div>
