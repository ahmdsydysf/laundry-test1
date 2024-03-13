<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand justify-content-center demo">
        <a href="{{ route('overview') }}" class="app-brand-link">
            <img src="{{ $logo ?? asset('assets/img/logo.webp') }}" style="width: 160px" alt="">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->

        <li @class(['menu-item', 'active' => request()->routeIs('customer.profile.*')])>
            <a href="{{ route('customer.profile.show') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">حسابي</div>
            </a>
        </li>

{{--        <li @class(['menu-item mt-2', 'active' => request()->routeIs('customer.order.add')])>--}}
{{--            <a href="{{ route('customer.order.add') }}" class="menu-link">--}}
{{--                <i class='bx bx-cart-add me-2'></i>--}}
{{--                <div data-i18n="Dashboards">إضافه طلب</div>--}}
{{--            </a>--}}
{{--        </li>--}}

    </ul>
</aside>
