<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="assets/brand/coreui.svg#full"></use>
        </svg>
        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="assets/brand/coreui.svg#signet"></use>
        </svg>
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link c-active" href="/">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="assets/icons/sprites/free.svg#cil-speedometer"></use>
                </svg>@lang('sidebar.dashboard')
            </a>
        </li>
        <li class=" c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#"> @lang('sidebar.booking_module')</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.request_order_registration')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.request_order_inquiry')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.virtual_booking_registration')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.virtual_booking_inquiry')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.booking_registration')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.booking_inquiry')</a>
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">@lang('sidebar.transportation_module')</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.container_booking_registration')</a>
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">@lang('sidebar.inventory_module')</a>
            <ul class="c-sidebar-nav-dropdown-items"></ul>
        </li>

        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">@lang('sidebar.setting_module')</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.setting_customer')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.setting_container')</a>
                </li>
            </ul>
        </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
