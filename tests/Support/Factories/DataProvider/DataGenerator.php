<?php

namespace Tests\Support\Factories\DataProvider;

class DataGenerator
{
    protected $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    public function generatedData(array $keys): array
    {
        $data = [];
        $password = "#" . $this->faker->word() . $this->faker->randomNumber(2) . $this->faker->word() . "@";

        foreach ($keys as $key => $value) {
            if ($key == 'Password') {
                $data[$key] = $password;
            } elseif ($key == 'Repeat Password') {
                $data[$key] = $password;
            } else {
                $data[$key] = $this->faker->$value;
            }
        }
        return $data;
    }
}
