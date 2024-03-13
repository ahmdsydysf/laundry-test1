<x-app-layout :title=" config('app.name') . ' | ' . 'تعديل ' . $setting->name ">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a
                href="{{ route('settings.index') }}">الإعدادات</a> /</span>
        تعديل إعداد</h4>

    <div class="row" x-data="{imgUrl:'{{ $setting->img_url }}',setting_name: '{{ old('name', $setting->name) }}'}">
        <div class="col-md-12">
            <!-- Profile Details -->
            <div class="card mb-4">
                <h5 class="card-header"> تعديل<span x-text="` ${setting_name}`"></span></h5>
                <div class="card-body">
                    <form action="{{ route('settings.update', $setting) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">الأسم</label>
                                <input class="form-control" type="text" id="name" name="name"
                                       x-model="setting_name"
                                       required/>
                                <x-input-error key="name"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="value"
                                       class="form-label">القيمة</label>
                                <input type="text" class="form-control" id="value"
                                       name="value" value="{{ old('value', $setting->value) }}"/>
                                <x-input-error key="value"/>
                            </div>
                            <div class="my-3 col-md-6">
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-2" tabindex="0">
                                        <span class="d-flex align-items-center">
                                            <span class=" me-3">إضافة صورة</span>
                                            <i class='bx bx-upload bx-fade-down fs-4'></i>
                                        </span>
                                        <input type="file" id="upload" class="account-file-input" hidden name="img"
                                               @change="imgUrl = URL.createObjectURL(event.target.files[0])"
                                               accept="image/png, image/jpeg, image/jpg, image/webp">
                                    </label>
                                    <p class="text-muted mb-0">مسموح بصور من نوع jpg و png و webp</p>
                                </div>
                                <x-input-error key="img"/>
                            </div>

                            <div class="col-md-6" x-show="imgUrl" x-cloak x-transition>
                                <img class="img-thumbnail" :src="imgUrl" alt="{{ $setting->name }}">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                    class="btn btn-primary me-2">تحديث الإعدادات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Profile Details -->
        </div>
    </div>

    @push('css')
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    @endpush

    @push('js')
        @vite(['resources/js/app.js'])
    @endpush
</x-app-layout>
