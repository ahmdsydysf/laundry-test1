<x-app-layout :title="config('app.name') . ' | ' . 'الإعدادات'">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">الإعدادات /</span> قائمة الإعدادات</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">

        <h5 class="card-header">الإعدادات</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>الأسم</th>
                    <th>القيمة</th>
                    <th>تاريخ اخر تعديل</th>
                    <th>التحكم</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @forelse($settings as $setting)
                    <tr>
                        <td> <strong><a
                                    href="{{ route('settings.edit', $setting) }}">{{ $setting->name }}</a></strong>
                        </td>
                        <td>{{ $setting->value }}</td>
                        <td>
                            {{ $setting->updated_at?->diffForHumans() }}
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('settings.edit', $setting) }}"><i
                                            class="bx bx-edit-alt me-1"></i>تعديل</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4"><strong>لا يوجد بيانات</strong></td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4 px-4">
                {{ $settings->links() }}
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</x-app-layout>
