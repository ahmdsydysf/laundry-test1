<x-app-layout :title="config('app.name') . ' | ' . 'تفاصيل طلب ' . $order->order_code ">

    <div id="hide-on-print" class="d-flex justify-content-between align-items-center flex-column flex-md-row mb-4">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="{{ route('orders.index') }}">الطلبات</a> /
            </span>
            تفاصيل طلب</h4>
        <div class="d-flex justify-content-center gap-3 align-items-center">
            <a class="btn btn-primary" href="{{ route('orders.edit', $order) }}">
                <i class='bx bx-edit-alt me-2'></i>
                تعديل الطلب
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">

            <!-- Customer Info -->
            <div class="card mb-4">
                <div class="d-flex align-items-center justify-content-between flex-column flex-md-row">
                    <h5 class="card-header pb-2">معلومات العميل</h5>
                    <a id="hide-on-print" href="{{ route('customers.show',$order->customer) }}" target="_blank"
                       class="btn btn-facebook me-3">
                        <i class='bx bx-history me-2'></i>
                        سجل معاملات العميل
                    </a>
                </div>
                <hr>
                <div class="row gy-2 px-4 card-body">
                    <div class="col-md-6">
                        <span class="fs-5 fw-bold"> رقم العميل: {{ $order->customer->id }}</span>
                    </div>
                    <div class="col-md-6">
                        <span class="fs-5 fw-bold"> الأسم: {{ $order->customer->name }}</span>
                    </div>
                    <div class="col-md-6">
                        <span class="fs-5 fw-bold"> العنوان: {{ $order->customer->address }}</span>
                    </div>
                    <div class="col-md-6">
                        <span class="fs-5 fw-bold"> رقم الهاتف: {{ $order->customer->phone }}</span>
                    </div>
                </div>
            </div>
            <!-- / Customer Info -->

            <!-- Order Status -->
            <div class="card mb-4">
                <h5 class="card-header pb-2">معلومات الطلب</h5>
                <hr>
                <div class="row gy-2 px-4 card-body pt-2">
                    <div class="col-md-4">
                        <span class="fs-5 fw-bold"> كود الطلب: {{ $order->order_code }}</span>
                    </div>
                    <div class="col-md-4">
                        <span class="fs-5 fw-bold"> حاله الطلب: {{ $order->readable_order_status }}</span>
                    </div>
                    <div class="col-md-4">
                        <span class="fs-5 fw-bold"> حاله الدفع: {{ $order->readable_payment_status }}</span>
                    </div>
                </div>
            </div>
            <!-- / Order Status -->

            <!-- Order Details Table -->
            <div class="card mb-4">
                <h5 class="card-header">
                    طلبات العميل
                </h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>الكمية</th>
                                <th>الصنف</th>
                                <th>الخدمة</th>
                                <th>تكلفه الخدمه</th>
                                <th>المجموع</th>
                                <th>التفاصيل</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse ($order->orderDetails as  $detail )
                                <tr>
                                    <td>{{  $detail->quantity }}</td>
                                    <td>{{  $detail->item->name }}</td>
                                    <td>{{  $detail->service->name }}</td>
                                    <td>{{  $detail->price ?? "مؤجل" }}</td>
                                    <td>{{  $detail->total_price ?? "مؤجل" }}</td>
                                    <td>

                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detail-{{ $detail->id }}"
                                        >
                                            التفاصيل
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="detail-{{ $detail->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detail-{{ $detail->id }}Title">التفاصيل</h5>
                                                        <button
                                                            type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close"
                                                        ></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ $detail->description }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6"><strong>لا يوجد بيانات</strong></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- / Order Details Table -->

            <!-- Order Total price -->
            <div class="card">
                <div class="card-header h5 pt-3 pb-2">
                    توع الدفع : {{ $order->readable_payment_type }}
                </div>
                <hr class="py-0">
                <div class="card-body text-center py-2">
                    <div class="row justify-content-center">
                        <div class="col-md-3 d-flex justify-content-center flex-column">
                            <span class="form-label fs-5">اجمالي الفاتوره</span>
                            <span class="fs-5"> {{ $order->total_price }} جنية </span>
                        </div>
                        @if($order->payment_type == \App\Enums\PaymentType::DEFERRED)
                            <hr class="d-md-none">
                            <div class="col-md-3 d-flex justify-content-center flex-column">
                                <span class="form-label fs-5">المدفوع</span>
                                <span class="fs-5"> {{ $order->paid_money }} جنية </span>
                            </div>
                        @endif
                    </div>

                    @if($order->payment_type == \App\Enums\PaymentType::DEFERRED)
                        <hr>
                        <div class="row justify-content-center">
                            <div class="col-md-3 d-flex justify-content-center flex-column">
                                <span class="form-label fs-5">المتبقي</span>
                                <span class="fs-5"> {{ $order->remaining_money }} جنية </span>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            <!-- / Order total price -->

            @if($order->user_id)
                <!--  User -->
                <div class="card mt-4">
                    <h5 class="card-header pb-2">معلومات المسؤول</h5>
                    <hr>
                    <div class="row gy-2 px-4 card-body pt-2">
                        <div class="col-md-6">
                        <span class="fs-5 fw-bold"> الأسم: <a
                                href="{{ route('users.show', $order->user) }}">{{ $order->user->name }}</a></span>
                        </div>
                        <div class="col-md-6">
                        <span
                            class="fs-5 fw-bold"> تاريخ انشاء الطلب: {{ $order->created_at->format('l, Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>
                <!-- / User -->
            @endif

        </div>
    </div>
</x-app-layout>
