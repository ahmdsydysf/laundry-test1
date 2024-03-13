<x-app-layout :title="config('app.name') . ' | ' . 'تفاصيل مصروف'">

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('expenses.index') }}">المصروفات</a>
            /</span>
        تفاصيل مصروف</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">بيانات المصروف</h5>
                <hr>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-4">
                            <label for="name" class="form-label">اسم المصروف</label>
                            <span class="d-block">
                                    {{ $expense->name }}
                                </span>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="type" class="form-label">نوع المصروف</label>
                            <span class="d-block">
                                {{ $expense->readable_type }}
                                </span>
                        </div>
                        @if($expense->user_id)
                            <div class="mb-3 col-md-4">
                                <label for="value" class="form-label">الموظف</label>
                                <span class="d-block">
                                {{ $expense->user->name }}
                                </span>
                            </div>
                        @endif
                        <div class="mb-3 col-md-4">
                            <label for="value" class="form-label">القيمه</label>
                            <span class="d-block">
                                {{ $expense->value }}
                                </span>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">الوصف</label>
                            <span class="d-block">
                                {{ $expense->description }}
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
