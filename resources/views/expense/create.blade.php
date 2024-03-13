<x-app-layout :title="config('app.name') . ' | ' . 'إضافة مصروف'">

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('expenses.index') }}">المصروفات</a>
            /</span>
        إضافة مصروف
    </h4>

    <div x-data="{ type : '{{ old('type') }}' }" class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">بيانات المصروف</h5>
                <div class="card-body">
                    <form action="{{ route('expenses.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">اسم المصروف</label>
                                <input class="form-control" type="text" id="name" name="name" required
                                       value="{{ old('name') }}"/>
                                <x-input-error key="name"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="type" class="form-label">نوع المصروف</label>
                                <select id="type" class="form-select" name="type" x-model="type">
                                    <option selected disabled value>أختر نوع</option>
                                    @foreach(\App\Models\Expense::typeValues() as $value =>  $type)
                                        <option value="{{ $value }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                                <x-input-error key="type"/>
                            </div>

                            <div x-show="type === '{{ \App\Enums\ExpensesType::SALARY}}'" x-transition x-cloak
                                 class="mb-3 col-md-6">
                                <label for="user_id" class="form-label">الموظف</label>
                                <select id="user_id" class="form-select select2" x-ignore name="user_id">
                                    <option selected disabled value>أختر موظف</option>
                                    @foreach($users as $user)
                                        <option
                                            @selected( old('user_id') == $user->id) value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error key="user_id"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="value" class="form-label">القيمه</label>
                                <input class="form-control" type="number" min="1" id="value" name="value" required
                                       value="{{ old('value') }}"/>
                                <x-input-error key="value"/>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" id="description" rows="5"
                                          style="resize: none">{{ old('description') }}</textarea>
                                <x-input-error key="description"/>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">إضافة مصروف</button>
                        </div>
                    </form>
                </div>
            </div>
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
