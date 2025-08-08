<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class; 
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => fake()->uuid(),
            'user_id' => User::factory(),
            'mobile' => fake()->numerify('+91########'),
            'address' => fake()->address(),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'religion' => fake()->randomElement(['hindu', 'muslim', 'christian']),
            'blood_group' => fake()->randomElement(['a+', 'a-', 'b+', 'b-', 'o+', 'o-', 'ab+', 'ab-']),
            'nationality' => fake()->randomElement(['indian', 'pakistani', 'bangladeshi', 'chinese', 'other']),
            'status' => 1,

        ];
    }
}
