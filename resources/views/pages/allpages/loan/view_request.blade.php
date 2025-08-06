<style>
    .section-title {
        border-left: 5px solid #007bff;
        padding-left: 10px;
        margin-bottom: 15px;
        font-weight: 600;
        font-size: clamp(1rem, 1.5vw, 1.25rem);
        color: #343a40;
    }

    .profile-card .form-control-plaintext {
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }

    .btn-styled {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        vertical-align: middle;
    }

    .profile-photo {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 50%;
        object-fit: cover;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    @media (max-width: 350px) {

        body,
        .container-fluid {
            padding-left: 0.05rem !important;
            padding-right: 0.05rem !important;
        }

        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .col-12,
        .col-sm-12 {
            padding-left: 0.25rem !important;
            padding-right: 0.25rem !important;
        }

        .profile-card {
            padding: 0.75rem !important;
        }

        .btn-styled {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>


<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                <div class="col-4">
                    <i class="menu-icon ti ti-list"></i> View Request Details
                </div>
            </div>
            <div class="card-body">
                {{-- Profile Details --}}
                <div class="col-12 mb-4 px-1">
                    <div class="card shadow p-4 rounded profile-card">
                        <div class="section-title">Member Details / அங்கத்தவர் விபரம் </div>
                        <div class="row">
                            @php
                                use Carbon\Carbon;

                                $ageString = '-';
                                if (!empty($member->dateOfBirth)) {
                                    try {
                                        $dob = Carbon::parse($member->dateOfBirth)->startOfDay();
                                        $now = Carbon::now()->startOfDay();

                                        $diff = $dob->diff($now);
                                        $years = $diff->y; // whole years
                                        $months = $diff->m; // whole months
                                        $days = $diff->d; // whole days

                                        $ageString = "{$years} years, {$months} months, {$days} days";
                                    } catch (\Exception $e) {
                                        $ageString = '-';
                                    }
                                }

                                $fields = [
                                    ['First Name / முதற்பெயர்', $member->firstName],
                                    ['Last Name / கடைசி பெயர்', $member->lastName],
                                    ['NIC / தே.அ. இலக்கம்', $member->nicNumber],
                                    ['NIC Issue Date / தே.அ. வழங்கப்பட்ட திகதி ', $member->nicIssueDate],
                                    ['Gender / பால் நிலை', $member->gender],
                                    ['Marital Status / திருமண நிலை', $member->maritalStatus],
                                    ['Phone Number / தொலைபேசி இலக்கம்', $member->phoneNumber],
                                    [
                                        'Date of Birth / பிறந்த தேதி',
                                        $member->dateOfBirth
                                            ? Carbon::parse($member->dateOfBirth)->format('d-m-Y')
                                            : '-',
                                    ],
                                    ['Age / வயது', $ageString],
                                    ['New Account Number / புதிய க. இலக்கம்', $member->newAccountNumber],
                                    ['Old Account Number / பழைய க. இலக்கம்  ', $member->oldAccountNumber],
                                    ['Address / முகவரி', $member->address],
                                    ['Division / பிரதேசம் ', optional($member->division)->divisionName ?? '-'],
                                    ['Village / கிராமம்', optional($member->village)->villageName ?? '-'],
                                    [
                                        'Group Name / குழுவின் பெயர்',
                                        optional($member->smallgroup)->smallGroupName ?? '-',
                                    ],
                                    ['Status / நிலை', $member->statusType],
                                    [
                                        'Profession Type / தொழில் பிரிவு ',
                                        optional(collect($getPro)->firstWhere('id', $member->profession))->name ?? '-',
                                    ],
                                    [
                                        'Profession / தொழில்',
                                        optional(collect($getSubPro)->firstWhere('id', $member->subprofession))->name ??
                                        '-',
                                    ],
                                    [
                                        'GN Division',
                                        optional(collect($getGnDivision)->firstWhere('id', $member->gnDivisionId))
                                            ->gnDivisionName ?? '-',
                                    ],
                                    [
                                        'GN Division Small Group',
                                        optional(
                                            collect($gndivisionSmallgroup)->firstWhere(
                                                'id',
                                                $member->gnDivisionSmallGroup,
                                            ),
                                        )->smallGroupName ?? '-',
                                    ],
                                ];
                            @endphp

                            @foreach ($fields as [$label, $value])
                                <div class="col-12 col-md-6 mb-3 px-1">
                                    <label class="fw-semibold">{{ $label }}</label>
                                    <p class="form-control-plaintext">{{ $value }}</p>
                                </div>
                            @endforeach

                        </div>
                        <hr>
                        <div class="section-title">Loan Request Details / கடன் கோரிக்கை விபரம் </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3 px-1">
                                <label class="fw-semibold">Loan Amount / கடன் தொகை</label>
                                <p class="form-control-plaintext">{{ number_format($getLoanReqData->loanAmount, 2) }}
                                </p>
                            </div>
                            <div class="col-12 col-md-6 mb-3 px-1">
                                <label class="fw-semibold">Main Category / முக்கிய வகை</label>
                                <p class="form-control-plaintext">
                                    @foreach ($getPro as $main)
                                        @if ($main->id == $getLoanReqData->mainCategoryId)
                                            {{ $main->name ?? '-' }}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="col-12 col-md-6 mb-3 px-1">
                                <label class="fw-semibold">Sub Category / துணை வகை</label>
                                <p class="form-control-plaintext">
                                    @foreach ($getSubPro as $sub)
                                        @if ($sub->id == $getLoanReqData->subCategoryId)
                                            {{ $main->name ?? '-' }}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="col-12 col-md-12 mb-3 px-1">
                                <label class="fw-semibold">Documents / ஆவணங்கள்</label>
                                <ul>
                                @php
                                    $doc = json_decode($getLoanReqData->documents, true);
                                @endphp
                                @foreach ($doc as $getDoc)
                                   <li>
                                    {{ $getDoc['name'] }}
                                   </li>
                                @endforeach
</ul>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="mt-3 table table-bordered">
                    <thead class="bg-info text-white">
                        <tr>
                            <th class=" text-white fw-bold">#</th>
                            <th class=" text-white fw-bold">Date & Time</th>
                            <th class=" text-white fw-bold">User Name</th>
                            <th class=" text-white fw-bold">Status</th>
                            <th class=" text-white fw-bold">Documents</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($loanRequestHisData as $data)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>{{ $data->userName }}</td>
                                <td>{{ $data->approvedStatus }}</td>
                                <td>
                                    @php
                                        $doc = json_decode($data->documents, true);
                                    @endphp
                                    @foreach ($doc as $getDoc)
                                    {{ $getDoc['name'] }} <br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr class="mt-3">
                <div class="text-center fw-bold text-uppercase">Member approve details</div>
                <table class="mt-3 table table-bordered">
                    <thead class="bg-info text-white">
                        <tr>
                            <th class=" text-white fw-bold">#</th>
                            <th class=" text-white fw-bold">Date & Time</th>
                            <th class=" text-white fw-bold">Member Name</th>
                            <th class=" text-white fw-bold">Status</th>
                            <th class=" text-white fw-bold">Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($getReqApproveMemb as $data)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    @foreach ($getAllMemberData as $member)
                                        @if ($member->id == $data->memberId)
                                            {{ $member->title }}. {{ $member->firstName }} {{ $member->lastName }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $data->selectedOption }}</td>
                                <td>{{ $data->remarks }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
