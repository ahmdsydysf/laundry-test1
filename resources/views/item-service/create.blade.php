<x-app-layout :title=" config('app.name') . ' | ' . 'إضافة تسعيرة' ">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('itemServices.index') }}">قائمة أسعار الخدمات</a> /</span>
        إضافة تسعيرة</h4>

    <div class="row">
        <div class="col-md-12">

            <!-- Profile Details -->
            <div class="card">
                <h5 class="card-header">التفاصيل</h5>
                <div class="card-body">
                    <form action="{{ route('itemServices.store') }}" method="post">
                        @csrf
                        <div class="row mb-4">
                            <div class="mb-3 mb-md-0 col-md-4 ">
                                <label for="item_id"
                                       class="form-label">الأصناف</label>
                                <div class="select2-dark">
                                    <select id="item_id" class="select2 form-select" name="item_id">
                                        <option selected disabled value>أختر صنف</option>
                                        @foreach($items as $item)
                                            <option
                                                @selected( old('item_id') == $item->id) value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error key="item_id"/>
                            </div>

                            <div class="mb-3 mb-md-0 col-md-4">
                                <label for="service_id"
                                       class="form-label">الخدمات</label>
                                <div class="select2-dark">
                                    <select id="service_id" class="select2 form-select" name="service_id">
                                        <span class="select2-selection__placeholder">Select value</span>
                                        <option selected disabled value>أختر خدمة</option>
                                        @foreach($services as $service)
                                            <option
                                                @selected( old('service_id') == $service->id) value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error key="service_id"/>
                            </div>

                            <div class="col-md-4">
                                <label for="price"
                                       class="form-label">السعر</label>
                                <input type="number" class="form-control" id="price"
                                       min="0"
                                       name="price" value="{{ old('price') }}"/>
                                <x-input-error key="price"/>
                            </div>

                            <div class="my-3 mb-md-0 col-md-4">
                                <label for="note"
                                       class="form-label">ملحوظه لحساب السعر</label>
                                <input type="text" class="form-control" id="note" name="note" placeholder="ملحوظه تظهر في حاله عدم وجود سعر للخدمه" value="{{ old('note') }}">
                                <x-input-error key="note"/>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                    class="btn btn-primary">إضافة تسعيرة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Profile Details -->
        </div>
    </div>

</x-app-layout>
