  <!-- Navbar -->

  <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
      id="layout-navbar">
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
          <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="ti ti-menu-2 ti-md"></i>
          </a>
      </div>

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
          <!-- Search -->
          <div class="navbar-nav align-items-center">
              <div class="nav-item navbar-search-wrapper mb-0">
                  <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
                      <i class="ti ti-search ti-md me-2 me-lg-4 ti-lg"></i>
                      <span class="d-none d-md-inline-block text-muted fw-normal">Search (Ctrl+/)</span>
                  </a>
              </div>
          </div>
          <!-- /Search -->

          <ul class="navbar-nav flex-row align-items-center ms-auto">


              <!-- Style Switcher -->
              <li class="nav-item dropdown-style-switcher dropdown">
                  <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                      href="javascript:void(0);" data-bs-toggle="dropdown">
                      <i class="ti ti-md"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                      <li>
                          <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                              <span class="align-middle"><i class="ti ti-sun ti-md me-3"></i>Light</span>
                          </a>
                      </li>
                      <li>
                          <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                              <span class="align-middle"><i class="ti ti-moon-stars ti-md me-3"></i>Dark</span>
                          </a>
                      </li>
                      <li>
                          <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                              <span class="align-middle"><i
                                      class="ti ti-device-desktop-analytics ti-md me-3"></i>System</span>
                          </a>
                      </li>
                  </ul>
              </li>
              <!-- / Style Switcher-->



              <!-- Notification -->
              <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                  <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                      href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                      aria-expanded="false">
                      <span class="position-relative">
                          <i class="ti ti-bell ti-md"></i>
                          <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                      </span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end p-0">
                      <li class="dropdown-menu-header border-bottom">
                          <div class="dropdown-header d-flex align-items-center py-3">
                              <h6 class="mb-0 me-auto">Notification</h6>
                              <div class="d-flex align-items-center h6 mb-0">
                                  {{-- <span class="badge bg-label-primary me-2">8 New</span> --}}
                                  <a href="javascript:void(0)"
                                      class="btn btn-text-secondary rounded-pill btn-icon dropdown-notifications-all"
                                      data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i
                                          class="ti ti-mail-opened text-heading"></i></a>
                              </div>
                          </div>
                      </li>
                      <li class="dropdown-notifications-list scrollable-container">
                          <ul class="list-group list-group-flush">
                              @php
                                  $userId = Auth::user()->id;
                              @endphp
                              @foreach ($getLoansData as $loanData)
                                  @php
                                      $getApproval = json_decode($loanData->approval, true);
                                  @endphp
                                  @foreach ($getApproval as $approve)
                                      @if (
                                          $userId == $approve['value'] &&
                                              $approve['id'] > $loanData->approvalStatus &&
                                              $loanData->approvalStatus + 1 == $approve['id'] &&
                                              $loanData->createStatus != 0)
                                          @php
                                              $loanIDEnc = Crypt::encrypt($loanData->id);
                                              $memberIDEnc = Crypt::encrypt($loanData->memberId);
                                          @endphp
                                          <li class="list-group-item list-group-item-action dropdown-notifications-item"
                                              onclick="window.location.href='{{ route('view_loan_approval', [$loanIDEnc, $memberIDEnc]) }}';">

                                              <div class="d-flex">
                                                  <div class="flex-shrink-0 me-3">
                                                      <div class="avatar">
                                                          <span class="avatar-initial rounded-circle bg-label-danger"><i
                                                                  class="ti ti-building-bank"></i></span>
                                                      </div>
                                                  </div>
                                                  <div class="flex-grow-1">
                                                      <h6 class="mb-1 small">
                                                          @foreach ($getAllMemberData as $mem)
                                                              @if ($mem->id == $loanData->memberId)
                                                                  {{ $mem->firstName }} {{ $mem->lastName }}
                                                              @endif
                                                          @endforeach
                                                      </h6>
                                                      <small class="mb-1 d-block text-body">Amount
                                                          :{{ number_format($loanData->principal, 2) }}</small>
                                                      @php
                                                          if ($loanData->loanStatus == 'Approved') {
                                                              $statusClass = 'bg-success';
                                                          } else {
                                                              $statusClass = 'bg-primary';
                                                          }
                                                      @endphp
                                                      <small class="text-muted"><span
                                                              class="badge {{ $statusClass }}">{{ $loanData->loanStatus }}</span></small>
                                                  </div>
                                                  <div class="flex-shrink-0 dropdown-notifications-actions">
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-read"><span
                                                              class="badge badge-dot"></span></a>
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-archive"><span
                                                              class="ti ti-x"></span></a>
                                                  </div>
                                              </div>
                                          </li>
                                      @endif
                                  @endforeach
                              @endforeach

                              {{-- Loan Request Details --}}
                              @php
                                  $getLoanRq = Session::get('loanRequest');
                                  $userType = Auth::user()->userType;
                                  $userDivision = Auth::user()->division;
                                  $userVillage = Auth::user()->village;
                              @endphp

                              @foreach ($getLoanRq as $request)
                                  @if ($request->status == 1)
                                      @foreach ($getUserRole as $userrole)
                                          @if ($request->userTypeId == $userrole->id)
                                              @if ($userrole->roleName == $userType)
                                                  @foreach ($getAllMemberData as $member)
                                                      @if (
                                                          $request->memberId == $member->id &&
                                                              in_array($member->divisionId, json_decode($userDivision)) &&
                                                              in_array($member->villageId, json_decode($userVillage)))
                                                          @php
                                                              $requestIDEnc = Crypt::encrypt($request->id);
                                                          @endphp
                                                          <li class="list-group-item list-group-item-action dropdown-notifications-item"
                                                              onclick="window.location.href='{{ route('view_loan_request', $requestIDEnc) }}';">

                                                              <div class="d-flex">
                                                                  <div class="flex-shrink-0 me-3">
                                                                      <div class="avatar">
                                                                          <span
                                                                              class="avatar-initial rounded-circle bg-label-danger"><i
                                                                                  class="ti ti-building-bank"></i></span>
                                                                      </div>
                                                                  </div>
                                                                  <div class="flex-grow-1">
                                                                      <h6 class="mb-1 small">
                                                                          @foreach ($getAllMemberData as $mem)
                                                                              @if ($mem->id == $request->memberId)
                                                                                  {{ $mem->firstName }}
                                                                                  {{ $mem->lastName }}
                                                                              @endif
                                                                          @endforeach
                                                                      </h6>
                                                                      <small class="mb-1 d-block text-body">Amount
                                                                          :{{ number_format($request->loanAmount, 2) }}</small>

                                                                      <small class="text-muted"><span
                                                                              class="badge bg-primary">Loan
                                                                              Request</span></small>
                                                                  </div>
                                                                  <div
                                                                      class="flex-shrink-0 dropdown-notifications-actions">
                                                                      <a href="javascript:void(0)"
                                                                          class="dropdown-notifications-read"><span
                                                                              class="badge badge-dot"></span></a>
                                                                      <a href="javascript:void(0)"
                                                                          class="dropdown-notifications-archive"><span
                                                                              class="ti ti-x"></span></a>
                                                                  </div>
                                                              </div>
                                                          </li>
                                                      @endif
                                                  @endforeach
                                              @endif
                                          @endif
                                      @endforeach
                                  @endif
                              @endforeach

                              {{-- Withdrawal Requests --}}
                              @php
                                  $getWithdrawal = Session::get('withdrawal');
                                  $getuserRole = Session::get('userRole');
                              @endphp

                              @foreach ($getWithdrawal as $withdraw)
                                  @foreach ($getAllMemberData as $mem)
                                      @if ($mem->uniqueId == $withdraw->memberId)
                                          @php
                                              $memName = $mem->firstName . ' ' . $mem->lastName;
                                          @endphp
                                      @endif
                                  @endforeach
                                  @php
                                      $userTypeData = '';
                                  @endphp
                                  @foreach ($getuserRole as $userrole)
                                      @if ($userrole->id == $withdraw->approveUserType)
                                          @php
                                              $userTypeData = $userrole->roleName;
                                          @endphp
                                      @endif
                                  @endforeach
                                  @php
                                      $withdrawIDEnc = Crypt::encrypt($withdraw->id);
                                  @endphp
                                  @if ($userType == $userTypeData)
                                      @if ($withdraw->request == 0)
                                          <li class="list-group-item list-group-item-action dropdown-notifications-item"
                                              onclick="window.location.href='{{ route('view_withdrawal_request', $withdrawIDEnc) }}';">

                                              <div class="d-flex">
                                                  <div class="flex-shrink-0 me-3">
                                                      <div class="avatar">
                                                          <span
                                                              class="avatar-initial rounded-circle bg-label-danger"><i
                                                                  class="ti ti-building-bank"></i></span>
                                                      </div>
                                                  </div>
                                                  <div class="flex-grow-1">
                                                      <h6 class="mb-1 small">
                                                          {{ $memName }}
                                                      </h6>
                                                      <small class="mb-1 d-block text-body">Amount
                                                          :{{ number_format($withdraw->amount, 2) }}</small>

                                                      <small class="text-muted"><span class="badge bg-primary">waiting
                                                              for 1st
                                                              approval</span></small>
                                                  </div>
                                                  <div class="flex-shrink-0 dropdown-notifications-actions">
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-read"><span
                                                              class="badge badge-dot"></span></a>
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-archive"><span
                                                              class="ti ti-x"></span></a>
                                                  </div>
                                              </div>
                                          </li>
                                      @elseif ($withdraw->request == 1)
                                          <li class="list-group-item list-group-item-action dropdown-notifications-item"
                                              onclick="window.location.href='{{ route('view_withdrawal_request', $withdrawIDEnc) }}';">

                                              <div class="d-flex">
                                                  <div class="flex-shrink-0 me-3">
                                                      <div class="avatar">
                                                          <span
                                                              class="avatar-initial rounded-circle bg-label-danger"><i
                                                                  class="ti ti-building-bank"></i></span>
                                                      </div>
                                                  </div>
                                                  <div class="flex-grow-1">
                                                      <h6 class="mb-1 small">
                                                          {{ $memName }}
                                                      </h6>
                                                      <small class="mb-1 d-block text-body">Amount
                                                          :{{ number_format($withdraw->amount, 2) }}</small>

                                                      <small class="text-muted"><span class="badge bg-primary">waiting
                                                              for 2nd
                                                              approval</span></small>
                                                  </div>
                                                  <div class="flex-shrink-0 dropdown-notifications-actions">
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-read"><span
                                                              class="badge badge-dot"></span></a>
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-archive"><span
                                                              class="ti ti-x"></span></a>
                                                  </div>
                                              </div>
                                          </li>
                                      @elseif ($withdraw->request == 2)
                                          <li class="list-group-item list-group-item-action dropdown-notifications-item"
                                              onclick="window.location.href='{{ route('view_withdrawal_request', $withdrawIDEnc) }}';">

                                              <div class="d-flex">
                                                  <div class="flex-shrink-0 me-3">
                                                      <div class="avatar">
                                                          <span
                                                              class="avatar-initial rounded-circle bg-label-danger"><i
                                                                  class="ti ti-building-bank"></i></span>
                                                      </div>
                                                  </div>
                                                  <div class="flex-grow-1">
                                                      <h6 class="mb-1 small">
                                                          {{ $memName }}
                                                      </h6>
                                                      <small class="mb-1 d-block text-body">Amount
                                                          :{{ number_format($withdraw->amount, 2) }}</small>

                                                      <small class="text-muted"><span class="badge bg-primary">waiting
                                                              for 3rd
                                                              approval</span></small>
                                                  </div>
                                                  <div class="flex-shrink-0 dropdown-notifications-actions">
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-read"><span
                                                              class="badge badge-dot"></span></a>
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-archive"><span
                                                              class="ti ti-x"></span></a>
                                                  </div>
                                              </div>
                                          </li>
                                      @elseif ($withdraw->request == 3)
                                          <li class="list-group-item list-group-item-action dropdown-notifications-item"
                                              onclick="window.location.href='{{ route('view_withdrawal_request', $withdrawIDEnc) }}';">

                                              <div class="d-flex">
                                                  <div class="flex-shrink-0 me-3">
                                                      <div class="avatar">
                                                          <span
                                                              class="avatar-initial rounded-circle bg-label-danger"><i
                                                                  class="ti ti-building-bank"></i></span>
                                                      </div>
                                                  </div>
                                                  <div class="flex-grow-1">
                                                      <h6 class="mb-1 small">
                                                          {{ $memName }}
                                                      </h6>
                                                      <small class="mb-1 d-block text-body">Amount
                                                          :{{ number_format($withdraw->amount, 2) }}</small>

                                                      <small class="text-muted"><span class="badge bg-primary">waiting
                                                              for 4th
                                                              approval</span></small>
                                                  </div>
                                                  <div class="flex-shrink-0 dropdown-notifications-actions">
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-read"><span
                                                              class="badge badge-dot"></span></a>
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-archive"><span
                                                              class="ti ti-x"></span></a>
                                                  </div>
                                              </div>
                                          </li>
                                      @endif
                                  @endif
                              @endforeach
                              {{-- Withdrawal Requests --}}


                              {{-- Death Donation --}}
                              @php
                                  $getuserRole = Session::get('userRole');
                                  $getdeathDonation = Session::get('deathDonation');
                                  $getdeathDonation = json_decode($getdeathDonation, true) ?? [];
                                  $userType = Auth::user()->userType;
                              @endphp

                              @foreach ($getdeathDonation as $donation)
                                  @if ($userType == $donation['userType'])
                                      @php
                                          $encId = Crypt::encrypt($donation['id']);
                                      @endphp
                                      @if ($donation['status'] == 1)
                                          <li class="list-group-item list-group-item-action dropdown-notifications-item"
                                              onclick="window.location.href='{{ route('view_death_donation_recommand', $encId) }}';">

                                              <div class="d-flex">
                                                  <div class="flex-shrink-0 me-3">
                                                      <div class="avatar">
                                                          <span
                                                              class="avatar-initial rounded-circle bg-label-danger"><i
                                                                  class="ti ti-building-bank"></i></span>
                                                      </div>
                                                  </div>
                                                  <div class="flex-grow-1">
                                                      <h6 class="mb-1 small">
                                                          @foreach ($getAllMemberData as $member)
                                                              @if ($member->id == $donation['memberId'])
                                                                  {{ $member->firstName }} {{ $member->lastName }}
                                                              @endif
                                                          @endforeach
                                                      </h6>
                                                      <small class="mb-1 d-block text-body">Amount
                                                          :{{ number_format(10000, 2) }}</small>

                                                      <small class="text-muted"><span class="badge bg-primary">waiting
                                                              for recommand</span></small>
                                                  </div>
                                                  <div class="flex-shrink-0 dropdown-notifications-actions">
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-read"><span
                                                              class="badge badge-dot"></span></a>
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-archive"><span
                                                              class="ti ti-x"></span></a>
                                                  </div>
                                              </div>
                                          </li>
                                        @elseif ($donation['status'] == 2)
                                               <li class="list-group-item list-group-item-action dropdown-notifications-item"
                                              onclick="window.location.href='{{ route('view_death_donation_approve', $encId) }}';">

                                              <div class="d-flex">
                                                  <div class="flex-shrink-0 me-3">
                                                      <div class="avatar">
                                                          <span
                                                              class="avatar-initial rounded-circle bg-label-danger"><i
                                                                  class="ti ti-building-bank"></i></span>
                                                      </div>
                                                  </div>
                                                  <div class="flex-grow-1">
                                                      <h6 class="mb-1 small">
                                                          @foreach ($getAllMemberData as $member)
                                                              @if ($member->id == $donation['memberId'])
                                                                  {{ $member->firstName }} {{ $member->lastName }}
                                                              @endif
                                                          @endforeach
                                                      </h6>
                                                      <small class="mb-1 d-block text-body">Amount
                                                          :{{ number_format(10000, 2) }}</small>

                                                      <small class="text-muted"><span class="badge bg-primary">waiting
                                                              for Approve</span></small>
                                                  </div>
                                                  <div class="flex-shrink-0 dropdown-notifications-actions">
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-read"><span
                                                              class="badge badge-dot"></span></a>
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-archive"><span
                                                              class="ti ti-x"></span></a>
                                                  </div>
                                              </div>
                                          </li>
                                        @elseif ($donation['status'] == 3)
                                                 <li class="list-group-item list-group-item-action dropdown-notifications-item"
                                              onclick="window.location.href='{{ route('view_death_donation_distribute', $encId) }}';">

                                              <div class="d-flex">
                                                  <div class="flex-shrink-0 me-3">
                                                      <div class="avatar">
                                                          <span
                                                              class="avatar-initial rounded-circle bg-label-danger"><i
                                                                  class="ti ti-building-bank"></i></span>
                                                      </div>
                                                  </div>
                                                  <div class="flex-grow-1">
                                                      <h6 class="mb-1 small">
                                                          @foreach ($getAllMemberData as $member)
                                                              @if ($member->id == $donation['memberId'])
                                                                  {{ $member->firstName }} {{ $member->lastName }}
                                                              @endif
                                                          @endforeach
                                                      </h6>
                                                      <small class="mb-1 d-block text-body">Amount
                                                          :{{ number_format(10000, 2) }}</small>

                                                      <small class="text-muted"><span class="badge bg-primary">waiting
                                                              for Distribute</span></small>
                                                  </div>
                                                  <div class="flex-shrink-0 dropdown-notifications-actions">
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-read"><span
                                                              class="badge badge-dot"></span></a>
                                                      <a href="javascript:void(0)"
                                                          class="dropdown-notifications-archive"><span
                                                              class="ti ti-x"></span></a>
                                                  </div>
                                              </div>
                                          </li>
                                      @endif
                                  @endif
                              @endforeach
                              {{-- Death Donation --}}

                          </ul>
                      </li>
                      {{-- <li class="border-top">
                          <div class="d-grid p-4">
                              <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                                  <small class="align-middle">View all notifications</small>
                              </a>
                          </div>
                      </li>  --}}
                  </ul>
              </li>
              <!--/ Notification -->

              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                      data-bs-toggle="dropdown">
                      <div class="avatar avatar-online">
                          <img src="{{ Auth::user()->profileImage ? asset('uploads/' . Auth::user()->profileImage) : asset('assets/img/avatars/1.png') }}?v={{ $user->updated_at->timestamp ?? time() }}
                              alt="Profile Image" class="rounded-circle" />
                      </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                          <a class="dropdown-item mt-0" href="pages-account-settings-account.html">
                              <div class="d-flex align-items-center">
                                  <div class="flex-shrink-0 me-2">
                                      <div class="avatar avatar-online">
                                          <img src="{{ Auth::user()->profileImage ? asset('uploads/' . Auth::user()->profileImage) : asset('assets/img/avatars/1.png') }}?v={{ $user->updated_at->timestamp ?? time() }}
                                              alt="Profile Image" class="rounded-circle" />
                                      </div>
                                  </div>
                                  <div class="flex-grow-1">
                                      <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                      <small class="text-muted">{{ auth()->user()->userType }}</small>
                                  </div>
                              </div>
                          </a>
                      </li>
                      <li>
                          <div class="dropdown-divider my-1 mx-n2"></div>
                      </li>
                      <li>
                          @php
                              $userId = Crypt::encrypt(auth()->user()->id);
                          @endphp
                          <a class="dropdown-item" href="{{ route('profile_view', $userId) }}">
                              <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">My Profile</span>
                          </a>
                      </li>
                      <li>
                          <div class="dropdown-divider my-1 mx-n2"></div>
                      </li>
                      <li>
                          <div class="d-grid px-2 pt-2 pb-1">
                              <a class="btn btn-sm btn-danger d-flex" href="/logout">
                                  <small class="align-middle">Logout</small>
                                  <i class="ti ti-logout ms-2 ti-14px"></i>
                              </a>
                          </div>
                      </li>
                  </ul>
              </li>
              <!--/ User -->
          </ul>
      </div>

      <!-- Search Small Screens -->
      <div class="navbar-search-wrapper search-input-wrapper d-none">
          <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..."
              aria-label="Search..." />
          <i class="ti ti-x search-toggler cursor-pointer"></i>
      </div>
  </nav>

  <!-- / Navbar -->
