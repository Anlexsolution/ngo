<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>View Member</title>
    @include('source.header')
</head>
@php
    $userType = Auth::user()->userType;
    $permissions = Auth::user()->permissions;
    $memberPermision = Auth::user()->memberPermision;
@endphp

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @if ($userType == 'member')
                @include('source.inlcude.member_sidebar')
            @else
                @include('source.inlcude.superadminsidebar')
            @endif
            {{-- CSRF Token Get --}}
            <meta name="csrf-token" content="{{ csrf_token() }}">
            {{-- CSRF Token Get --}}
            <div class="layout-page">
                @include('source.inlcude.superadmintopbar')
                @if ($userType == 'superAdmin')
                    @include('pages.allpages.memberpages.view_savings_histories')
                @else
                    @php
                        $userRolesArray = $getUserRole->pluck('roleName')->toArray();
                    @endphp

                    @if (in_array($userType, $userRolesArray))
                        @php
                            $usersDataPer = $permissions;
                            $usersDataPer = json_decode($usersDataPer, true);
                        @endphp

                        @if (in_array('ManageMember', $usersDataPer) || in_array('viewMember', $usersDataPer))
                            @include('pages.allpages.memberpages.view_savings_histories')
                        @elseif($userType == 'member')
                            @include('pages.allpages.memberpages.view_savings_histories')
                        @else
                            @include('pages.allpages.401')
                        @endif
                    @elseif($userType == 'member')
                        @include('pages.allpages.memberpages.view_savings_histories')
                    @else
                        @include('pages.allpages.401')
                    @endif
                @endif
                @include('source.inlcude.loader')
                @include('source.pagefooter')
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    @include('source.footer')
</body>

</html>
