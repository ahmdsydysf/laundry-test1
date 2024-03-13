<x-app-layout :title=" config('app.name') . ' | ' . 'تعديل حسابي' ">
    <h4 class="fw-bold py-3 mb-4">
        <span
            class="text-muted fw-light"> حسابي / </span> بيانات حسابي
    </h4>

    <div class="row">
        <div class="col-md-12">

            <!-- Profile Details -->
            <div class="card mb-4">
                @include('profile.partials.update-profile-information-form')
            </div>
            <!-- /Profile Details -->

            <!-- Update Password -->
            <div class="card mb-4">
                @include('profile.partials.update-password-form')
            </div>
            <!-- /Update Password -->
        </div>
    </div>
</x-app-layout>

