<div class="row">
    <input type="text" class="form-control" id="txtMemberIdGet" name="txtMemberId" value="{{ $memberId }}" hidden />
    @if ($getMemberData->login == 0)
       
        <div class="col-sm-12 col-md-6">
            <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password_confirmation">Confirm
                    Password</label>
                <div class="input-group input-group-merge">
                    <input type="password" id="confirmPassword" class="form-control" name="confirm-password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="confirmPassword" />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
            </div>
        </div>



        <div class="col mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" id="btnCreateMemberUser">Create
                User</button>
        </div>
    @else
    <div class="col-12 d-flex justify-content-center">
        <div class="form-group">
            <label>This member login password</label>
            <h5>{{$getMemberData->password}}</h5>
        </div>
    </div>
    @endif
</div>
