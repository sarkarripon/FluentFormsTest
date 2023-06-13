<?php
namespace Tests\Support\Factories\DataProvider;

use League\FactoryMuffin\Faker\Facade as Faker;
use Tests\Support\Factories\User;


class FormData
{

    public static function fieldData() : array
    {
        return [
            [
                'first_name'=>"Sarkar",
                'last_name'=>"Ripon",
                'email'=>"etlldnkbtzp@internetkeno.com",
                'address_line_1'=>"Authlab 24/A, Jalalabad R/A",
                'address_line_2'=>"Sylhet Sadar",
                'city'=>"Sylhet",
                'state'=>"Sylhet",
                'zip'=>"3100",
                'country'=>"Bangladesh",
                'phone'=>"01700000000",
            ]

        ];
    }

    public function dataLake()
    {
        $fm->define(User::class)->setDefinitions([
            'name'   => Faker::name(),

            // generate email
            'email'  => Faker::email(),
            'body'   => Faker::text(),

            // generate a profile and return its Id
            'profile_id' => 'factory|Profile'
        ]);
    }



}
