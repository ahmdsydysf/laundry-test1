<x-customer-layout :title="config('app.name') . ' | ' . 'تعديل بيانات الحساب'">
    <div class="row">
        <div class="col-md-12">
            <!-- Profile Details -->
            <div class="card mb-4">
                <h5 class="card-header">بيانات الحساب{{ $customer->first_name }}</h5>
                <div class="card-body">
                    <form action="{{ route('customer.profile.info.update') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">الأسم</label>
                                <input class="form-control" type="text" id="name" name="name" required
                                    value="{{ old('name', $customer->name) }}" />
                                <x-input-error key="name" />
                            </div>

                            {{-- address --}}
                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">العنوان</label>
                                <input class="form-control" type="text" id="address" name="address"
                                    value="{{ old('address', $customer->address) }}" />
                                <x-input-error key="address" />
                            </div>

                            {{-- phone --}}
                            <div class="col-md-6">
                                <label class="form-label text-start" for="phone">الهاتف</label>
                                <input type="tel" id="phone" name="phone" required pattern="01[0125][0-9]{8}"
                                    value="{{ old('phone', $customer->phone) }}" class="form-control text-start" />
                                <x-input-error key="phone" />
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

            <!-- Profile Password -->
            <div class="card">
                <h5 class="card-header">تعديل كلمة المرور </h5>
                <div class="card-body">
                    <form action="{{ route('customer.profile.password.update') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                                <input class="form-control" type="password" id="current_password"
                                    name="current_password" />
                                <x-input-error key="current_password" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">كلمة المرور الجديدة</label>
                                <input class="form-control" type="password" id="password" name="password" />

                                <x-input-error key="password" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                                <input class="form-control" type="password" id="password_confirmation"
                                    name="password_confirmation" />
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">تحديث كلمه المرور
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Profile Password -->
        </div>
    </div>
</x-customer-layout>
