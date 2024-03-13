<x-app-layout :title="config('app.name') . ' | ' . 'الموظفون'">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">الموظفون /</span> قائمة الموظفون</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-header">الموظفون</h5>

            <a href="{{ route('users.create') }}" class="btn btn-primary me-3">إضافة موظف</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>الأسم</th>
                    <th>الهاتف</th>
                    <th>الدور</th>
                    <th>حالة الحساب</th>
                    <th>تاريخ التعيين</th>
                    <th>التحكم</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @forelse($users as $user)
                    <tr>
                        <td>
                            <strong>
                                <a href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                            </strong>
                        </td>
                        <td>
                            {{ $user->phone }}
                        </td>
                        <td>{{ $user->readable_role }}</td>
                        <td>
                            <span @class([
                                'badge me-1',
                                'bg-label-hover-primary' => !$user->isSuspended(),
                                'bg-label-hover-danger' => $user->isSuspended(),
                            ])>{{ $user->readable_status }}
                            </span>
                        </td>
                        <td>
                            {{ $user->created_at->format('Y-m-d') }}
                        </td>
                        <td>
                            @if (!$user->isAdmin() || auth()->user()->isSuperAdmin() )
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('users.edit', $user) }}"><i
                                                class="bx bx-edit-alt me-1"></i>تعديل</a>
                                        <form method="POST" action="{{ route('users.password-reset', $user) }}">
                                            @csrf
                                            <a class="dropdown-item"
                                               href="{{ route('users.password-reset', $user) }}"
                                               style="text-align:start"
                                               onclick="event.preventDefault();
                                                    this.closest('form').submit();">

                                                <i class='bx bx-reset me-1'></i>إستعادة كلمة المرور</a>
                                        </form>
                                        <form method="POST"
                                              action="{{ route('users.toggle-suspension', $user) }}">
                                            @csrf
                                            <a class="dropdown-item"
                                               href="{{ route('users.toggle-suspension', $user) }}"
                                               style="text-align:start"
                                               onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                                @if ($user->isSuspended())
                                                    <i class='bx bx-transfer-alt me-1'></i>
                                                    تفعيل الحساب
                                                @else
                                                    <i class='bx bx-block me-1'></i>
                                                    إيقاف الحساب
                                                @endif
                                            </a>
                                        </form>
                                        <form method="POST" action="{{ route('users.destroy', $user) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a class="dropdown-item" href="{{ route('users.destroy', $user) }}"
                                               style="text-align:start"
                                               onclick="event.preventDefault(); if (confirm('هل تريد حذف الموظف من النظام ؟')) { this.closest('form').submit(); }">
                                                <i class="bx bx-trash me-1"></i>حذف
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td class="text-center" colspan="6"><strong>لا يوجد بيانات</strong></td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4 px-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</x-app-layout>
