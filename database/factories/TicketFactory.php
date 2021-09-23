<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
                'title' => $this->faker->sentence(rand(5,15)),
                'descr' => $this->faker->text(rand(50,500)),
                'created_at' => $this->faker->dateTimeBetween('-4 week', 'now'),
                'user_id' => User::inRandomOrder()->first(),
                'status_id' => rand(1,3),
                'priority_id' => rand(1,3),
                'category_id' => rand(1,3),
        ];
    }
}
