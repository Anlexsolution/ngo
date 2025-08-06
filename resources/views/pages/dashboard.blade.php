<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard</title>
    @include('source.header')
</head>
@php
    $userType = Auth::user()->userType;
@endphp

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @if ($userType == 'member')
                {{-- @include('source.inlcude.member_sidebar') --}}
            @else
                @include('source.inlcude.superadminsidebar')
            @endif


            <div class="layout-page">
                @if ($userType == 'member')
                 @include('source.inlcude.superadmintopbar')
                    @include('pages.dashboard.member_dashboard')
                @else
                    @include('source.inlcude.superadmintopbar')
                    @include('pages.dashboard.superadmindashboard')
                @endif
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    @include('source.footer')
</body>

</html>
