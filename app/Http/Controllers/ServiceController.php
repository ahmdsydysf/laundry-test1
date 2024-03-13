<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Models\Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        return view(
            'service.index',
            [
                'services' => Service::paginate(config('app.default_pagination'))
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create()
    {
        return view('service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ServiceStoreRequest $request)
    {
        try {
            Service::create($request->validated());
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة اضافة الخدمه', 'error');
            return to_route('services.index');
        }
        toast('تم إضافة الخدمه بنجاح', 'success');
        return to_route('services.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Service $service
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Service $service)
    {
        return view(
            'service.edit',
            [
                'service' => $service
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceUpdateRequest $request
     * @param Service $service
     * @return RedirectResponse
     */
    public function update(ServiceUpdateRequest $request, Service $service)
    {
        try {
            if ($service->fill($request->validated())->isDirty()) {
                $service->save();
            }
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة تعديل بيانات الخدمه', 'error');
            return to_route('services.index');
        }
        toast('تم تحديث بيانات الخدمه بنجاح', 'success');
        return to_route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Service $service
     * @return RedirectResponse
     */
    public function destroy(Service $service)
    {
        try {
            $service->delete();
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة حذف الخدمه', 'error');
            return to_route('services.index');
        }
        toast('تم حذف الخدمه بنجاح', 'success');
        return to_route('services.index');
    }
}
