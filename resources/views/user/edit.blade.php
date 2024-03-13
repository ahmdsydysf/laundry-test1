<x-app-layout :title="config('app.name') . ' | ' . ' تعديل بيانات ' . $user->first_name">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('users.index') }}">الموظفون</a>
            /</span>
        تعديل بيانات موظف</h4>

    <div x-data="{
        u_name: '{{ old('name', $user->name) }}'
    }" class="row">
        <div class="col-md-12">
            <!-- Profile Details -->
            <div class="card mb-4">
                <h5 class="card-header"> بيانات<span x-text="` ${u_name.trim()}`"></span></h5>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">الأسم</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    x-model="u_name" required />
                                <x-input-error key="name" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-start" for="phone">الهاتف</label>
                                <input type="tel" id="phone" name="phone" required pattern="01[0125][0-9]{8}"
                                    value="{{ old('phone', $user->phone) }}" class="form-control text-start" />

                                <x-input-error key="phone" />
                            </div>

                            <div class="col-md-6">
                                <label for="role" class="form-label">الدور</label>
                                <div class="select2-dark">
                                    <select id="role" class="select2 form-select" name="role">
                                        <option selected disabled value>أختر دور</option>
                                        <option @selected(old('role', $user->role->value) == \App\Enums\Roles::ADMIN->value)
                                            value="{{ \App\Enums\Roles::ADMIN->value }}">مدير</option>
                                        <option @selected(old('role', $user->role->value) == \App\Enums\Roles::EMPLOYEE->value)
                                            value="{{ \App\Enums\Roles::EMPLOYEE->value }}">موظف</option>
                                    </select>
                                </div>
                                <x-input-error key="role" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">تحديث البيانات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Profile Details -->
        </div>
    </div>

    @push('js')
        @vite(['resources/js/app.js'])
    @endpush
</x-app-layout>
