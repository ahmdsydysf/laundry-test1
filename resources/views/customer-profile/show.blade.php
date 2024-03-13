<x-customer-layout :title="config('app.name') . ' | ' . 'بيانات الحساب'">
    <!-- Basic Bootstrap Table -->
    <div class="card mb-5">
        <div class="d-flex align-items-center justify-content-between flex-column flex-md-row">
            <h5 class="card-header">تفاصيل حساب : {{ $customer->name }}</h5>
            <a href="{{ route('customer.profile.edit') }}" class="btn btn-primary me-3">تعديل البيانات </a>
        </div>
        <hr>
        <div class="row gy-2 px-4 card-body">
            <div class="col-md-6">
                <h5> رقم المسلسل: {{ $customer->id }}</h5>
            </div>
            <div class="col-md-6">
                <h5> الأسم: {{ $customer->name }}</h5>
            </div>
            <div class="col-md-6">
                <h5> العنوان: {{ $customer->address }}</h5>
            </div>
            <div class="col-md-6">
                <h5> رقم الهاتف: {{ $customer->phone }}</h5>
            </div>
        </div>
        <!-- A div for making the table horizontally scrollable -->


    </div>
    <div class="card">
        {{-- title table --}}
        <h5 class="card-header">طلباتك السابقة ({{ $orders->count() }})</h5>

        <div class="card-body">
            <!-- A div for making the table horizontally scrollable -->
            <div class="table-responsive text-nowrap">

                <!-- The table element with Bootstrap classes for styling -->
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>الاجمالى</th>
                        <th>حاله الطلب</th>
                        <th>حاله الدفع</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <strong>
                                    {{ $order->order_code }}
                                </strong>
                            </td>
                            <td>
                                {{ $order->total_price }}
                            </td>
                            <td><span @class([
                                'badge me-1',
                                'bg-label-hover-warning' => $order->status ===  \App\Enums\OrderStatus::PENDING,
                                'bg-label-hover-primary' => $order->status ===  \App\Enums\OrderStatus::PROCESSING,
                                'bg-label-hover-success' => $order->status ===  \App\Enums\OrderStatus::COMPLETED,
                                'bg-label-hover-danger' => $order->status === \App\Enums\OrderStatus::CANCELLED,
                            ])>
                            {{  $order->readable_order_status }}
                            </span>
                            </td>
                            <td>
                            <span @class([
                                'badge me-1',
                                'bg-label-hover-success' => $order->payment_status ===  \App\Enums\PaymentStatus::PAID,
                                'bg-label-hover-danger' => $order->payment_status === \App\Enums\PaymentStatus::UNPAID,
                            ])>{{  $order->readable_payment_status }}</span>
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
                    {{ $orders->links() }}
                </div>
            </div>
        </div>

    </div>

</x-customer-layout>
