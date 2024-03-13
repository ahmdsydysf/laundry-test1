<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        //TODO:: Fix storage shortcut issue

        $settings = [
            [
                'name' => 'كلمة المرور الافتراضية للموظفين',
                'key' => 'default-password',
                'value' => 'altaqwa1234',
            ],
            [
                'name' => 'كلمة المرور الافتراضية للعملاء',
                'key' => 'customer-default-password',
                'value' => '1020304050',
            ],
            [
                'name' => 'لوجو الموقع',
                'key' => 'web-logo',
            ]
        ];

        foreach ($settings as $setting) {
            Setting::insert($setting);
        }

        // Check if the symbolic link already exists
        // if (!File::exists(public_path('storage'))) {
        //     // If not, create the symbolic link
        //     Artisan::call('storage:link');
        // }
    }
}
