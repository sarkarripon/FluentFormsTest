<?php
namespace Tests\Support\Helper\Acceptance\DataProvider;

use \Codeception\Attribute\DataProvider;
use \Codeception\Example;
use Tests\Support\AcceptanceTester;


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
}
