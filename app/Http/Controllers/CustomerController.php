<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Customer;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CustomerController extends Controller
{
    /**
     * Show Customer info
     *
     * @param Customer $customer
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Customer $customer)
    {
        return view(
            'customer.show',
            [
                'customer' => $customer->setRelation('orders', $customer->orders()->paginate(config('app.default_pagination')))
                //                'orders' => $customer->orders()->paginate()
            ]
        );
    }

    /**
     * Show edit form
     *
     * @param Customer $customer
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Customer $customer)
    {
        return view(
            'customer.edit',
            [
                'customer' => $customer
            ]
        );
    }

    /**
     * Handle update request
     *
     * @param CustomerUpdateRequest $request
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        try {
            if ($customer->fill($request->validated())->isDirty()) {
                $customer->save();
            }
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة تعديل بيانات عميل', 'error');
            return to_route('customers.index');
        }
        toast('تم تحديث بيانات عميل بنجاح', 'success');
        return to_route('customers.index');
    }

    /**
     * Reset Customer password
     *
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function resetPassword(Customer $customer)
    {

        try {
            $default_password = Setting::firstWhere('key', 'customer-default-password');
            if (!$default_password->value) {
                toast('يجب تعيين كلمة مرور إفتراضية من إعدادات الموقع اولا', 'error');
                return to_route('customers.index');
            }
            $customer->update(['password' => $default_password->value]);
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة إستعادة كلمة مرور العميل', 'error');
            return to_route('customers.index');
        }
        toast('تم إستعادة كلمة مرور العميل بنجاح', 'success');
        return to_route('customers.index');
    }
}
