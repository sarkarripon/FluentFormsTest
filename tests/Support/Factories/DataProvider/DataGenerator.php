<?php

namespace Tests\Support\Factories\DataProvider;
use Hackzilla\PasswordGenerator\Generator\RequirementPasswordGenerator;

class DataGenerator
{
    protected $faker;
    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }
    public function generatedData(array $keys): array
    {
        $generatedData = [];
         // This is conditional password generator.
        $generator = new RequirementPasswordGenerator();
        $generator
            ->setLength(16)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_UPPER_CASE, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_LOWER_CASE, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_NUMBERS, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_SYMBOLS, true)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 2)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_LOWER_CASE, 2)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 2)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 2)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 8)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_LOWER_CASE, 8)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 8)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 8)
        ;
        $password = $generator->generatePasswords()[0];

//        $password = $this->faker->password(10, 18);

        foreach ($keys as $key => $value) {
            if ($value == 'password') {
                $generatedData[$key] = $password;
            } elseif ($key == 'Repeat Password') {
                $generatedData[$key] = $password;
            }elseif ($value == 'url') {
                $generatedData[$key] = "https://www.sarkarripon.com/".$this->faker->userName();
            } else {
                $generatedData[$key] = $this->faker->{$value}();
            }
        }
        return $generatedData;
    }
}
