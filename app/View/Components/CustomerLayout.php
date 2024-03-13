<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CustomerLayout extends Component
{

    public function __construct(
        public ?string $title = null,
        public ?string $logo = null
    )
    {
        $this->logo = Setting::cachedSettingByKey('web-logo')->img_url;
    }

    public function render(): View
    {
        return view('layouts.customer');
    }
}
