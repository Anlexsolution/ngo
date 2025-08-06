<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Manage Collection Deposit</title>
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
            {{-- CSRF Token Get --}}
            <meta name="csrf-token" content="{{ csrf_token() }}">
            {{-- CSRF Token Get --}}
            <div class="layout-page">
                @include('source.inlcude.superadmintopbar')
                @if ($userType == 'superAdmin')
                    @include('pages.allpages.otherincome.manage_other_incomes')
                @else
                    @php
                        $userRolesArray = $getUserRole->pluck('roleName')->toArray();
                    @endphp

                    @if (in_array($userType, $userRolesArray))
                        @php
                            $usersDataPer = $permissions;
                            $usersDataPer = json_decode($usersDataPer, true);
                        @endphp

                        @if (in_array('manageIncome', $usersDataPer))
                            @include('pages.allpages.otherincome.manage_other_incomes')
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
    {{-- CSRF Token Get --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- CSRF Token Get --}}
    @include('source.footer')
    @include('source.inlcude.loader')
</body>

</html>
