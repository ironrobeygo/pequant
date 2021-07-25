<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = rand(1,4);
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence(),
            'category_id' => rand(1,6),
            'user_id' => $user,
            'updated_by' => $user,
            'status' => rand(0,1),
            'isOnline' => rand(0,1)
        ];
    }
}
