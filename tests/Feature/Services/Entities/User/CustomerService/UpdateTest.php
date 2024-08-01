<?php

namespace Tests\Feature\Services\Entities\User\CustomerService;

use App\DTO\Entities\User\CustomerDTO;
use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\User\UserIsNotCustomerException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends CustomerServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $user = User::factory([
            'email_verified_at' => null,
            'password' => bcrypt('password'),
            'remember_token' => null
        ])->create();
        $user->assignRole(UserRolesEnum::CUSTOMER);

        $customerDTO = CustomerDTO::from($user->toArray());
        $customerDTO->name = $this->faker->name();
        $customerDTO->email = $this->faker->email();
        $customerDTO->password = bcrypt($this->faker->name());
        $customerDTO->first_name = $this->faker->firstName();
        $customerDTO->last_name = $this->faker->lastName();
        $customerDTO->father_name = $this->faker->firstNameMale();
        $customerDTO->phone = $this->faker->phoneNumber();
        $customerDTO->date_of_birth = $this->faker->dateTimeBetween('-80 years', '-5 years')->format('Y-m-d');
        $customerDTO->address = $this->faker->address();

        $userUpdate = $this->customerService->update($customerDTO);

        $this->assertDatabaseHas('users', $customerDTO->asUserDTO()->toArray());
    }

    public function testUserIsNotCustomerException()
    {
        $user = User::factory([
            'email_verified_at' => null,
            'password' => bcrypt('password'),
            'remember_token' => null
        ])->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $customerDTO = CustomerDTO::from($user->toArray());
        $customerDTO->name = $this->faker->name();
        $customerDTO->email = $this->faker->email();

        $this->expectException(UserIsNotCustomerException::class);

        $userUpdate = $this->customerService->update($customerDTO);
    }
}
