<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'created_at' => $this->faker->dateTimeBetween('-8 week', 'now'),
            'ticket_id' => Ticket::inRandomOrder()->first(),
            'user_id' => User::inRandomOrder()->first(),
            'content' => $this->faker->text(rand(50, 100))
        ];
    }
}
