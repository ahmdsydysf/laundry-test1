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
        <!-- Overview -->
        <li @class(['menu-item', 'active' => request()->routeIs('overview')])>
            <a href="{{ route('overview') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">نظرة عامة</div>
            </a>
        </li>
        <!-- / Overview -->

        <!-- Customer -->
        <li class="mt-2 menu-item {{ activeMainLi('customers.*') }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class='bx bx-run me-3'></i>
                <div>العملاء</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ activeChildLi('customers.index') }}">
                    <a href="{{ route('customers.index') }}" class="menu-link">
                        <div>قائمة العملاء</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- / Customer -->

        <!-- Orders -->
        <li class="mt-2 menu-item {{ activeMainLi('orders.*') }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class='bx bxs-cart me-3'></i>
                <div>الطلبات</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ activeChildLi('orders.index') }}">
                    <a href="{{ route('orders.index') }}" class="menu-link">
                        <div>قائمة الطلبات</div>
                    </a>
                </li>
                <li class="menu-item {{ activeChildLi('orders.customer.index') }}">
                    <a href="{{ route('orders.customer.index') }}" class="menu-link">
                        <div>قائمة طلبات العملاء</div>
                    </a>
                </li>
                <li class="menu-item {{ activeChildLi('orders.create') }}">
                    <a href="{{ route('orders.create') }}" class="menu-link">
                        <div>إضافة طلب</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Orders -->

        @if (auth()->user()->isAdministrator())
            <li class="menu-header small text-uppercase"><span class="menu-header-text">الضبط و التحكم</span></li>

            <!-- Users -->
            <li class="mt-2 menu-item {{ activeMainLi('users.*') }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class='bx bxs-user me-3'></i>
                    <div>الموظفون</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ activeChildLi('users.index') }}">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <div>قائمة الموظفون</div>
                        </a>
                    </li>
                    <li class="menu-item {{ activeChildLi('users.create') }}">
                        <a href="{{ route('users.create') }}" class="menu-link">
                            <div>إضافة موظف</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Users -->

            <!-- Prices -->
            <li class="mt-2 menu-item {{ activeMainLi('itemServices.*') }} {{ activeMainLi('itemPrices.show') }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class='bx bx-dollar bx-tada me-3'></i>
                    <div>أسعار الخدمات</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ activeChildLi('itemServices.index') }}">
                        <a href="{{ route('itemServices.index') }}" class="menu-link">
                            <div>قائمة أسعار الخدمات</div>
                        </a>
                    </li>
                    <li class="menu-item {{ activeChildLi('itemServices.create') }}">
                        <a href="{{ route('itemServices.create') }}" class="menu-link">
                            <div>إضافة تسعيرة</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Prices -->

            <!-- Items -->
            <li class="mt-2 menu-item {{ activeMainLi('items.*') }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class='bx bx-category-alt me-3'></i>
                    <div>الاصناف</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ activeChildLi('items.index') }}">
                        <a href="{{ route('items.index') }}" class="menu-link">
                            <div>قائمة الاصناف</div>
                        </a>
                    </li>
                    <li class="menu-item {{ activeChildLi('items.create') }}">
                        <a href="{{ route('items.create') }}" class="menu-link">
                            <div>إضافة صنف</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Items -->

            <!-- Services -->
            <li class="mt-2 menu-item {{ activeMainLi('services.*') }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class='bx bx-briefcase-alt-2 me-3'></i>
                    <div>الخدمات</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ activeChildLi('services.index') }}">
                        <a href="{{ route('services.index') }}" class="menu-link">
                            <div>قائمة الخدمات</div>
                        </a>
                    </li>
                    <li class="menu-item {{ activeChildLi('services.create') }}">
                        <a href="{{ route('services.create') }}" class="menu-link">
                            <div>إضافة خدمه</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Services -->

            @if (auth()->user()->isSuperAdmin())
                <!-- Expenses -->
                <li class="mt-2 menu-item {{ activeMainLi('expenses.*') }}">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <i class='bx bx-wallet me-3'></i>
                        <div>المصروفات</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ activeChildLi('expenses.index') }}">
                            <a href="{{ route('expenses.index') }}" class="menu-link">
                                <div>قائمه المصروفات</div>
                            </a>
                        </li>
                        <li class="menu-item {{ activeChildLi('expenses.create') }}">
                            <a href="{{ route('expenses.create') }}" class="menu-link">
                                <div>إضافه مصروف</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Expenses -->

                <!-- Salary -->
                <li class="mt-2 menu-item {{ activeMainLi('salaries.*') }}">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <i class='bx bx-wallet me-3'></i>
                        <div>المرتبات</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ activeChildLi('salaries.index') }}">
                            <a href="{{ route('salaries.index') }}" class="menu-link">
                                <div>قائمه المرتبات</div>
                            </a>
                        </li>
                        <li class="menu-item {{ activeChildLi('salaries.create') }}">
                            <a href="{{ route('salaries.create') }}" class="menu-link">
                                <div>إضافه مرتب</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Salary -->

                <!-- Settings -->
                <li class="mt-2 menu-item {{ activeMainLi('settings.*') }}">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <i class='bx bx-cog bx-spin me-3'></i>
                        <div>إعدادات الموقع</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ activeChildLi('settings.index') }}">
                            <a href="{{ route('settings.index') }}" class="menu-link">
                                <div>الإعدادات</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Settings -->
            @endif
        @endif
    </ul>
</aside>
