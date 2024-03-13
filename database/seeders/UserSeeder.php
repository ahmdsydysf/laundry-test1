<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'احمد',
            'phone' => '01234567800',
            'role' => Roles::SUPER_ADMIN,
            'password' => '01234567800',
        ]);
        User::create([
            'name' => 'إسلام احمد',
            'phone' => '01234567891',
            'role' => Roles::ADMIN,
            'password' => '01234567891',
        ]);
        User::create([
            'name' => 'عمر محمد',
            'phone' => '01234567892',
            'role' => Roles::ADMIN,
            'password' => '01234567892',
        ]);
        User::create([
            'name' => 'محمد محمود',
            'phone' => '01234567893',
            'role' => Roles::EMPLOYEE,
            'password' => '01234567893',
        ]);
        User::create([
            'name' => 'احمد صادق',
            'phone' => '01234567894',
            'role' => Roles::EMPLOYEE,
            'password' => '01234567894',
        ]);
        User::create([
            'name' => 'عمر محمد',
            'phone' => '01234567895',
            'role' => Roles::EMPLOYEE,
            'password' => '01234567895',
        ]);
        User::create([
            'name' => 'عمر محمد',
            'phone' => '01234567896',
            'role' => Roles::EMPLOYEE,
            'password' => '01234567896',
        ]);
    }
}
