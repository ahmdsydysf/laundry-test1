<h5 class="card-header">معلومات عامة</h5>

<div class="card-body">
    <form action="{{ route('profile.update') }}" method="post">
        @csrf
        @method('PATCH')

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">الأسم</label>
                <input class="form-control" type="text" id="name" name="name"
                    value="{{ old('name', $user->name) }}" />
                <x-input-error key="name" />
            </div>
            <div class="col-md-6">
                <label class="form-label text-start" for="phone">الهاتف</label>
                <input type="text" id="phone" name="phone" pattern="01[0125][0-9]{8}" value="{{ old('phone', $user->phone) }}"
                    class="form-control text-start" />
                <x-input-error key="phone" />
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary me-2">حفظ التعديل</button>
        </div>
    </form>
</div>
<!-- /Account -->
