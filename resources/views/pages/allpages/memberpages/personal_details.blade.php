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



<div class="container-fluid px-1">
    <div class="row mt-2 mx-0 g-1">
        {{-- Buttons --}}
        <div class="col-12 d-flex justify-content-end gap-2 flex-wrap mb-3 px-1">
            <button class="btn btn-outline-primary btn-styled btn-sm" data-bs-toggle="modal"
                data-bs-target="#updateProfileModal">
                <i class="ti ti-password-user me-1"></i> Update Member Photo
            </button>
            <button class="btn btn-outline-secondary btn-styled btn-sm" data-bs-toggle="modal"
                data-bs-target="#updateSignatureModal">
                <i class="ti ti-certificate me-1"></i> Update Signature Photo
            </button>
            <a href="{{ route('view_pdf', $member->id) }}" target="_blank"
                class="btn btn-info btn-sm btn-styled text-white">
                <i class="ti ti-user me-1"></i> Summary Details PDF
            </a>
            <a href="{{ route('view_pdf_personal', $member->id) }}" target="_blank"
                class="btn btn-warning btn-sm btn-styled text-white">
                <i class="ti ti-user me-1"></i> Personal Details PDF
            </a>
        </div>

        {{-- Member Image and Name --}}
        <div class="col-12 text-center mb-3 px-1">
            <img src="../memberimages/{{ $member->profiePhoto }}?v={{ $user->updated_at->timestamp ?? time() }} alt="Profile
                Photo" height="200px" width="200px" class="rounded-circle">

            <h4 class="fw-bold">{{ $member->title }}. {{ $member->firstName }} {{ $member->lastName }}</h4>
            <p class="text-muted">{{ $member->uniqueId }}</p>
        </div>



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
                                $member->dateOfBirth ? Carbon::parse($member->dateOfBirth)->format('d-m-Y') : '-',
                            ],
                            ['Age / வயது', $ageString],
                            ['New Account Number / புதிய க. இலக்கம்', $member->newAccountNumber],
                            ['Old Account Number / பழைய க. இலக்கம்  ', $member->oldAccountNumber],
                            ['Address / முகவரி', $member->address],
                            ['Division / பிரதேசம் ', optional($member->division)->divisionName ?? '-'],
                            ['Village / கிராமம்', optional($member->village)->villageName ?? '-'],
                            ['Group Name / குழுவின் பெயர்', optional($member->smallgroup)->smallGroupName ?? '-'],
                            ['Status / நிலை', $member->statusType],
                            [
                                'Profession Type / தொழில் பிரிவு ',
                                optional(collect($getPro)->firstWhere('id', $member->profession))->name ?? '-',
                            ],
                            [
                                'Profession / தொழில்',
                                optional(collect($getSubPro)->firstWhere('id', $member->subprofession))->name ?? '-',
                            ],
                            // [
                            //     'GN Division',
                            //     optional(collect($getGnDivision)->firstWhere('id', $member->gnDivisionId))
                            //         ->gnDivisionName ?? '-',
                            // ],
                            // [
                            //     'GN Division Small Group',
                            //     optional(
                            //         collect($gndivisionSmallgroup)->firstWhere('id', $member->gnDivisionSmallGroup),
                            //     )->smallGroupName ?? '-',
                            // ],
                        ];
                    @endphp

                    @foreach ($fields as [$label, $value])
                        <div class="col-12 col-md-6 mb-3 px-1">
                            <label class="fw-semibold">{{ $label }}</label>
                            <p class="form-control-plaintext">{{ $value }}</p>
                        </div>
                    @endforeach

                    {{-- Follower Info --}}
                    <div class="section-title mt-4">Follower Information / பின்னுருத்தளி விபரம்</div>

                    @php
                        $followers = [
                            ['Follower Name / பின்னுருத்தளி பெயர்', $member->followerName],
                            ['Follower NIC / பின்னுருத்தளி தே.அ. இலக்கம்', $member->followerNicNumber],
                            ['NIC Issue Date / தே.அ. வழங்கப்பட்ட திகதி', $member->followerIssueDate],
                            ['Follower Address / பின்னுருத்தளி முகவரி', $member->followerAddress],
                        ];
                    @endphp

                    @foreach ($followers as [$label, $value])
                        <div class="col-12 col-md-6 mb-3 px-1">
                            <label class="fw-semibold">{{ $label }}</label>
                            <p class="form-control-plaintext">{{ $value }}</p>
                        </div>
                    @endforeach

                    {{-- Signature --}}
                    <div class="col-12 text-center mt-4">
                        <label class="fw-semibold d-block">Signature/ கையொப்பம்</label>
                        <img src="{{ asset('memberimages/' . $member->signature) }}?v={{ $user->updated_at->timestamp ?? time() }} alt="Signature"
                            class="border rounded shadow-sm mt-2" height="100" width="250">
                    </div>
                </div>
            </div>
        </div>

        {{-- Saving Details Table --}}
        <div class="col-12 px-1">
            <div class="section-title">Saving Details / சேமிப்பு விவரங்கள்</div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Total Saving Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        <tr>
                            @php
                                $encId = Crypt::encrypt($getSavings->savingsId);
                            @endphp
                            <td>{{ $count++ }}</td>
                            <td>
                                <a href="{{ route('view_saving_history', $encId) }}">
                                    {{ $getSavings->savingsId }}
                                </a>
                            </td>
                            <td>{{ $getSavings->totalAmount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        {{-- Loan Details Table --}}
        <div class="col-12 mb-4 px-1">
            <div class="section-title">Loan Details / கடன் விவரங்கள்</div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Loan ID</th>
                            <th>Purpose</th>
                            <th>Term</th>
                            <th>Interest</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Collect Principal</th>
                            <th>Collect Interest</th>
                            <th>Total Arrears</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @forelse ($getDataActive as $data)
                            @php
                                $loanEncId = Crypt::encrypt($data->id);
                                $monthlyPaymentTotal = 0;
                                foreach ($getLoanScheduleData as $schedule) {
                                    if ($schedule->loanId == $data->id && $schedule->status == 'paid') {
                                        $monthlyPaymentTotal += $schedule->monthlyPayment;
                                    }
                                }

                                $totalPayAmount = 0;
                                $totalPrincipalArreas = 0;
                                $totalInterestArreas = 0;
                                $totalArreasAmount = null;

                                foreach ($getRepaymentData as $repayment) {
                                    if ($repayment->loanId == $data->id) {
                                        $totalPayAmount += $repayment->repaymentAmount;
                                        $totalPrincipalArreas += $repayment->principalAmount;
                                        $totalInterestArreas += $repayment->interest;
                                        if (
                                            $totalArreasAmount === null ||
                                            $repayment->lastLoanBalance < $totalArreasAmount
                                        ) {
                                            $totalArreasAmount = $repayment->lastLoanBalance;
                                        }
                                    }
                                }

                                $totalArreasAmount ??= 0;

                                $statusClass = match ($data->loanStatus) {
                                    'Active' => 'bg-success',
                                    'Rejected' => 'bg-danger',
                                    default => 'bg-primary',
                                };
                            @endphp
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td><a href="{{ route('view_loan_details', $loanEncId) }}">{{ $data->loanId }}</a>
                                </td>
                                <td>{{ $getLoanPurpose->firstWhere('id', $data->loanPurpose)?->name ?? '-' }}</td>
                                <td>{{ $data->loanterm }}</td>
                                <td>{{ $data->interestRate }}%</td>
                                <td>{{ number_format($data->principal, 2) }}</td>
                                <td>{{ number_format($totalPayAmount, 2) }}</td>
                                <td>{{ number_format($totalPrincipalArreas, 2) }}</td>
                                <td>{{ number_format($totalInterestArreas, 2) }}</td>
                                <td>{{ number_format($totalArreasAmount, 2) }}</td>
                                <td><span class="badge {{ $statusClass }}">{{ $data->loanStatus }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-muted">No loan records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Guarantor Details Table --}}
        <div class="col-12 px-1">
            <div class="section-title">Guarantor Details / உத்தரவாததாரர் விவரங்கள்</div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>NIC</th>
                            <th>Loan ID</th>
                            <th>Loan Amount</th>
                            <th>Saving Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                            $allGurData = collect($getGurDetails);
                        @endphp

                        @if ($allGurData->isNotEmpty())
                            @foreach ($allGurData as $gur)
                                @php
                                    // Determine the correct ID field
                                    $guarantorId = $gur->memberId ?? ($gur->gurrantos ?? null);
                                    $guarantor = $getAllMemberData->firstWhere('id', $guarantorId);
                                @endphp
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>
                                        @if ($guarantor)
                                            <a href="{{ route('view_member', encrypt($guarantor->id)) }}">
                                                {{ $guarantor->firstName ?? '-' }} {{ $guarantor->lastName ?? '' }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $guarantor->nicNumber ?? '-' }}</td>
                                    <td>{{ $gur->loanId }}</td>
                                    <td>{{ number_format($gur->principal, 2) }}</td>
                                    <td>{{ number_format($gur->savingAmount ?? 0, 2) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-muted">No guarantor data available.</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>

        {{-- Notes Details Table --}}
        <div class="col-12 px-1">
            <div class="section-title">Feedback Details / கருத்து விவரங்கள்</div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Id</th>
                            <th>Staff Name</th>
                            <th>Date & Time</th>
                            <th>Title</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($getMemberNotes as $note)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $note->randomId }}</td>
                                <td>
                                    @foreach ($getAllUser as $user)
                                        @if ($user->id == $note->createdBy)
                                            {{ $user->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $note->created_at }}</td>
                                <td>{{ $note->title }}</td>
                                <td>{{ $note->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>
