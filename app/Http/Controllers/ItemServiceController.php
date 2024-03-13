<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemService\ItemServiceStoreRequest;
use App\Http\Requests\ItemService\ItemServiceUpdateRequest;
use App\Models\Item;
use App\Models\ItemService;
use App\Models\Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;


class ItemServiceController extends Controller
{
    /**
     * Show all itemServices
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $services = Service::get();
        $servicesByItem = ItemService::with(['item'])->get()->groupBy('item.name');

        $itemPrices = collect();

        foreach ($servicesByItem as $key => $itemServices) {
            $prices = [];
            $item_id = null;
            foreach ($services as $service) {
                $itemService = $itemServices->filter(function ($itemService) use ($service) {
                    return $itemService->service_id == $service->id;
                });

                $item = $itemService->first();
                $prices[] = $item?->price ?: $item?->note ?: 'لا يوجد';
                $item_id = $item ? $item->item_id : $item_id;
            }
            $itemPrices->push([
                [$item_id => $key],
                ...$prices
            ]);
        }

        // Paginate the $itemPrices collection
        $perPage = config('app.default_pagination'); // Number of items per page
        $currentPage = LengthAwarePaginator::resolveCurrentPage() ?: 1; // Get the current page or default to 1
        $pagedData = $itemPrices->slice(($currentPage - 1) * $perPage, $perPage)->all(); // Get the items for the current page
        $paginatedItemPrices = new LengthAwarePaginator($pagedData, $itemPrices->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('item-service.index', [
            'services' => $services,
            'itemPrices' => $paginatedItemPrices, // Pass the paginated collection to the view
        ]);
    }

    /**
     * Show create form
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create()
    {
        return view('item-service.create',
            [
                'services' => Service::get(['id', 'name']),
                'items' => Item::get(['id', 'name']),
            ]
        );
    }

    /**
     * Handle store request
     *
     * @param ItemServiceStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ItemServiceStoreRequest $request)
    {
        try {
            ItemService::create($request->validated());
        } catch (UniqueConstraintViolationException) {
            toast('هذه التسعيره موجودة بالفعل', 'error');
            return to_route('itemServices.index');
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة اضافة تسعيرة', 'error');
            return to_route('itemServices.index');
        }
        toast('تم إضافة تسعيرة بنجاح', 'success');
        return to_route('itemServices.index');
    }

    /**
     * Show specified Item
     *
     * @param Item $item
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Item $item)
    {
        return view('item-service.show',
            [
                'item' => $item->setRelation('services', $item->services()->paginate(config('app.default_pagination')))
            ]
        );
    }

    /**
     * Show edit form
     *
     * @param ItemService $itemService
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(ItemService $itemService)
    {
        return view('item-service.edit',
            [
                'services' => Service::get(['id', 'name']),
                'items' => Item::get(['id', 'name']),
                'itemService' => $itemService
            ]
        );
    }

    /**
     * Handle update request
     *
     * @param ItemServiceUpdateRequest $request
     * @param ItemService $itemService
     * @return RedirectResponse
     */
    public function update(ItemServiceUpdateRequest $request, ItemService $itemService)
    {
        try {
            if ($itemService->fill($request->validated())->isDirty()) {
                $itemService->save();
            }
        } catch (UniqueConstraintViolationException) {
            toast('هذه التسعيره موجودة بالفعل', 'error');
            return to_route('itemServices.index');
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة تعديل تسعيرة', 'error');
            return to_route('itemServices.index');
        }
        toast('تم تحديث تسعيرة بنجاح', 'success');
        return to_route('itemServices.index');
    }

    /**
     * Handle delete request
     *
     * @param ItemService $itemService
     * @return RedirectResponse
     */
    public function destroy(ItemService $itemService)
    {
        try {
            $itemService->delete();
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة حذف تسعيرة', 'error');
            return back();
        }
        toast('تم حذف تسعيرة بنجاح', 'success');
        return back();
    }
}
