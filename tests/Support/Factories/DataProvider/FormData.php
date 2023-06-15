<?php
namespace Tests\Support\Factories\DataProvider;
use Faker\Generator;

class FormData
{

    public static function fieldData() : array
    {
        $faker = \Faker\Factory::create();
        return [
            [
                'first_name'=>$faker->firstName,
                'last_name'=>$faker->lastName,
                'email'=>$faker->userName. '@gmail.com',
                'address_line_1'=>$faker->streetAddress,
                'address_line_2'=>$faker->streetAddress,
                'city'=>$faker->city,
                'state'=>$faker->state,
                'zip'=>$faker->postcode,
                'country'=>$faker->country,
                'phone'=>$faker->phoneNumber,
            ]

        ];
    }


}
