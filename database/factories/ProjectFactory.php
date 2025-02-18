<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = [
            "Planning",
            "Ongoing",
            "Finish",
            "Cancel"
        ];
        return [
            'no_spk' => rand(10000, 30000),
            'nama_project' => $this->faker->words(4, true),
            'keterangan' => $this->faker->paragraph(),
            'customer' => "PT. ".$this->faker->sentence(3),
            'pic' => $this->faker->title()." ".$this->faker->name(),
            'due_date' => $this->faker->unique()->dateTimeInInterval($startDate = '+13 days', $interval = '+36 days', $timezone = null) ,
            'status' => $status[rand(0, 3)],
        ];
    }
}
