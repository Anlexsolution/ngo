<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <div class="col-6">
                            <i class="menu-icon ti ti-users-group"></i>Create Meeting
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Meeting Type</label>
                                    <select class="selectize" id="txtMeetingType">
                                        <option value="">---select---</option>
                                        <option value="Group Meeting">Group Meeting</option>
                                        <option value="Village Meeting">Village Meeting</option>
                                        <option value="Division Meeting">Division Meeting</option>
                                        <option value="Other Meeting">Other Meeting</option>
                                        <option value="Awarness Meeting">Awarness Meeting</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3 d-none" id="btnShowDivision">
                                <div class="form-group">
                                    <label>Division</label>
                                    <select id="txtDivision">
                                        <option value="">---Select---</option>
                                        @foreach ($getDivision as $division)
                                            <option value="{{ $division->id }}">{{ $division->divisionName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3 d-none" id="btnShowVIllage">
                                <div class="form-group">
                                    <label>Village</label>
                                    <select id="txtVillage">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3 d-none" id="btnShowSmallgroup">
                                <div class="form-group">
                                    <label>Small Group</label>
                                    <select id="txtSmallGroup">
                                    </select>
                                </div>
                            </div>
                            <hr class="mt-3">
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Meeting Title</label>
                                    <input type="text" class="form-control" id="txtMeetingTitle">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Meeting Date</label>
                                    <input type="date" class="form-control" id="txtMeetingDate">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Meeting Start Time</label>
                                    <input type="time" class="form-control" id="txtMeetingStartTime">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Meeting End Time</label>
                                    <input type="time" class="form-control" id="txtMeetingEndTime">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Resource Person</label>
                                    <select class="selectize" id="txtResourcePerson">
                                        <option value="">---Select---</option>
                                        @foreach ($getAllResourcePerson as $person)
                                            <option value="{{ $person->id }}">{{ $person->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Resource Position</label>
                                    <input type="text" class="form-control" id="txtResourcePosition">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Resource Contact No</label>
                                    <input type="number" class="form-control" id="txtResourceContactNo">
                                </div>
                            </div>
                            <hr class="mt-5">

                            <div id="txtGroupMeetingQustions" class="row d-none">
                                <div class="col-12 d-flex justify-content-center">
                                    <h4 class="text-uppercase fw-bold">Group Meeting Qustions</h4>
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label for="">The Level of the team leaders ability to contasct
                                        meeting</label>
                                    <select class="selectize" id="txtTeamLeadersAbility">
                                        <option value="">---Select---</option>
                                        <option value="Very Good">Very Good</option>
                                        <option value="Good">Good</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Less/Low">Less/Low</option>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label for="">Account Statement</label>
                                    <input type="text" class="form-control" id="txtAccountStatement">
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label for="">Activity Statement</label>
                                    <input type="text" class="form-control" id="txtActivityStatement">
                                </div>
                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>Has a decision been made?</label>
                                    <div>
                                        <label class="me-3">
                                            <input type="radio" name="decision" value="yes"
                                                onclick="updateReasonLabel('Please explain your decision')"> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="decision" value="no"
                                                onclick="updateReasonLabel('Please explain why not')"> No
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3" id="reasonContainer">
                                    <label for="reason" id="reasonLabel">Reason</label>
                                    <textarea name="reason" class="form-control" rows="3" id="txtDecisionReson" placeholder="Enter reason here"></textarea>
                                </div>
                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>Group Activity Explaination</label>
                                    <textarea id="txtGroupActivity" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>Reson for not doing team work</label>
                                    <textarea id="txtResonFOrNotDoingTeamWork" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label for="">
                                        How interested is the member in the group meeting?</label>
                                    <select class="selectize" id="txtMemberInterstingGroupMeeting">
                                        <option value="">---Select---</option>
                                        <option value="Very Good">Very Good</option>
                                        <option value="Good">Good</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Less/Low">Less/Low</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>Effect For Team Work</label>
                                    <textarea id="txtEffectForTeamWork" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>
                                        Area Manager's opinion</label>
                                    <textarea id="txtAreaManageOpinion" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>
                                        Regional Manager's Feedback</label>
                                    <textarea id="txtRegionalManagerFeedback" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            <div id="txtVillageMeetingQustions" class="row d-none">
                                <div class="col-12 d-flex justify-content-center">
                                    <h4 class="text-uppercase fw-bold">Village Meeting Qustions</h4>
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>The meeting is start by branch manager ?</label>
                                    <div>
                                        <label class="me-3">
                                            <input type="radio" name="meetingBranchManager" value="yes"> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="meetingBranchManager" value="no"> No
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label for="">The level of branch leader's ability to conduct meeting
                                    </label>
                                    <select class="selectize" id="txtLevelOfBranchLeader">
                                        <option value="">---Select---</option>
                                        <option value="Very Good">Very Good</option>
                                        <option value="Good">Good</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Less/Low">Less/Low</option>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>communique has been read?</label>
                                    <div>
                                        <label class="me-3">
                                            <input type="radio" name="communiqueRead" value="yes"> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="communiqueRead" value="no"> No
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>account statement has been read?</label>
                                    <div>
                                        <label class="me-3">
                                            <input type="radio" name="accountStatementRead" value="yes"> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="accountStatementRead" value="no"> No
                                        </label>
                                    </div>
                                </div>



                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>arrears has been discussed?</label>
                                    <div>
                                        <label class="me-3">
                                            <input type="radio" name="arreasDiscuss" value="yes"> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="arreasDiscuss" value="no"> No
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>number of loan applies</label>
                                    <input type="number" class="form-control" id="txtLoanApplies">
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>any important discussion??</label>
                                    <textarea class="form-control" rows="3" id="txtImportantDiscuss"></textarea>
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>
                                        Regional Manager's Feedback</label>
                                    <textarea id="txtRegionalManagerFeedbackVilage" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            <div id="txtAwarnessMeetingQustions" class="row d-none">
                                <div class="col-12 d-flex justify-content-center">
                                    <h4 class="text-uppercase fw-bold">Awarness Meeting Qustions</h4>
                                </div>


                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>
                                        awareness training heading</label>
                                    <input type="text" class="form-control" id="txtAwarnessTrainingHeading">
                                </div>

                                 <div class="col-sm-12 col-md-6 mt-3">
                                    <label>number of participants</label>
                                    <input type="number" class="form-control" id="NumberOfParticipation">
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>purpose of awareness training</label>
                                    <textarea class="form-control" rows="3" id="txtAwarnessTraining"></textarea>
                                </div>



                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>Resource person name, position and conduct number</label>
                                    <textarea class="form-control" rows="3" id="txtResourcePersonDetails"></textarea>
                                </div>



                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>topic discussed</label>
                                    <textarea class="form-control" rows="3" id="txtTopicDiscss"></textarea>
                                </div>

                                <div class="col-sm-12 col-md-6 mt-3">
                                    <label>participants opinion</label>
                                    <textarea class="form-control" rows="3" id="txtParticipationOpinion"></textarea>
                                </div>


                            </div>

                            <hr class="mt-5">
                            <table class="table table-striped" id="showMember">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Member Name</th>
                                        <th>NIC</th>
                                        <th>Old Account Number</th>
                                        <th>Attendance</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="col-12 mt-3 d-flex justify-content-end">
                                <button class="btn btn-primary" id="btnSaveMeeting">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateReasonLabel(text) {
        document.getElementById("reasonLabel").innerText = text;
    }
</script>
