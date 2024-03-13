<x-app-layout :title="config('app.name') . ' | ' . 'إضافة موظف'">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('users.index') }}">الموظفون</a>
            /</span>
        إضافة موظف</h4>

    <div class="row">
        <div class="col-md-12">

            <!-- Profile Details -->
            <div class="card mb-4">
                <h5 class="card-header">بيانات الموظف</h5>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">الأسم</label>
                                <input class="form-control" type="text" id="name" name="name"
                                       required
                                       value="{{ old('name') }}"/>
                                <x-input-error key="name"/>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-start" for="phone">الهاتف</label>
                                <input type="tel" id="phone" name="phone" required pattern="01[0125][0-9]{8}" value="{{ old('phone') }}"
                                    class="form-control text-start" />
                                <x-input-error key="phone" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">كلمة المرور</label>
                                <input class="form-control"  type="password" id="password" name="password"  autocomplete="password"/>

                                <x-input-error key="password" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                                <input class="form-control" type="password" id="password_confirmation"
                                       autocomplete="password"
                                    name="password_confirmation" />
                                <x-input-error key="password_confirmation" />
                            </div>

                            <div class=" col-md-6 ecommerce-select2-dropdown">
                                <label for="role" class="form-label">الدور</label>
                                <div class="select2-dark">
                                    <select id="role" class="select2 form-select" name="role">
                                        <option selected disabled value>الادوار</option>
                                        <option @selected( old('role') == \App\Enums\Roles::ADMIN->value) value="{{ \App\Enums\Roles::ADMIN->value }}">مدير</option>
                                        <option @selected( old('role') == \App\Enums\Roles::EMPLOYEE->value) value="{{ \App\Enums\Roles::EMPLOYEE->value }}">موظف</option>
                                    </select>
                                </div>
                                <x-input-error key="role" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">إضافة موظف
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Profile Details -->
        </div>
    </div>
</x-app-layout>
