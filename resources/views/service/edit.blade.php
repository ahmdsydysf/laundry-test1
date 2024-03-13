<x-app-layout :title="config('app.name') . ' | ' . ' تعديل بيانات ' . $service->name">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('services.index') }}">الخدمه</a>
            /</span>
        تعديل بيانات الخدمه</h4>

    <div class="row">
        <div class="col-md-12">
            <!-- Profile Details -->
            <div class="card mb-4">
                <h5 class="card-header">بيانات {{ $service->name }}</h5>
                <div class="card-body">
                    <form action="{{ route('services.update', $service) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            {{-- service name --}}
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">اسم الخدمه</label>
                                <input class="form-control" type="text" id="name" name="name" required
                                    value="{{ old('name', $service->name) }}" />
                                <x-input-error key="name" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">تحديث البيانات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
