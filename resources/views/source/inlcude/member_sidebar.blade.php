<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <img src="../../assets/img/logo.png" alt="" height="50" width="70" style="margin-left: 10px;">


        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>

    @php
        $permissions = Auth::user()->permissions;
        $getMemId = Session::get('encMemId');
    @endphp

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item active">
            <a href="/dashboard" class="menu-link ">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>



        <!-- Menu -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Menu">Menu</span>
        </li>

        <li class="menu-item">
            <a href="{{route('show_member', $getMemId)}}" class="menu-link">
                <i class="menu-icon ti ti-user-circle"></i>
                <div data-i18n="View Details">View Details</div>
            </a>
        </li>
    </ul>
</aside>
