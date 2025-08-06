<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="menu-icon ti ti-users-plus"></i> Assign Division
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form action="/updateuserdivisiondata" method="POST">
                                @csrf
                                @if ($errors->any())
                                    <div class="row">
                                        {!! implode(
                                            '',
                                            $errors->all('<div class="mt-3 alert alert-danger col-sm-12 col-md-12" role="alert">:message</div>'),
                                        ) !!}
                                    </div>
                                @endif

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
                                    <div class="col-md-4 col-sm-12 mt-3">
                                        <div class="form-group">
                                            <label class="fw-bold">Name</label>
                                            <p class="ml-3">{{ $users->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end col-sm-12 mt-3">
                                        <div class="form-group">
                                            <label class="fw-bold">Email</label>
                                            <p class="ml-3">{{ $users->email }}</p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="userId" id="userId" class="form-control"
                                        value="{{ $users->id }}">
                                    <input type="hidden" name="userVillage" id="userVillage" class="form-control"
                                        value="{{ $users->village }}">

                                    <div class="row">
                                        <label for="assignDivisionId" class="form-label fw-bold">Select Division &
                                            Village</label>
                                        @foreach ($getDivision as $division)
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input division-checkbox" type="checkbox"
                                                        name="permissionsDivision[]" value="{{ $division->id }}"
                                                        id="division-{{ $division->id }}"
                                                        @if ($users->division == '' || $users->division == null) @elseif (in_array($division->id, json_decode($users->division, true))) checked @endif>
                                                    <label class="form-check-label" for="division-{{ $division->id }}">
                                                        {{ $division->divisionName }}
                                                    </label>
                                                </div>
                                                @foreach ($getVillage as $village)
                                                    @if ($village->divisionId == $division->id)
                                                        <div class="form-check ms-4">
                                                            <input
                                                                class="form-check-input village-checkbox division-{{ $division->id }}-village"
                                                                type="checkbox" name="permissionsVillage[]"
                                                                value="{{ $village->id }}"
                                                                id="village-{{ $village->id }}" @if ($users->village == '' || $users->village == null || $users->village == "null") @elseif (in_array($village->id, json_decode($users->village, true))) checked @endif>
                                                            <label class="form-check-label"
                                                                for="village-{{ $village->id }}">
                                                                {{ $village->villageName }}
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>


                                    <div class="row mt-3">
                                        <label  class="form-label fw-bold">Member Permission</label>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input division-checkbox" type="checkbox"
                                                    name="permissionsMember[]" value="savings"
                                                    @if ($users->memberPermision != null || $users->memberPermision != '')
                                                    @if ($users->memberPermision && in_array('savings', (array) json_decode($users->memberPermision, true)))
                                                            checked
                                                        @endif
                                                    @endif
                                                    />
                                                <label class="form-check-label" >
                                                   Savings
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input division-checkbox" type="checkbox"
                                                    name="permissionsMember[]" value="loan"
                                                    @if ($users->memberPermision != null || $users->memberPermision != '')
                                                    @if ($users->memberPermision && in_array('loan', (array) json_decode($users->memberPermision, true)))
                                                        checked
                                                    @endif
                                                @endif />
                                                <label class="form-check-label" >
                                                   Loan
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input division-checkbox" type="checkbox"
                                                    name="permissionsMember[]" value="death"  @if ($users->memberPermision != null || $users->memberPermision != '')
                                                    @if ($users->memberPermision && in_array('death', (array) json_decode($users->memberPermision, true)))
                                                        checked
                                                    @endif
                                                @endif/>
                                                <label class="form-check-label" >
                                                   Death
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input division-checkbox" type="checkbox"
                                                    name="permissionsMember[]" value="meetings"  @if ($users->memberPermision != null || $users->memberPermision != '')
                                                    @if ($users->memberPermision && in_array('meetings', (array) json_decode($users->memberPermision, true)))
                                                        checked
                                                    @endif
                                                @endif/>
                                                <label class="form-check-label" >
                                                   Meetings
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input division-checkbox" type="checkbox"
                                                    name="permissionsMember[]" value="documents"  @if ($users->memberPermision != null || $users->memberPermision != '')
                                                    @if ($users->memberPermision && in_array('documents', (array) json_decode($users->memberPermision, true)))
                                                        checked
                                                    @endif
                                                @endif/>
                                                <label class="form-check-label" >
                                                   Documents
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input division-checkbox" type="checkbox"
                                                    name="permissionsMember[]" value="notes"  @if ($users->memberPermision != null || $users->memberPermision != '')
                                                    @if ($users->memberPermision && in_array('notes', (array) json_decode($users->memberPermision, true)))
                                                        checked
                                                    @endif
                                                @endif/>
                                                <label class="form-check-label" >
                                                   Notes
                                                </label>
                                            </div>
                                             <div class="form-check">
                                                <input class="form-check-input division-checkbox" type="checkbox"
                                                    name="permissionsMember[]" value="login"  @if ($users->memberPermision != null || $users->memberPermision != '')
                                                    @if ($users->memberPermision && in_array('login', (array) json_decode($users->memberPermision, true)))
                                                        checked
                                                    @endif
                                                @endif/>
                                                <label class="form-check-label" >
                                                   Login Details
                                                </label>
                                            </div>
                                               <div class="form-check">
                                                <input class="form-check-input division-checkbox" type="checkbox"
                                                    name="permissionsMember[]" value="location"  @if ($users->memberPermision != null || $users->memberPermision != '')
                                                    @if ($users->memberPermision && in_array('location', (array) json_decode($users->memberPermision, true)))
                                                        checked
                                                    @endif
                                                @endif/>
                                                <label class="form-check-label" >
                                                   Location
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 text-center d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-primary me-3"
                                            value="updateuserdivisiondata">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const divisionCheckboxes = document.querySelectorAll('.division-checkbox');

        divisionCheckboxes.forEach(function(divisionCheckbox) {
            divisionCheckbox.addEventListener('change', function() {
                const divisionId = this.id.replace('division-', '');
                const villageCheckboxes = document.querySelectorAll('.division-' + divisionId +
                    '-village');

                villageCheckboxes.forEach(function(villageCheckbox) {
                    villageCheckbox.checked = divisionCheckbox.checked;
                });
            });
        });
    });
</script>
