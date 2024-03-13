<x-app-layout :title="config('app.name') . ' | ' . 'إضافة خدمه'">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('items.index') }}">الخدمات</a>
            /</span>
        إضافة خدمه</h4>

    <div class="row">
        <div class="col-md-12">

            <!-- Profile Details -->
            <div class="card mb-4">
                <h5 class="card-header">بيانات الخدمه</h5>
                <div class="card-body">
                    <form action="{{ route('services.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                {{-- service name --}}
                                <label for="name" class="form-label">اسم الخدمه</label>
                                <input class="form-control" type="text" id="name" name="name" required
                                    value="{{ old('name') }}" />
                                <x-input-error key="name" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">إضافة خدمه </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
