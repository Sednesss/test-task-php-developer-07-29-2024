<?php

namespace Database\Seeders;

use App\DTO\Models\UserDTO;
use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userAdminDTO = UserDTO::from([
            'name' => 'admin',
            'email' => 'test@example.com',
            'password' => bcrypt(1234),
            'first_name' => 'empty',
            'last_name' => 'empty',
        ]);

        $userAdmin = User::create($userAdminDTO->toArray());

        $userAdmin->assignRole(UserRolesEnum::ADMIN);
    }
}
