<x-app-layout :title="config('app.name') . ' | ' . 'نظرة عامة'">
    <div class="row">
        <!-- Welcoming -->
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">مرحبا {{ auth()->user()->name }} 🎉</h5>
                            <p class="mb-4">
                                نتمني لك يوم عمل رائع !
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                                height="140"
                                alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Welcoming -->

        @if(auth()->user()->isSuperAdmin())
            <!-- Daily Orders Statistics -->
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img
                                            src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                                            alt="chart success"
                                            class="rounded"
                                        />
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">عدد طلبات اليوم</span>
                                <h3 class="card-title my-2">{{ $daily_orders_count }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img
                                            src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}"
                                            alt="Credit Card"
                                            class="rounded"
                                        />
                                    </div>
                                </div>
                                <span>عائدات  طلبات اليوم</span>
                                <h3 class="card-title text-nowrap my-2">{{ $daily_paid_sum }} جنيه </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Daily Orders Statistics -->

            <!-- Services Statistics -->
            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-8">
                            <h5 class="card-header">ترتيب الخدمات المطلوبه اليوم</h5>
                            <hr class="my-1">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center">
                                    <span>الخدمه</span>
                                    <span>عدد مرات الطلب</span>
                                </div>


                                <ul class="p-0 m-0">

                                    @forelse($daily_services_count as $service_name  => $service_count)
                                        <hr>
                                        <li class="d-flex mb-4 pb-1">
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0">{{ $service_name }}</h6>
                                                </div>
                                                <div class="user-progress d-flex align-items-center gap-1">
                                                    <h6 class="mb-0">{{ $service_count }}</h6>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <hr>
                                        <li class="d-flex mb-4 pb-1">
                                            <div
                                                class="d-flex w-100 align-items-center justify-content-center">
                                                لا يوجد بيانات حتي الان
                                            </div>
                                        </li>
                                        <hr>
                                    @endforelse

                                </ul>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <h5 class="card-header m-0 me-2 pb-3">الخدمات المطلوبه اليوم</h5>

                            <div>
                                {!! $services_chart->render() !!}
                            </div>
                            <div class="text-center fw-semibold pt-3 mb-2">الخدمات المطلوبه</div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- / Services Statistics -->

            <!-- Total Revenue -->
            <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class='bx bxs-t-shirt' style="font-size: 30px; color: red"></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">طلبات قيد العمل</span>
                                <h3 class="card-title my-2">{{ $daily_pending_count }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class='bx bxs-t-shirt' style="font-size: 30px; color: green"></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">طلبات تنتظر التسليم</span>
                                <h3 class="card-title my-2">{{ $daily_completed_count }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card"
                                             class="rounded"/>
                                    </div>
                                </div>
                                <span class="d-block mb-1">عائدات طلبات الاسبوع</span>
                                <h3 class="card-title text-nowrap my-2">{{ $weekly_paid_sum }} جنيه</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card"
                                             class="rounded"/>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">عائدات طلبات الشهر</span>
                                <h3 class="card-title my-2">{{ $monthly_paid_sum }} جنيه</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Revenue -->
        @endif
    </div>

    @if(auth()->user()->isSuperAdmin())
        <div class="row">
            <!-- Order Statistics -->
            <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>إحصائيات الطلبات</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center mb-5">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h2 class="mb-2">{{ $monthly_orders_count }}</h2>
                                <span>الطلبات خلال الشهر</span>
                            </div>
                        </div>
                        <hr>
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-1">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h5 class="mb-0">اليوم</h5>
                                    </div>
                                    <h5 class="fw-semibold mb-0">{{ $daily_orders_count }}</h5>
                                </div>
                            </li>
                            <hr>
                            <li class="d-flex mb-4 pb-1">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h5 class="mb-0">الاسبوع</h5>
                                    </div>
                                    <h5 class="fw-semibold mb-0">{{ $weekly_orders_count }}</h5>
                                </div>
                            </li>
                            <hr>
                            <li class="d-flex mb-4 pb-1">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h5 class="mb-0">الشهر</h5>
                                    </div>
                                    <h5 class="fw-semibold mb-0">{{ $monthly_orders_count }}</h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Order Statistics -->

            <!-- New Customers -->
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">العملاء الجدد</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center mb-5">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h2 class="mb-2">{{ $new_monthly_customer_count }}</h2>
                                <span>العملاء الجدد خلال الشهر</span>
                            </div>
                        </div>
                        <hr>
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-1">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h5 class="mb-0">اليوم</h5>
                                    </div>
                                    <h5 class="fw-semibold mb-0">{{ $new_daily_customer_count }}</h5>
                                </div>
                            </li>
                            <hr>
                            <li class="d-flex mb-4 pb-1">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h5 class="mb-0">الاسبوع</h5>
                                    </div>
                                    <h5 class="fw-semibold mb-0">{{ $new_weekly_customer_count }}</h5>
                                </div>
                            </li>
                            <hr>
                            <li class="d-flex mb-4 pb-1">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h5 class="mb-0">الشهر</h5>
                                    </div>
                                    <h5 class="fw-semibold mb-0">{{ $new_monthly_customer_count }}</h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ New Customers -->

            <!-- Profit -->
            <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class='bx bx-money' style="font-size: 30px;"></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">عائدات الاسبوع</span>
                                <h3 class="card-title my-2">{{ $weekly_profit }} جنيه</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class='bx bx-money' style="font-size: 30px;"></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">عائدات الشهر</span>
                                <h3 class="card-title my-2">{{ $monthly_profit }} جنيه</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col text-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card"
                                             class="rounded"/>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">عائدات السنه</span>
                                <h3 class="card-title my-2">{{ $yearly_profit }} جنيه</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Profit -->
        </div>
   @endif
</x-app-layout>
