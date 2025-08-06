<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-list"></i> Manage Loan Product
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <a href="/create_loan_product">
                                <button class="btn btn-success btn-sm"><i class="menu-icon ti ti-circle-plus"></i>
                                    Create Product</button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm datatableView">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($getProductData as $data)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$data->productName}}</td>
                                        <td>{{$data->description}}</td>
                                        <td>
                                            @if($data->active == 'Yes')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button"
                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="#"><i
                                                            class="ti ti-eye me-1"></i> View</a>
                                                    <a class="dropdown-item"
                                                        href="#"><i
                                                            class="ti ti-pencil me-1"></i> Edit</a>
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
</div>
