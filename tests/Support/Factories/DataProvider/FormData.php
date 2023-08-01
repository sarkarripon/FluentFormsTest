<?php
namespace Tests\Support\Factories\DataProvider;

class FormData extends ShortCodes
{
    public static function countryName(): string
    {
        $faker = \Faker\Factory::create();
        $singleWordCountry = explode('(', $faker->country);
        if (strlen($singleWordCountry[0]) >= 4) {
            return trim($singleWordCountry[0]);
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
                'dateTime' => $faker->date($format = 'Y-m-d', $max = 'now'),
            ]
        ];
    }
    public static function fieldDataForConditionalForm(): array
    {
        $faker = \Faker\Factory::create();

        return [
            [
                'id'=> 1,
                'first_name' => 'John '.$faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->userName . '@gmail.com',
            ],
            [
                'id'=> 2,
                'first_name' => $faker->firstName,
                'last_name' => 'Doe',
                'email' => $faker->unique()->userName . '@live.com',
            ]
        ];
    }


}

