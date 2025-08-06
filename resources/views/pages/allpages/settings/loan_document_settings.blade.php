<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Loan Document Settings
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="row">
                                <div class="col-12 mt-3 d-flex justify-content-end">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addloanDocModal">Create</button>
                                </div>
                                <div class="col-12 mt-3">
                                    <table class="table table-striped" id="loanDocTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Document Name</th>
                                                <th>Main Category</th>
                                                <th>Sub Category</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count = 1;
                                            @endphp
                                            @foreach ($getLoanDocData as $data)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->mainCategoryName }}</td>
                                                <td>{{ $data->subCategoryName }}</td>
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
    </div>
</div>


<!-- Add Permission Modal -->
<!-- Add Document Modal -->
<div class="modal fade" id="addloanDocModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-simple">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h4 class="mb-1">Add Loan Documents</h4>
          <p>Add multiple document names</p>
        </div>


          <div class="mb-3">
          <label class="form-label">Main Category</label>
          <select class="selectize" id="txtMainCategory">
            <option value="">Select Main Category</option>
            @foreach ($getloanMainCatData as $mainData)
              <option value="{{ $mainData->id }}">{{ $mainData->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Sub Category</label>
          <select id="txtSubCategory" >
            <option value="">--- Select Sub Category ---</option>
          </select>
        </div>


        <!-- Document Name Input -->
        <div class="mb-3">
          <label class="form-label">Document Name</label>
          <div class="d-flex gap-2">
            <input type="text" id="txtDocumentName" class="form-control" placeholder="Enter document name" />
            <button type="button" class="btn btn-success btn-sm" id="btnAddDoc">+ Add</button>
          </div>
        </div>

        <!-- Table of Added Documents -->
        <div class="table-responsive mb-4">
          <table class="table table-bordered" id="docNameTable">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Document Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <!-- Submit Buttons -->
        <div class="text-center">
          <button class="btn btn-primary me-3" id="btnCreateDocument">Create Document</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal">Discard</button>
        </div>
      </div>
    </div>
  </div>
</div>


<!--/ Add Permission Modal -->
