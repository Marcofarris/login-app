<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

   
    public function definition(): array
    {
        return [
            'title' => $this->faker->lexify('pc serie-????'),
            'description' => $this->faker->lexify('used for: ??????'),
            'category_id' => $this->faker->numberBetween(1, 3),
            'price' => $this->faker->randomNumber(3, false)
        ];
    }
}
