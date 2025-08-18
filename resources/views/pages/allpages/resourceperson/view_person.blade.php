<style>
    .view-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
    }
    .view-value {
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        font-size: 0.95rem;
        color: #212529;
    }
    .view-section {
        margin-bottom: 1rem;
    }
    .card-header.custom-header {
        font-size: 1rem;
        letter-spacing: 0.5px;
    }
</style>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-uppercase custom-header bg-primary text-bg-info fw-bold">
                        <i class="ti ti-briefcase-2 me-2"></i> View Resource Person
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 view-section mt-3">
                                <label class="view-label">Full Name</label>
                                <p class="view-value">{{ $getResource->full_name }}</p>
                            </div>
                            <div class="col-md-6 view-section mt-3">
                                <label class="view-label">Division</label>
                                <p class="view-value">
                                    @foreach ($getDivisionData as $div)
                                        @if ($div->id == $getResource->division_id)
                                            {{ $div->divisionName }}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="col-md-6 view-section">
                                <label class="view-label">Village</label>
                                <p class="view-value">
                                    @foreach ($getVillageData as $div)
                                        @if ($div->id == $getResource->village_id)
                                            {{ $div->villageName }}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="col-md-6 view-section">
                                <label class="view-label">Type</label>
                                <p class="view-value">{{ $getResource->type }}</p>
                            </div>
                            <div class="col-md-6 view-section">
                                <label class="view-label">Designation</label>
                                <p class="view-value">{{ $getResource->designation }}</p>
                            </div>
                            <div class="col-md-6 view-section">
                                <label class="view-label">Main Qualification</label>
                                <p class="view-value">
                                    @foreach ($getQualification as $div)
                                        @if ($div->id == $getResource->main_qualification)
                                            {{ $div->qualificationName }}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="col-md-6 view-section">
                                <label class="view-label">Sub Qualification</label>
                                <p class="view-value">
                                    @foreach ($subQualification as $div)
                                        @if ($div->id == $getResource->sub_qualification)
                                            {{ $div->subQualificationName }}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="col-md-6 view-section">
                                <label class="view-label">Date Of Birth</label>
                                <p class="view-value">{{ $getResource->date_of_birth }}</p>
                            </div>
                            <div class="col-md-6 view-section">
                                <label class="view-label">NIC</label>
                                <p class="view-value">{{ $getResource->nic }}</p>
                            </div>
                            <div class="col-md-6 view-section">
                                <label class="view-label">Contact</label>
                                <p class="view-value">{{ $getResource->contact_no }}</p>
                            </div>
                            <div class="col-md-6 view-section">
                                <label class="view-label">Whatsapp</label>
                                <p class="view-value">{{ $getResource->whatsapp_no }}</p>
                            </div>
                            <div class="col-md-6 view-section">
                                <label class="view-label">Address</label>
                                <p class="view-value">{{ $getResource->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
