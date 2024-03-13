<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{

    public function __construct(
        public ?string $title = null,
        public ?string $logo = null
    )
    {
        $this->logo = Setting::cachedSettingByKey('web-logo')->img_url;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
