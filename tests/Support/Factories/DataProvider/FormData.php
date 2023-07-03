<?php
namespace Tests\Support\Factories\DataProvider;

class FormData
{
    public static function countryName(): string
    {
        $faker = \Faker\Factory::create();
        $singleWordCountry = explode(' ', $faker->country);
        if (strlen($singleWordCountry[0]) >= 4) {
            return $singleWordCountry[0];
        } else {
            return 'United States';
        }
    }

    public static function fieldData(): array
    {
        $faker = \Faker\Factory::create();

        return [
            [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->userName . '@gmail.com',
                'address_line_1' => $faker->streetAddress,
                'address_line_2' => $faker->secondaryAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip' => $faker->postcode,
                'country' => self::countryName(),
                'phone' => $faker->phoneNumber,
            ]
        ];
    }
}
