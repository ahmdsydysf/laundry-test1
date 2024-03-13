<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">الطلبات /</span> قائمة طلبات العملاء</h4>

    @session('success-msg')
    <div
            x-data
            x-init="setTimeout(()=> $el.remove(),3000)"
            class="mb-3">
        <div class="alert alert-info alert-dismissible fade show text-dark" role="alert">
            <strong>{{ $value }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endsession

    @session('error-msg')
    <div
            x-data
            x-init="setTimeout(()=> $el.remove(),3000)"
            class="mb-3">
        <div class="alert alert-danger alert-dismissible fade show text-dark" role="alert">
            <strong>{{ $value }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endsession

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-header">الطلبات</h5>
            <a href="{{ route('orders.create') }}" class="btn btn-primary me-3">إضافة طلب</a>
        </div>

        <!-- Filter Inputs -->
        <div class="mb-4 px-3 row align-items-center">
            <div class="col-md-6">
                <label for="search" class="form-label">
                    بحث
                    <i class='ms-2 bx bx-loader-circle bx-spin' wire:loading wire:target="search"></i>
                </label>
                <input id="search" class="form-control mt-1" wire:model.live.debounce.500ms="search"
                       placeholder="أدخل كود الطلب او رقم العميل او اسم العميل او تليفون العميل">
            </div>
        </div>
        <!-- / Filter Inputs -->

        <!-- Orders Table with pagination -->
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>كود الطلب</th>
                    <th>اسم العميل</th>
                    <th>قيمة الفاتورة</th>
                    <th>تاريخ إنشاء الطلب</th>
                    <th>التحكم</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @forelse($orders as $order)
                    <tr wire:key="{{ $order->order_code }}">
                        <td>
                            <a href="{{ route('orders.show', $order) }}">
                                <strong
                                        @class([
                                                'text-warning' => $order->has_deferred_payment
                                            ])
                                >{{ $order->order_code }}</strong>
                            </a>
                        </td>
                        <td><a href="{{ route('customers.show', $order->customer) }}">{{  $order->customer->name }}</a>
                        </td>
                        <td>{{  $order->total_price }} جنية</td>
                        <td>
                            {{ $order->created_at->diffForHumans() }}
                        </td>

                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">

                                    <button class="dropdown-item" wire:confirm="هل تريد إضافه الطلب ؟"  wire:click="addToOrders({{ $order->id }})">
                                        <i class='bx bx-cart-add me-1'></i>
                                        إضافه الي الطلبات
                                    </button>

                                    <a class="dropdown-item" href="{{ route('orders.edit',$order) }}"><i
                                                class="bx bx-edit-alt me-1"></i>تعديل</a>

                                    <button wire:click="deleteOrder({{ $order->id }})"
                                            wire:confirm="هل تريد حذف الطلب ؟" class="dropdown-item">
                                        <i class="bx bx-trash me-1"></i>حذف
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5"><strong>لا يوجد بيانات</strong></td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3 px-3 d-flex justify-content-end">
                {{ $orders->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
        <!-- /Orders Table with pagination -->
    </div>
</div>
