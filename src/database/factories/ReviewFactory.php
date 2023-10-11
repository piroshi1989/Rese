<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Review::class;

    public function definition()
    {
        $shopId = $this->faker->numberBetween(1, 20);
        $userId = $this->faker->numberBetween(1, 5);
    
        // すでに存在する組み合わせであれば、ランダムに再生成
        while (Review::where('shop_id', $shopId)->where('user_id', $userId)->exists()) {
            $shopId = $this->faker->numberBetween(1, 20);
            $userId = $this->faker->numberBetween(1, 5);
        }
    
        return [
            'user_id' => $userId,
            'shop_id' => $shopId,
            'rating' =>  $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->realText(200),
        ];
    }
}
