<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">

                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i> Manage Users
                        </div>
                        @if ($userType == 'superAdmin')
                        <div class="col-6 d-flex justify-content-end">
                            <a href="/add_users">
                                <button class="btn btn-success btn-sm"><i
                                        class="menu-icon ti ti-square-rounded-plus"></i> Create User</button>
                            </a>
                        </div>
                        @else
                        @php
                        $userRolesArray = $getUserRole->pluck('roleName')->toArray();
                        @endphp
                        @if (in_array($userType, $userRolesArray))
                        @php
                        $usersDataPer = $permissions;
                        $usersDataPer = json_decode($usersDataPer, true);
                        @endphp
                        @if (in_array('addUsers', $usersDataPer))
                        <div class="col-6 d-flex justify-content-end">
                            <a href="/add_users">
                                <button class="btn btn-success btn-sm"><i
                                        class="menu-icon ti ti-square-rounded-plus"></i> Create
                                    User</button>
                            </a>
                        </div>
                        @endif
                        @endif
                        @endif
                    </div>
                    <div class="card-body">
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
                            <table class="table table-sm datatableView">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>User Type</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $count = 1;
                                    @endphp
                                    @foreach ($getUsers as $user)
                                    @if ($user->userType !== 'member')
                                    @php
                                    $userId = Crypt::encrypt($user->id);
                                    @endphp
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->userType }}</td>
                                        <td>
                                            @if ($user->active == '1')
                                            <span class="badge bg-success">Active</span>
                                            @else
                                            <span class="badge bg-danger">Disable</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if ($user->userType != 'superAdmin')
                                                    <a class="dropdown-item"
                                                        href="{{ route('assign_permssion_update', encrypt($user->id)) }}"><i
                                                            class="ti ti-align-left"></i> Permission</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('assign_division', $user->id) }}"><i
                                                            class="ti ti-align-left"></i> Assign</a>
                                                    @endif
                                                    @if ($user->active == 1 && $user->userType != 'superAdmin')
                                                    <form id="disableForm"
                                                        action="{{ route('disable_user', $user->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="button" class="dropdown-item "
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#confirmDisableModal">
                                                            <i class="ti ti-user-edit me-1"></i> Disable
                                                        </button>
                                                    </form>
                                                    @elseif ($user->userType != 'superAdmin')
                                                    <form id="enableForm"
                                                        action="{{ route('enable_user', $user->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="button" class="dropdown-item "
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#confirmEnableModal">
                                                            <i class="ti ti-user-edit me-1"></i> Enable
                                                        </button>
                                                    </form>
                                                    @endif
                                                    <a class="dropdown-item" href="#"><i
                                                            class="ti ti-eye me-1"></i> View</a>
                                                    <a class="dropdown-item" href="{{route('update_user', $userId)}}"><i
                                                            class="ti ti-pencil me-1"></i> Edit</a>
                                                    <form id="deleteForm"
                                                        action="{{ route('delete_user', $user->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item text-danger"
                                                            data-bs-toggle="modal" data-bs-target="#confirmModal">
                                                            <i class="ti ti-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
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

<div class="modal fade" id="confirmEnableModal" tabindex="-1" aria-labelledby="confirmEnableModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmEnableModalLabel">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to enable this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmEnableBtn">Enable</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDisableModal" tabindex="-1" aria-labelledby="confirmDisableModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDisableModalLabel">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to disable this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDisableBtn">Disable</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteuserBtn">Delete</button>
            </div>
        </div>
    </div>
</div>