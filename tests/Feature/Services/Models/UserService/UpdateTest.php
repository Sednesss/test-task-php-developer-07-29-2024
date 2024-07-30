<?php

namespace Tests\Feature\Services\Models\UserService;

use App\DTO\Models\UserDTO;
use App\Exceptions\Models\UserNotFoundException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Services\Models\UserService\UserServiceTestCase;

class UpdateTest extends UserServiceTestCase
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

        $userDTO = UserDTO::from($user->toArray());
        $userDTO->name = $this->faker->name();
        $userDTO->email = $this->faker->email();
        $userDTO->password = bcrypt($this->faker->name());
        $userDTO->first_name = $this->faker->firstName();
        $userDTO->last_name = $this->faker->lastName();
        $userDTO->father_name = $this->faker->firstNameMale();
        $userDTO->phone = $this->faker->phoneNumber();
        $userDTO->date_of_birth = $this->faker->dateTimeBetween('-80 years', '-5 years')->format('Y-m-d');
        $userDTO->address = $this->faker->address();

        $userUpdate = $this->userService->update($userDTO);

        $this->assertDatabaseHas('users', $userDTO->toArray());
    }

    public function testUserNotFoundException()
    {
        $user = User::factory([
            'email_verified_at' => null,
            'password' => bcrypt('password')
        ])->create();

        $userDTO = UserDTO::from($user->toArray());
        $userDTO->name = $this->faker->name();
        $userDTO->email = $this->faker->email();
        do {
            $userDTO->id = rand();
        } while ($userDTO->id == $user->id);

        $this->expectException(UserNotFoundException::class);

        $userCreate = $this->userService->update($userDTO);
    }

    public function testUniqueConstraintViolationException()
    {
        $userExisting = User::factory([
            'email_verified_at' => null,
            'password' => bcrypt('password')
        ])->create();

        $user = User::factory()->create();
        $userDTO = UserDTO::from($user->toArray());
        $userDTO->name = $this->faker->name();
        $userDTO->email = $userExisting->email;

        $this->expectException(UniqueConstraintViolationException::class);

        $userCreate = $this->userService->update($userDTO);
    }
}
