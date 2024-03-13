<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">المرتبات /</span> قائمة المرتبات</h4>

    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-column flex-md-row">

            <h5 class="card-header pb-3">المرتبات</h5>

            <div class="d-flex flex-column  text-center pt-md-3 ">
                <h4>المجموع</h4>
                <h4>{{ $total }}</h4>
            </div>

            <a href="{{ route('salaries.create') }}" class="btn btn-primary me-3">إضافة مرتب</a>
        </div>

        <!-- Filter Inputs -->
        <div class="mb-4 px-3 row gy-3 align-items-center">
            <div class="col-md-3">
                <label for="search" class="form-label">
                    بحث
                    <i class='ms-2 bx bx-loader-circle bx-spin' wire:loading wire:target="search"></i>
                </label>
                <input id="search" class="form-control mt-1" wire:model.live.debounce.500ms="search"
                    placeholder="أدخل اسم المرتب">
            </div>

            <div class="col-md-3">
                <label for="salary-from" class="form-label">
                    من
                    <i class='ms-2 bx bx-loader-circle bx-spin' wire:loading wire:target="from"></i>
                </label>
                <input type="date" id="salary-from" class="form-control" wire:model.live="from">
            </div>

            <div class="col-md-3">
                <label for="salary-to" class="form-label">
                    الي
                    <i class='ms-2 bx bx-loader-circle bx-spin' wire:loading wire:target="to"></i>
                </label>
                <input type="date" id="salary-to" class="form-control" wire:model.live="to">
            </div>
        </div>
        <!-- / Filter Inputs -->

        <!-- Reset Filters Button -->
        <div x-show="$wire.search  || $wire.from || $wire.to" x-transition x-cloak class="mb-3 px-3">
            <button class="btn btn-linkedin" wire:click="clearFilters">إلغاء الفلاتر</button>
        </div>
        <!-- / Reset Filters Button -->

        <div class="table-responsive text-nowrap">

            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>اسم الموظف</th>
                        <th>المرتب</th>
                        <th>تاريخ الإنشاء</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($salaries as $salary)
                        <tr>
                            <td>
                                <a href="{{ route('salaries.show', $salary) }}">
                                    <strong>
                                        {{ $salary->user->name }}
                                    </strong>
                                </a>
                            </td>
                            <td>
                                {{ $salary->value }}
                            </td>
                            <td>
                                {{ $salary->created_at->diffForHumans() }}
                            </td>
                            <td>
                                <!-- Dropdown toggle button -->
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('salaries.edit', $salary) }}">
                                            <i class="bx bx-edit-alt me-1"></i>تعديل
                                        </a>
                                        <form method="POST" action="{{ route('salaries.destroy', $salary) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a class="dropdown-item" href="{{ route('salaries.destroy', $salary) }}"
                                                style="text-align:start"
                                                onclick="event.preventDefault(); if (confirm('هل تريد حذف المرتب من النظام ؟')) { this.closest('form').submit(); }">
                                                <i class="bx bx-trash me-1"></i>حذف
                                            </a>
                                        </form>
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
            <div class="mt-4 px-4 d-flex justify-content-end">
                {{ $salaries->links() }}
            </div>
        </div>

    </div>
</div>
