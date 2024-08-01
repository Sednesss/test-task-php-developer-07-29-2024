<?php

namespace Database\Seeders;

use App\Enums\Models\UserRolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create([
            'name' => UserRolesEnum::ADMIN,
            'guard_name' => 'api'
        ]);
        
        $customer = Role::create([
            'name' => UserRolesEnum::CUSTOMER,
            'guard_name' => 'api'
        ]);
    }
}
