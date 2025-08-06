<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> Manage Account Settings
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Collection Account</label>
                                    <select class="selectize" id="txtSelectCollectionAccount">
                                        <option value="">---Select---</option>
                                        @foreach ($getAccountData as $account)
                                            @if ($getcountaccount != null && $getcountaccount != '')
                                                @if ($getcountaccount->accountId == $account->id)
                                                    <option value="{{ $account->id }}" selected>{{ $account->name }} (
                                                        @if ($account->balance == '')
                                                            0
                                                        @else
                                                            {{ number_format($account->balance, 2) }}
                                                        @endif)
                                                    </option>
                                                @else
                                                    <option value="{{ $account->id }}">{{ $account->name }} (
                                                        @if ($account->balance == '')
                                                            0
                                                        @else
                                                            {{ number_format($account->balance, 2) }}
                                                        @endif)
                                                    </option>
                                                @endif
                                            @else
                                                <option value="{{ $account->id }}">{{ $account->name }} (
                                                    @if ($account->balance == '')
                                                        0
                                                    @else
                                                        {{ number_format($account->balance, 2) }}
                                                    @endif)
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end mt-3">
                                <button class="btn btn-primary btn-sm" id="btnUpdateAccount">Update Account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
