<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <a class = "navbar-brand" href = "/" ><span style = "color:#e4c13f">My Friend </span><span style = "color:#e00b0b"> IT Solution</span></a>
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link c-active" href="/">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/assets/icons/sprites/free.svg#cil-speedometer"></use>
                </svg>@lang('sidebar.dashboard')
            </a>
        </li>
        @guest
        @else
        <li class=" c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#"> @lang('sidebar.booking_module')</a>
            <ul class="c-sidebar-nav-dropdown-items">
<!--                 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.request_order_registration')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.request_order_inquiry')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.virtual_booking_registration')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.virtual_booking_inquiry')</a>
                </li> -->
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/booking/registration">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.booking_registration')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/booking/inquiry">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.booking_inquiry')</a>
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">@lang('sidebar.transportation_module')</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/booking/transport/registration">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.container_booking_registration')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/booking/transport/schedule/registration">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.transport_schedule_registration')</a>
                </li>

<!--                 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.transport_schedule_inquiry')</a>
                </li> -->

                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/advance_money/registration">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.transport_advance_money_registration')</a>
                </li>
            	<li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/advance_money/inquiry">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.transport_advance_money_inquiry')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.transport_refund_money_inquiry')</a>
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">@lang('sidebar.inventory_module')</a>
            <ul class="c-sidebar-nav-dropdown-items"></ul>
        </li>
		<li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">@lang('sidebar.report_module')</a>
            <ul class="c-sidebar-nav-dropdown-items">
            	<li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/report/salary-monthly-driver">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.salary_monthly_driver')</a>
                </li>
            </ul>
        </li>
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">@lang('sidebar.setting_module')</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/customer/registration">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.setting_customer')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/customer/inquiry">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.customer_inquiry')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/employee/registration">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.setting_employee')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/employee/inquiry">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.employee_inquiry')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/fixed_asset/registration">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.setting_fixed_asset')</a>
                </li>
                 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/fixed_asset/inquiry">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.fixed_asset_inquiry')</a>
                </li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/location_code/registration">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.setting_location_code')</a>
                </li>
                 <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/location_code/inquiry">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/assets/icons/sprites/free.svg#cil-book"></use>
                        </svg>@lang('sidebar.location_code_inquiry')</a>
                </li>
            </ul>
        </li>
        @endguest
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
