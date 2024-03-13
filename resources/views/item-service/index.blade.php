<x-app-layout :title="config('app.name') . ' | ' . 'أسعار الخدمات'">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">الأسعار /</span> قائمة الأسعار</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-header">الأسعار</h5>

            <a href="{{ route('itemServices.create') }}" class="btn btn-primary me-3">إضافة تسعيرة</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th class="bg-dark text-white"><strong>الصنف</strong></th>
                    @foreach($services as $service)

                        <th class="bg-dark text-white">
                            <strong>{{ $service->name }}</strong>
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                @forelse($itemPrices as $itemPrice)
                    <tr>
                        @foreach($itemPrice as $price)

                            <td>
                                @if(is_array( $price ))
                                    @foreach($price as $id => $name)
                                        <a href="{{ route('itemPrices.show', $id) }}">{{ $name }}</a>
                                    @endforeach
                                @else
                                    {{ $price }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4"><strong>لا يوجد بيانات</strong></td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4 px-4">
                {{ $itemPrices->links() }}
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</x-app-layout>
