<x-app-layout :title=" config('app.name') . ' | ' . ' عرض بيانات ' . $user->first_name ">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('users.index') }}">الموظفون</a> /</span>
        عرض بيانات موظف</h4>

    <div class="row">
        <div class="col-md-12">
            <!-- Profile Details -->
            <div class="card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-header"> بيانات : {{ $user->name }}</h5>

                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary me-3">تعديل البيانات</a>
                </div>

                <hr>
                <div class="card-body">
                    <div class="row fs-5">
                        <div class="mb-3 col-md-6">
                            الاسم : {{ $user->name }}
                        </div>
                        <div class="mb-3 col-md-6">
                            الهاتف : {{ $user->phone }}
                        </div>
                        <div class="col-md-6">
                            الدور : {{ $user->readable_role }}
                        </div>
                        <div class="col-md-6">
                            تاريخ التعيين : {{ $user->created_at->format('Y-m-d') }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Profile Details -->
        </div>
    </div>
</x-app-layout>
