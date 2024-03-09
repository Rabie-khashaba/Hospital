<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */

class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            //'appointments' => $this->faker->randomElement(['السبت','الحد','الاتنين','التلات','الاربع','الخميس','الجمعه']),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$12$SuQuvGTZg0dsBMI0lRh1kOlQd1CM1F7mcNpVAs786nmvtZQuueCJ6', // password
            'section_id' => Section::all()->random()->id,
            'phone' => $this->faker->phoneNumber,
            //'price' => $this->faker->randomElement([100,200,300,400,500]),
            'number_of_statements'=>5,

        ];
    }
}
