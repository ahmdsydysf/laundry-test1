<x-app-layout :title="config('app.name') . ' | ' . ' تعديل بيانات ' . $customer->first_name">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('customers.index') }}">العملاء</a>
            /</span>
        تعديل بيانات عميل</h4>

    <div class="row">
        <div class="col-md-12">
            <!-- Profile Details -->
            <div class="card mb-4">
                <h5 class="card-header">بيانات {{ $customer->first_name }}</h5>
                <div class="card-body">
                    <form action="{{ route('customers.update', $customer) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            {{--  name --}}
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">الأسم</label>
                                <input class="form-control" type="text" id="name" name="name" required
                                       value="{{ old('name', $customer->name) }}"/>
                                <x-input-error key="name"/>
                            </div>

                            {{-- address --}}
                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">العنوان</label>
                                <input class="form-control" type="text" id="address" name="address" required
                                       value="{{ old('address', $customer->address) }}"/>
                                <x-input-error key="address"/>
                            </div>

                            {{-- phone --}}
                            <div class="col-md-6">
                                <label class="form-label text-start"  for="phone">الهاتف</label>
                                <input type="tel" id="phone" name="phone" required pattern="01[0125][0-9]{8}"
                                       value="{{ old('phone', $customer->phone) }}" class="form-control text-start"/>
                                <x-input-error key="phone"/>
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
</x-app-layout>
