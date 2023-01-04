<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => array_rand(
                array_flip(['catalog_online', 'catalog_pdf']),
                1
            ),
            'product_photo_path' => $this->faker->text,
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'description' => $this->faker->sentence(15),
            ' button_text' => $this->faker->text(255),
            ' button_path' => $this->faker->text(255),
            'tenant_id' => \App\Models\Tenant::factory(),
            'category_product_id' => \App\Models\CategoryProduct::factory(),
        ];
    }
}
