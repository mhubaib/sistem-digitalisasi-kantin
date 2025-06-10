<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\products>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = ['oreo', 'nabati cokelat', 'nabati keju', 'roma', 'malkist', 'malkist keju', 'malkist cokelat', 'classic cokelat', 'nipis madu', 'coca cola', 'big cola'];
        $kategories = ['snack', 'minuman', 'makanan'];
        $statuses = ['active', 'inactive'];

        return [
            'name' => $this->faker->randomElement($names),
            'category' => $this->faker->randomElement($kategories),
            'status' => $this->faker->randomElement($statuses),
            'price' => $this->faker->numberBetween(10000, 100000),
            'stock' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence(),
        ];
    }
}
