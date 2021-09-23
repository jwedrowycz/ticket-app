<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'filename' => $this->faker->image('public/storage/files', 1920, 1080, 'cats', false) ,
            'ticket_id' => Ticket::inRandomOrder()->first()
        ];
    }
}
