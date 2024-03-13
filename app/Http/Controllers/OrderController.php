<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Show specified Order
     *
     * @param Order $order
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        return view(
            'order.show',
            [
                'order' => $order->load(
                    [
                        'orderDetails' => [
                            'service:id,name',
                            'item:id,name'
                        ],
                        'user',
                        'customer'
                    ]
                )
            ]
        );
    }

    /**
     * Handle delete request
     *
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order)
    {
        abort_unless(auth()->user()->isSuperAdmin(), 401);
        try {
            $order->delete();
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة حذف طلب العميل', 'error');
            return back();
        }
        toast('تم حذف طلب العميل بنجاح', 'success');
        return back();
    }
}
