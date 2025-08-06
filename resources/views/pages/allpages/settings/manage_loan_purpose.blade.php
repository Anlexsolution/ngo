<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Manage loan purpose
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-end">

                                <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#addProfessionModal">Create Main Category</button>

                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addLoanPurposeModalSub">Create Sub Category</button>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Main Category Name</th>
                                        <th>Sub Category Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($getPurpose as $pro)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td>{{ $pro->name }}</td>
                                                <td>
                                                    @foreach ($getLoanPurposeSubCat as $sub)
                                                        @if ($sub->mainCatId == $pro->id)
                                                            {{ $sub->name }} <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="d-flex justify-content-center">
                                                    <button class="btn btn-success btn-sm me-2 btnUpdateMainCategory"
                                                        data-name ="{{ $pro->name }}"
                                                        data-id="{{ $pro->id }}"><i class="ti ti-edit"></i>
                                                        Edit</button>

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


<!-- Add Permission Modal -->
<div class="modal fade" id="addProfessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add New Main Category</h4>
                    <p>Create a new Main Category</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">Category Name</label>
                    <input type="text" id="modalPurposeName" class="form-control" placeholder="Profession Name"
                        autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreatePurpose">Create Main Category</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->


<div class="modal fade" id="addLoanPurposeModalSub" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Add New Sub Category</h4>
                    <p>Create a new Sub Category</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">Select Main Category</label>
                    <select class="selectize" id="txtMainCatId">
                        <option value="">---Select----</option>
                        @foreach ($getPurpose as $pro)
                            <option value="{{$pro->id}}">{{$pro->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label" for="modalPurposeName">Sub Category Name</label>
                    <input type="text" id="txtSubCatName" class="form-control" placeholder="Profession Name"
                        autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateSubCat">Create Sub Category</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- update Permission Modal -->
<div class="modal fade" id="updateMaincategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Update Main Category</h4>
                    <p>Update a Main Category</p>
                </div>
                <input type="hidden" id="txtMainCatIdUpdate">
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">Main Category</label>
                    <input type="text" id="txtUpdateMainCat" class="form-control" placeholder="Main Category Name"
                        autofocus />
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnUpdateMainCat">Update Main Category</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ update Permission Modal -->


