<x-app-layout :title="config('app.name') . ' | ' . 'إضافة مرتب'">

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('salaries.index') }}">المرتبات</a>
            /</span>
        إضافة مرتب
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">بيانات المرتب</h5>
                <div class="card-body">
                    <form action="{{ route('salaries.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="user_id" class="form-label">الموظف</label>
                                <select id="user_id" class="form-select select2" name="user_id">
                                    <option selected disabled value>أختر موظف</option>
                                    @foreach ($users as $user)
                                        <option @selected(old('user_id') == $user->id) value="{{ $user->id }}">
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error key="user_id" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="value" class="form-label">المرتب</label>
                                <input class="form-control" type="number" min="1" id="value" name="value"
                                    required value="{{ old('value') }}" />
                                <x-input-error key="value" />
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" id="description" rows="5" style="resize: none">{{ old('description') }}</textarea>
                                <x-input-error key="description" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">إضافة مرتب</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
