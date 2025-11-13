<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'pseudo'             => $this->faker->unique()->userName(),
            'email'              => $this->faker->unique()->safeEmail(),
            'email_verified_at'  => now(),
            'status'             => $this->faker->randomElement(['active', 'inactive']),
            'avatar'             => null,
            'contact'            => '+261' . $this->faker->numerify('#########'),
            'address'            => $this->faker->optional()->address(),
            'role'               => $this->faker->randomElement(['admin', 'user']),
            'password'           => Hash::make('password'), // mot de passe par défaut
            'remember_token'     => Str::random(10),
        ];
    }

    /**
     * Indique que l'utilisateur est un admin
     */
    public function admin(): static
    {
        return $this->state(fn() => ['role' => 'admin', 'status' => 'active']);
    }

    /**
     * Indique que l'utilisateur est un utilisateur standard
     */
    public function user(): static
    {
        return $this->state(fn() => ['role' => 'user', 'status' => 'active']);
    }
}
