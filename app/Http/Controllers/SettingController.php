<?php

namespace App\Http\Controllers;

use App\Http\Requests\setting\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Show all settings
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        return view('setting.index',
            [
                'settings' => Setting::paginate(config('app.default_pagination'))
            ]
        );
    }

    /**
     * Show edit form
     *
     * @param Setting $setting
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Setting $setting)
    {
        return view('setting.edit',
            [
                'setting' => $setting
            ]
        );
    }

    /**
     * Handle update form
     *
     * @param SettingUpdateRequest $request
     * @param Setting $setting
     * @return RedirectResponse
     */
    public function update(SettingUpdateRequest $request, Setting $setting)
    {
        try {
            if ($request->has('img')) {
                if ($setting->img) {
                    if (Storage::disk('public')->exists($setting->img)) {
                        Storage::disk('public')->delete($setting->img);
                    }
                }

                $file = $request->file('img');

//                $path = $file->storeAs('/', $file->getClientOriginalName(), 'public');

                $path = Storage::disk('public')->putFileAs('/', $file, rand() . $file->getClientOriginalName());

                if (!$path) {
                    toast('حدث خطأ اثناء محاولة رفع الصورة', 'error');
                    return to_route('settings.index');
                }

                $setting->fill(
                    [
                        'img' => $path
                    ]
                );
            }
            $setting->fill($request->only(['value', 'name']));
            if ($setting->isDirty()) {
                $setting->save();
            }
        } catch (\Throwable $throwable) {
            toast('حدث خطأ اتثاء محاولة تحديث الأعدادات', 'error');
            return to_route('settings.index');
        }
        toast('تم تحديث إعدادات الموقع بنجاح', 'success');
        return to_route('settings.index');
    }
}
