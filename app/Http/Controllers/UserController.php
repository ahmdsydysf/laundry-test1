<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    /**
     * Show all users
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        return view(
            'user.index',
            [
                'users' => User::whereNotIn('id', [1, auth()->id()])->paginate(config('app.default_pagination'))
            ]
        );
    }

    /**
     * Show create form
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Handle store request
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            if (is_null($request->validated('password'))) {
                $default_password = Setting::firstWhere('key', 'default-password');
                if (!$default_password->value) {
                    toast('يجب تعيين كلمة مرور إفتراضية من إعدادات الموقع او اكتب كلمة المرور', 'error');
                    return to_route('users.index');
                }
                $validated['password'] = $default_password->value;
            }
            User::create($validated);
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة اضافة مستخدم', 'error');
            return to_route('users.index');
        }
        toast('تم إضافة مستخدم بنجاح', 'success');
        return to_route('users.index');
    }

    /**
     * Show specified User
     *
     * @param User $user
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('user.show',
            [
                'user' => $user
            ]
        );
    }

    /**
     * Show edit form
     *
     * @param User $user
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->checkActions($user);
        return view(
            'user.edit',
            [
                'user' => $user
            ]
        );
    }

    /**
     * Handle update request
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            if($user->fill($request->validated())->isDirty()){
                $user->save();
            }
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة تعديل بيانات مستخدم', 'error');
            return to_route('users.index');
        }
        toast('تم تحديث بيانات مستخدم بنجاح', 'success');
        return to_route('users.index');
    }

    /**
     * Handle delete request
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->checkActions($user);
        try {
            $user->delete();
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة حذف مستخدم', 'error');
            return to_route('users.index');
        }
        toast('تم حذف مستخدم بنجاح', 'success');
        return to_route('users.index');
    }

    /**
     * Reset User Password
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function resetPassword(User $user)
    {
        $this->checkActions($user);
        try {
            $default_password = Setting::firstWhere('key', 'default-password');
            if (!$default_password->value) {
                toast('يجب تعيين كلمة مرور إفتراضية من إعدادات الموقع اولا', 'error');
                return to_route('users.index');
            }
            $user->update(['password' => $default_password->value]);
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة إستعادة كلمة مرور مستخدم', 'error');
            return to_route('users.index');
        }
        toast('تم إستعادة كلمة مرور مستخدم بنجاح', 'success');
        return to_route('users.index');
    }

    /**
     * Toggle user Suspension
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function toggleSuspension(User $user)
    {
        $this->checkActions($user);
        try {
            $status = $user->status === UserStatus::ACTIVE ? UserStatus::SUSPENDED : UserStatus::ACTIVE;
            $user->update(['status' => $status]);
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة تغيير حالة مستخدم', 'error');
            return to_route('users.index');
        }
        toast('تم تغيير حالة مستخدم بنجاح', 'success');
        return to_route('users.index');
    }

    /**
     * Check if the role of the user is higher than the edited user
     *
     * @param User $user
     * @return void
     */
    private function checkActions(User $user)
    {
        abort_unless(auth()->user()->role->value < $user->role->value, 401);
    }
}
