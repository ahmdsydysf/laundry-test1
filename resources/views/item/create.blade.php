<x-app-layout :title="config('app.name') . ' | ' . 'إضافة صنف'">

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('items.index') }}">الاصناف</a>
            /</span>
        إضافة صنف</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">بيانات الاصناف</h5>
                <div class="card-body">
                    <form action="{{ route('items.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                {{-- item name --}}
                                <label for="name" class="form-label">اسم الصنف</label>
                                <input class="form-control" type="text" id="name" name="name" required
                                    value="{{ old('name') }}" />
                                <x-input-error key="name" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">إضافة صنف </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
