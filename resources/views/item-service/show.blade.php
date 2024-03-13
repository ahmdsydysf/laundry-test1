<x-app-layout :title="config('app.name') . ' | ' . 'أسعار خدمات ' . $item->name ">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a
                href="{{ route('itemServices.index') }}">الأسعار</a> /</span> أسعار خدمات {{ $item->name }}</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-header">الصنف : {{ $item->name }}</h5>

            <a href="{{ route('itemServices.create') }}" class="btn btn-primary me-3">إضافة تسعيرة</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th class="bg-dark text-white"><strong>الخدمة</strong></th>
                    <th class="bg-dark text-white"><strong>السعر</strong></th>
                    <th class="bg-dark text-white"><strong>التحكم</strong></th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                @forelse($item->services as $service)
                    <tr>
                        <td>
                            <a href="{{ route('itemServices.edit', $service->details) }}">
                                <strong>
                                    {{ $service->name }}
                                </strong>
                            </a>
                        </td>
                        <td>
                            {{ $service->details->price }}
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('itemServices.edit', $service->details) }}"><i
                                            class="bx bx-edit-alt me-1"></i>تعديل</a>
                                    <form method="POST" action="{{ route('itemServices.destroy', $service->details) }}">
                                        @csrf
                                        @method('DELETE')
                                        <a class="dropdown-item"
                                           href="{{ route('itemServices.destroy', $service->details) }}"
                                           style="text-align:start"
                                           onclick="event.preventDefault(); if (confirm('هل تريد حذف التسعيرة من النظام ؟')) { this.closest('form').submit(); }">
                                            <i class="bx bx-trash me-1"></i>حذف
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="3"><strong>لا يوجد بيانات</strong></td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4 px-4">
                {{ $item->services->links() }}
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</x-app-layout>
