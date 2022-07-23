<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dice1 = rand(1, 6);
        $dice2 = rand(1,6);
        

        if (($dice1 + $dice2) == 7) {
            $result = 1;
        } else {
            $result = 0;
        }

        return [
            'dice1' => $dice1,
            'dice2' => $dice2,
            'winner_loser' => $result,
            'user_id' => User::all()->random()->id
        ];
    }
}
