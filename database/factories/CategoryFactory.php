<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories=$this->faker->text(10);
            return [
                'name' =>   $categories,// Unique name for the category
               // A sentence as the description
                'slug' => str::slug($categories), // A URL-friendly slug
            ];
        
    }
}
