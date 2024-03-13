<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerProfilePasswordUpdateRequest;
use App\Http\Requests\Customer\CustomerProfileUpdateRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CustomerProfileController extends Controller
{
    /**
     * Show Customer Profile
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view(
            'customer-profile.show',
            [
                'customer' => $request->user(),
                'orders' => $request->user()->orders()->paginate(config('app.default_pagination'))
            ]
        );
    }

    /**
     * Show form edit
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        return view(
            'customer-profile.edit',
            [
                'customer' => $request->user()
            ]
        );
    }

    /**
     *  Update Customer Information
     *
     * @param CustomerProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function updateProfileInfo(CustomerProfileUpdateRequest $request)
    {
        try {
            if ($request->user()->fill($request->validated())->isDirty()) {
                $request->user()->save();
            }
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة تغيير بيانات الحساب', 'error');
            return to_route('customer-profile.show');
        }
        toast('تم تغيير بيانات الحساب بنجاح', 'success');
        return to_route('customer.profile.show');
    }

    /**
     * Handle update request
     *
     * @param CustomerProfilePasswordUpdateRequest $request
     * @return RedirectResponse
     */
    public function updateProfilePassword(CustomerProfilePasswordUpdateRequest $request)
    {
        try {
            $request->user()->update([
                'password' => $request->validated('password'),
            ]);
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة تغيير كلمة المرور', 'error');
            return to_route('customer-profile.show');
        }
        toast('تم تغيير كلمة المرور بنجاح', 'success');

        return to_route('customer.profile.show');
    }
}
