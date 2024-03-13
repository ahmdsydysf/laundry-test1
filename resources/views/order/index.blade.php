<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">الطلبات /</span> قائمة الطلبات</h4>

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
            <div class="col-md-4">
                <label for="search" class="form-label">
                    بحث
                    <i class='ms-2 bx bx-loader-circle bx-spin' wire:loading wire:target="search"></i>
                </label>
                <input id="search" class="form-control mt-1" wire:model.live.debounce.500ms="search"
                       placeholder="أدخل كود الطلب او رقم العميل او اسم العميل او تليفون العميل">
            </div>

            <div class="mb-2 mb-md-0 col-md-4">
                <label for="order-status"
                       class="form-label">
                    حاله الطلب
                    <i class='ms-2 bx bx-loader-circle bx-spin' wire:loading wire:target="orderStatus"></i>
                </label>

                <div>
                    <select id="order-status" class="form-select" wire:model.live="orderStatus">
                        <option value>الكل</option>
                        @foreach ( \App\Models\Order::statusValues() as $key => $value )
                            <option wire:key="{{ 'Order-'. $key }}" value="{{ $key }}">
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <label for="order-payment-status"
                       class="form-label">
                    حاله الدفع
                    <i class='ms-2 bx bx-loader-circle bx-spin' wire:loading wire:target="paymentStatus"></i>
                </label>

                <div>
                    <select id="order-payment-status" class="form-select" wire:model.live="paymentStatus">
                        <option value>الكل</option>
                        @foreach ( \App\Models\Order::paymentStatusValues() as $key => $value )
                            <option wire:key="{{ 'Payment-'. $key }}" value="{{ $key }}">
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!-- / Filter Inputs -->

        <!-- Reset Filters Button -->
        <div x-show="$wire.search || $wire.orderStatus || $wire.paymentStatus" x-transition x-cloak class="mb-3 px-3">
            <button class="btn btn-linkedin" wire:click="clearFilters">إلغاء الفلاتر</button>
        </div>
        <!-- / Reset Filters Button -->

        <!-- Orders Table with pagination -->
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>كود الطلب</th>
                    <th>اسم العميل</th>
                    <th>حالة الطلب</th>
                    <th>حالة الدفع</th>
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
                        <td wire:key="{{ rand() }}" x-data="{ showBadge:true}" @click="showBadge = false"
                            @click.outside="showBadge = true">

                            <label x-show="!showBadge" x-cloak for="orderStatus">
                                <select id="orderStatus" class="form-select"
                                        @change="$wire.changeStatus( '{{ $order->id }}' , $el.value )">
                                    @foreach ( \App\Models\Order::statusValues() as $key => $value )
                                        <option @selected($key == $order->status->value) value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <span x-show="showBadge" x-cloak @class([
                                    'badge me-1',
                                    'bg-label-hover-warning' => $order->status ===  \App\Enums\OrderStatus::PENDING,
                                    'bg-label-hover-primary' => $order->status ===  \App\Enums\OrderStatus::PROCESSING,
                                    'bg-label-hover-success' => $order->status ===  \App\Enums\OrderStatus::COMPLETED,
                                    'bg-label-hover-danger' => $order->status === \App\Enums\OrderStatus::CANCELLED,
                                ])>
                                {{  $order->readable_order_status }}
                                </span>

                        </td>
                        <td wire:key="{{ rand() }}" x-data="{ showBadge:true}" @click="showBadge = false"
                            @click.outside="showBadge = true">

                            <label x-show="!showBadge" x-cloak for="paymentStatus">
                                <select id="paymentStatus" class="form-select"
                                        @change="$wire.changePaymentStatus('{{ $order->id }}', $el.value )">
                                    @foreach ( \App\Models\Order::paymentStatusValues() as $key => $value )
                                        <option @selected($key == $order->payment_status->value)  value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <span x-show="showBadge" x-cloak @class([
                                'badge me-1',
                                'bg-label-hover-success' => $order->payment_status ===  \App\Enums\PaymentStatus::PAID,
                                'bg-label-hover-danger' => $order->payment_status === \App\Enums\PaymentStatus::UNPAID,
                            ])>{{  $order->readable_payment_status }}</span>
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

                                    <a class="dropdown-item" href="{{ route('orders.edit',$order) }}"><i
                                                class="bx bx-edit-alt me-1"></i>تعديل</a>

                                    @if(auth()->user()->isSuperAdmin())
                                        <button wire:click="deleteOrder({{ $order->id }})"
                                                wire:confirm="هل تريد حذف الطلب ؟" class="dropdown-item">
                                            <i class="bx bx-trash me-1"></i>حذف
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="8"><strong>لا يوجد بيانات</strong></td>
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
