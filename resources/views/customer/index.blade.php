<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">العملاء /</span> قائمة العملاء</h4>

    <div class="card">
        {{-- title table --}}
        <h5 class="card-header">العملاء</h5>

        <div class="card-body">
            <div class="col-md-5 mb-3">
                <label for="search" class="form-label">
                    بحث
                    <i wire:loading wire:target="search" class='ms-2 bx bx-loader-circle bx-spin'></i>
                </label>
                <input wire:model.live.debounce.500ms="search" id="search" class="form-control mt-1"
                    placeholder="أدخل كود العميل او رقم هاتف العميل او اسم العميل">
            </div>

            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الأسم</th>
                        <th>العنوان</th>
                        <th>الهاتف</th>
                        <th>تاريخ التسجيل</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($customers as $customer)
                        <tr wire:key="{{ $customer->id }}">
                            <td>{{ $customer->id }}</td>
                            <td>
                                <strong>
                                    <a href="{{ route('customers.show', $customer) }}">{{ $customer->name }}</a>
                                </strong>
                            </td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->created_at->diffForHumans() }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('customers.edit', $customer) }}">
                                            <i class="bx bx-edit-alt me-1"></i>تعديل
                                        </a>
                                        <form method="POST"
                                            action="{{ route('customers.password-reset', $customer) }}">
                                            @csrf
                                            <a class="dropdown-item"
                                                href="{{ route('customers.password-reset', $customer) }}"
                                                style="text-align:start"
                                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                <i class='bx bx-reset me-1'></i>إستعادة كلمة المرور</a>
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
            <!-- Pagination links -->
            <div class="mt-3 px-3 d-flex justify-content-end">
                {{ $customers->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>
</div>
