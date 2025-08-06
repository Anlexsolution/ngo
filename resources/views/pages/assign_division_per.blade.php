<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Manage Users</title>
    @include('source.header')
</head>
@php
    $userType = Auth::user()->userType;
    $permissions = Auth::user()->permissions;
@endphp

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('source.inlcude.superadminsidebar')

            <div class="layout-page">
                @include('source.inlcude.superadmintopbar')
                @if ($userType == 'superAdmin')
                    @include('pages.allpages.assign_division')
                @else
                    @php
                        $userRolesArray = $getUserRole->pluck('roleName')->toArray();
                    @endphp

                    @if (in_array($userType, $userRolesArray))
                        @php
                            $usersDataPer = $permissions;
                            $usersDataPer = json_decode($usersDataPer, true);
                        @endphp

                        @if (in_array('manageUsers', $usersDataPer))
                            @include('pages.allpages.assign_division')
                        @else
                            @include('pages.allpages.401')
                        @endif
                    @else
                        @include('pages.allpages.401')
                    @endif
                @endif
                @include('source.pagefooter')
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    @include('source.footer')
    <script>
        $(document).ready(function() {
            $('#userId').hide();
            var divisionSelect = $('#assignDivisionId').selectize({
                maxItems: null,
            });


            $('#assignDivisionId').trigger('change');
        });

        $('body').on('change', '#assignDivisionId', function() {
            var divisionId = $('#assignDivisionId').val();
            if($('#userVillage').val() == ''){
                var userVillage = '';
            }else{
                var userVillage = JSON.parse($('#userVillage').val());
            }
           console.log(userVillage)
            var villageSelect = $('#assignVillageId').selectize({
                maxItems: null,
            });
            var villageSelectize = villageSelect[0].selectize;
            villageSelectize.clearOptions();
            villageSelectize.addOption({
                value: "",
                text: "Select Village",
                disabled: true
            });

            divisionId.forEach(function(id) {
                if (id) {

                    fetch(`/get-villages/${id}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.length) {

                                data.forEach(function(village) {

                                    if (userVillage == '' || userVillage == null) {
                                        const villageIdString = String(village
                                        .id);
                                        villageSelectize.addOption({
                                            value: villageIdString,
                                            text: village.villageName
                                        });
                                    } else {
                                        const villageIdString = String(village
                                            .id);
                                        if (userVillage.includes(villageIdString)) {
                                            villageSelectize.addOption({
                                                value: villageIdString,
                                                text: village.villageName
                                            });
                                            villageSelectize.addItem(villageIdString);
                                        } else {
                                            villageSelectize.addOption({
                                                value: villageIdString,
                                                text: village.villageName
                                            });
                                        }
                                    }
                                });

                            }
                            villageSelectize.refreshOptions();
                        })
                        .catch(error => {
                            console.error('Error fetching villages:', error);

                            alert('Failed to load villages. Please try again later.');
                        });
                } else {

                    villageSelectize.refreshOptions();
                }
            });

        });
    </script>
</body>

</html>
