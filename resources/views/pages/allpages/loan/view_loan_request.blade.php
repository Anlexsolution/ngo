<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                <div class="col-4">
                    <i class="menu-icon ti ti-list"></i> View Loan Request
                </div>
            </div>
            <div class="card-body">
                <input type="text" class="form-control" id="txtRequestId" value="{{ $loanRequest->id }}" hidden>
                <div class="row">
                    <div class="col-4 mt-3">
                        <div class="form-group">
                            <label class="fw-bold">Member Name</label>
                            <p>{{ $getMember->firstName }} {{ $getMember->lastName }}</p>
                        </div>
                    </div>

                    <div class="col-4 mt-3">
                        <div class="form-group">
                            <label class="fw-bold">Loan Request Amount</label>
                            <p>{{ number_format($loanRequest->loanAmount, 2) }}</p>
                        </div>
                    </div>

                    <div class="col-4 mt-4">
                        <button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addLoanRequestAppModal"><i class="ti ti-copy-plus"></i></button>
                    </div>

                    <div class="col-12 mt-4">
                        <label><strong>Documents</strong></label>

                        {{-- ✅ Select All Checkbox --}}
                        <div class="mb-2">
                            <label>
                                <input type="checkbox" id="selectAll"> Select All
                            </label>
                        </div>

                        <ul>
                            @php
                                $loanRequestDocument = $loanRequest->documents;
                                $Doc = json_decode($loanRequestDocument, true);
                            @endphp

                            @foreach ($Doc as $data)
                                <li>
                                    <label>
                                        <input type="checkbox" class="document-checkbox" name="documentsdata[]"
                                            value="{{ $data['name'] }}" data-name="{{ $data['name'] }}">
                                        {{ $data['name'] }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>


                    <div class="col-12 mt-3">
                        <table class="table table-sm datatableView">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Member Name</th>
                                    <th>Remarks</th>
                                    <th>Member Approve Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($getLoanreqAppData as $loanReq)
                                    @if ($loanReq->requestId == $loanRequest->id)
                                        <td>{{ $count++ }}</td>
                                        <td>
                                            @foreach ($getAllMemberData as $memData)
                                                @if ($memData->id == $loanReq->memberId)
                                                    {{ $memData->firstName }} {{ $memData->lastName }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $loanReq->remarks }}</td>
                                        <td>
                                            @if ($loanReq->selectedOption == 'yes')
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-danger">No</span>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 mt-3 d-flex justify-content-end">
                        <button class="btn btn-primary bn-sm me-2" id="loanRequestApproval">Approve</button>
                        <button class="btn btn-danger bn-sm" id="loanRequestReject">Reject</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--/ Add Loan Request approve Modal -->
<div class="modal fade" id="addLoanRequestAppModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Loan Request Approve Member</h4>
                    <p>Create a new loan request Approve Member</p>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="modalProfessionName">Member</label>
                    <select class="selectize" id="txtMember">
                        <option value="">---Select---</option>
                        @foreach ($getAllMemberData as $member)
                            @if ($loanRequest->memberId != $member->id)
                                @if ($getMember->divisionId == $member->divisionId && $getMember->villageId == $member->villageId)
                                    <option value="{{ $member->id }}">{{ $member->firstName }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-4 d-flex justify-content-center">
                    <label class="me-2">
                        <input type="radio" name="option" value="yes" checked> Yes
                    </label>
                    <label>
                        <input type="radio" name="option" value="no"> No
                    </label>
                </div>

                <div class="col-12 mb-4">
                    <label>Remarks</label>
                    <textarea id="txtRemarks" class="form-control"></textarea>
                </div>

                <div class="col-12 text-center demo-vertical-spacing">
                    <button class="btn btn-primary me-4" id="btnCreateLoanRequestApproveMember">request Approve
                        Member</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add Loan Request approve Modal -->

<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        let isChecked = this.checked;
        document.querySelectorAll('.document-checkbox').forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    });
</script>
