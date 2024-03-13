<?php

namespace App\Http\Controllers;

use App\Http\Requests\item\ItemStoreRequest;
use App\Http\Requests\item\ItemUpdateRequest;
use App\Models\Item;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class ItemController extends Controller
{
    /**
     * Show all items
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        return view('item.index',
            [
                'items' => Item::paginate(config('app.default_pagination'))
            ]
        );
    }

    /**
     * Show form to create item
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create()
    {
        return view('item.create');
    }

    /**
     *
     * Handle store request
     * @param ItemStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ItemStoreRequest $request)
    {
        try {
            Item::create($request->validated());
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة اضافة الصنف', 'error');
            return to_route('items.index');
        }
        toast('تم إضافة الصنف بنجاح', 'success');
        return to_route('items.index');
    }

    /**
     * Show edit form
     *
     * @param Item $item
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Item $item)
    {
        return view('item.edit',
            [
                'item' => $item
            ]
        );
    }

    /**
     * Handle update request
     *
     * @param ItemUpdateRequest $request
     * @param Item $item
     * @return RedirectResponse
     */
    public function update(ItemUpdateRequest $request, Item $item)
    {
        try {
            if ($item->fill($request->validated())->isDirty()){
                $item->save();
            }
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة تعديل بيانات الصنف', 'error');
            return to_route('items.index');
        }
        toast('تم تحديث بيانات الصنف بنجاح', 'success');
        return to_route('items.index');
    }

    /**
     * Handle delete request
     *
     * @param Item $item
     * @return RedirectResponse
     */
    public function destroy(Item $item)
    {
        try {
            $item->delete();
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة حذف صنف', 'error');
            return to_route('items.index');
        }
        toast('تم حذف صنف بنجاح', 'success');
        return to_route('items.index');
    }
}
