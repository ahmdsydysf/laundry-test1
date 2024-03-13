<x-app-layout :title="config('app.name') . ' | ' . 'تفاصيل عميل'">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('customers.index') }}">العملاء</a>
            /</span> تفاصيل عميل
    </h4>

    <div class="card mb-5">
        <div class="d-flex align-items-center justify-content-between flex-column flex-md-row">
            <h5 class="card-header">تفاصيل العميل : {{ $customer->name }}</h5>
            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary me-3">تعديل بيانات العميل</a>
        </div>
        <hr>
        <div class="row gy-3 px-4 card-body">
            <div class="col-md-6">
                <span class="h5"> رقم المسلسل: {{ $customer->id }}</span>
            </div>
            <div class="col-md-6">
                <span class="h5"> الأسم: {{ $customer->name }}</span>
            </div>
            <div class="col-md-6">
                <span class="h5"> العنوان: {{ $customer->address }}</span>
            </div>
            <div class="col-md-6">
                <span class="h5"> رقم الهاتف: {{ $customer->phone }}</span>
            </div>
            <div class="col-md-6">
                <span class="h5"> تاريخ الإضافه: {{ $customer->created_at->diffForHumans() }}</span>
            </div>
        </div>

    </div>
    <div class="card">
        {{-- title table --}}
        <h5 class="card-header">طلبات العميل السابقة ({{ $customer->orders->count() }})</h5>

        <div class="card-body">
            <div class="table-responsive text-nowrap">

                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>الاجمالى</th>
                            <th>حاله الطلب</th>
                            <th>حاله الدفع</th>
                            <th>التحكم</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($customer->orders as $order)
                            <tr>
                                <td>

                                    <strong>
                                        <a href="{{ route('orders.show', $order) }}">{{ $order->order_code }}</a>
                                    </strong>

                                </td>
                                <td>
                                    {{ $order->total_price }}
                                </td>
                                <td><span @class([
                                    'badge me-1',
                                    'bg-label-hover-warning' =>
                                        $order->status === \App\Enums\OrderStatus::PENDING,
                                    'bg-label-hover-primary' =>
                                        $order->status === \App\Enums\OrderStatus::PROCESSING,
                                    'bg-label-hover-success' =>
                                        $order->status === \App\Enums\OrderStatus::COMPLETED,
                                    'bg-label-hover-danger' =>
                                        $order->status === \App\Enums\OrderStatus::CANCELLED,
                                ])>
                                        {{ $order->readable_order_status }}
                                    </span>
                                </td>
                                <td>
                                    <span @class([
                                        'badge me-1',
                                        'bg-label-hover-success' =>
                                            $order->payment_status === \App\Enums\PaymentStatus::PAID,
                                        'bg-label-hover-danger' =>
                                            $order->payment_status === \App\Enums\PaymentStatus::UNPAID,
                                    ])>{{ $order->readable_payment_status }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('orders.edit', $order) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>تعديل</a>

                                            @if (auth()->user()->isSuperAdmin())
                                                <form method="POST" action="{{ route('orders.destroy', $order) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="dropdown-item"
                                                        href="{{ route('orders.destroy', $order) }}"
                                                        style="text-align:start"
                                                        onclick="event.preventDefault(); if (confirm('هل تريد حذف طلب العميل من النظام ؟')) { this.closest('form').submit(); }">
                                                        <i class="bx bx-trash me-1"></i>حذف
                                                    </a>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- If there are no customers -->
                            <tr>
                                <td class="text-center" colspan="6"><strong>لا يوجد بيانات</strong></td>
                                <!-- Table row with a message for no data -->
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination links -->
                <div class="mt-4 px-4">
                    {{ $customer->orders->links() }}
                </div>
            </div>
        </div>

    </div>


</x-app-layout>
