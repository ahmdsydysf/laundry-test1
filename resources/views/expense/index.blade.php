<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">المصروفات /</span> قائمة المصروفات</h4>

    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-column flex-md-row">

            <h5 class="card-header pb-3">المصروفات</h5>

            <div x-show="$wire.search || $wire.type || $wire.from || $wire.to" x-transition x-cloak>
                <div class="d-flex flex-column  text-center pt-md-3 ">
                    <h4>المجموع</h4>
                    <h4>{{ $total }}</h4>
                </div>
            </div>

            <a href="{{ route('expenses.create') }}" class="btn btn-primary me-3">إضافة مصروف</a>
        </div>

        <!-- Filter Inputs -->
        <div class="mb-4 px-3 row gy-3 align-items-center">
            <div class="col-md-3">
                <label for="search" class="form-label">
                    بحث
                    <i class='ms-2 bx bx-loader-circle bx-spin' wire:loading wire:target="search"></i>
                </label>
                <input id="search" class="form-control mt-1" wire:model.live.debounce.500ms="search"
                       placeholder="أدخل اسم المصروف">
            </div>

            <div class=" col-md-3">
                <label for="expense-type"
                       class="form-label">
                    نوع المصروف
                    <i class='ms-2 bx bx-loader-circle bx-spin' wire:loading wire:target="type"></i>
                </label>

                <div>
                    <select id="expense-type" class="form-select" wire:model.live="type">
                        <option value>الكل</option>
                        @foreach ( \App\Models\Expense::typeValues() as $value => $type )
                            <option wire:key="{{ 'Type-'. $value }}" value="{{ $value }}">
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <label for="expense-from"
                       class="form-label">
                    من
                    <i class='ms-2 bx bx-loader-circle bx-spin' wire:loading wire:target="from"></i>
                </label>
                <input type="date" id="expense-from" class="form-control" wire:model.live="from">
            </div>

            <div class="col-md-3">
                <label for="expense-to"
                       class="form-label">
                    الي
                    <i class='ms-2 bx bx-loader-circle bx-spin' wire:loading wire:target="to"></i>
                </label>
                <input type="date" id="expense-to" class="form-control" wire:model.live="to">
            </div>
        </div>
        <!-- / Filter Inputs -->

        <!-- Reset Filters Button -->
        <div x-show="$wire.search || $wire.type || $wire.from || $wire.to" x-transition x-cloak class="mb-3 px-3">
            <button class="btn btn-linkedin" wire:click="clearFilters">إلغاء الفلاتر</button>
        </div>
        <!-- / Reset Filters Button -->

        <div class="table-responsive text-nowrap">

            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>الأسم</th>
                    <th>النوع</th>
                    <th>القيمه</th>
                    <th>تاريخ الإنشاء</th>
                    <th>التحكم</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @forelse($expenses as $expense)
                    <tr>
                        <td>
                            <a href="{{ route('expenses.show', $expense) }}">
                                <strong>
                                    {{ $expense->name }}
                                </strong>
                            </a>
                        </td>
                        <td>
                            {{ $expense->readable_type }}
                        </td>
                        <td>
                            {{ $expense->value }}
                        </td>
                        <td>
                            {{ $expense->created_at->diffForHumans() }}
                        </td>
                        <td>
                            <!-- Dropdown toggle button -->
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('expenses.edit', $expense) }}">
                                        <i class="bx bx-edit-alt me-1"></i>تعديل
                                    </a>
                                    <form method="POST" action="{{ route('expenses.destroy', $expense) }}">
                                        @csrf
                                        @method('DELETE')
                                        <a class="dropdown-item" href="{{ route('expenses.destroy', $expense) }}"
                                           style="text-align:start"
                                           onclick="event.preventDefault(); if (confirm('هل تريد حذف المصروف من النظام ؟')) { this.closest('form').submit(); }">
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
                {{ $expenses->links() }}
            </div>
        </div>

    </div>
</div>
