\

<div class="row mt-3">
    <div class="col-6">
        <label for="txtMapLattitude" class="form-label">Google Maps URL Latitude</label>
        <input type="text" class="form-control" id="txtMapLattitude" value="{{ $getMemberData->latitude }}">
    </div>
     <div class="col-6">
        <label for="txtMapLongitude" class="form-label">Google Maps URL Longitude</label>
        <input type="text" class="form-control" id="txtMapLongitude" value="{{ $getMemberData->longitude }}">
    </div>
    <div class="col-12 d-flex justify-content-end mt-3">
        <button class="btn btn-primary btn-sm" id="btnSaveLocation">Save Location</button>
    </div>

    <hr class="mt-3">

    <div class="col-12 mt-3">
        <h5>Map Preview:</h5>
        <div class="map-fullscreen">
            <iframe loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps?q={{ $getMemberData->latitude }},{{ $getMemberData->longitude }}&hl=es;z=14&output=embed">
            </iframe>
        </div>

    </div>
</div>
