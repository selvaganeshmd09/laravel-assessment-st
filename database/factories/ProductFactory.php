<?php

namespace Database\Factories;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Product::class;

    public function definition()
    {

        $productItems = [
            'Smartphone', 'Laptop', 'Tablet', 'Smartwatch', 'Headphones',
            'Camera', 'Bluetooth Speaker', 'LED TV', 'Mouse', 'Chocolate', 'Cookies', 'NoteBook', 'Pencil', 'Student Bag'
        ];

        return [
            'name' => $this->faker->randomElement($productItems),
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2, 50, 1000),
            'is_delete' => false,
        ];

    }
}
