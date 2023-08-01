<?php

namespace Tests\Support\Factories\DataProvider;

/**
 * possible patters:
 *
 * first name, First Name, FANME, first_name,First_Name, fname
 * last name, Last Name, LANME, last_name, Last_Name
 * address, Address, ADDRESS
 * address_1, Address_1, address_line_1, Address_Line_1, ADDRESS_1 , ADDR_1
 * address_2, Address_2, address_line_2, Address_Line_2, ADDRESS_2, ADDR_2
 * phone, Phone, PHONE, phone_number, Phone_Number, PHONE_NUMBER, phone_number, Phone_Number
 * birthday, Birthday, BIRTHDAY, birth_date, Birth_Date, BIRTH_DATE, birthdate, Birthdate, BIRTHDATE, Birth_day, BIRTH_DAY, birth_day, Birth_Day
 *
 */

class ShortCodes
{
        private string $firstName = '\b[Ff]([A-Za-z]+)[ _-]?[Nn]?([A-Za-z]*)[ _-]?[Aa]?([A-Za-z]*)[ _-]?[Mm]?([A-Za-z]*)[ _-]?[Ee]?([A-Za-z]*)\b';
        private  string $lastName = '\b[Ll]([A-Za-z]+)[ _-]?[Aa]?([A-Za-z]*)[ _-]?[Nn]?([A-Za-z]*)[ _-]?[Mm]?([A-Za-z]*)[ _-]?[Ee]?([Aza-z]*)\b';
        private string $address = '\b[aA][dD]{2}[rR][eE][sS]{2}\b|\b[Aa][dD]{2}[rR]\b';
        private string $address_1 = '\b[aA][dD]{2}[rR][eE][sS][sS]?[_-]?[lL]?[iI]?[nN]?[eE]?[_-]?1\b';
        private string $address_2 = '\b[aA][dD]{2}[rR][eE][sS][sS]?[_-]?[lL]?[iI]?[nN]?[eE]?[_-]?2\b';
        private string $phoneNumber = '\b[pP][hH][oO][nN][eE][ _-]?[nN]?[uU]?[mM]?[bB]?[eE]?[rR]?\b';
        private string $birthDate = '\b[bB][iI][rR][tT][hH][-_]?[dD][aA][yY]?[-_]?[bB]?[iI]?[rR]?[tT]?[hH]?[dD]?[aA]?[tT]?[eE]?\b';

    public function shortCodePool(): array
    {
        return [
            $this->firstName => '{inputs.names.first_name}',
            $this->lastName => '{inputs.names.last_name}',
            $this->address => '{inputs.address_1}',
            $this->address_1 => '{inputs.address_1}',
            $this->address_2 => '{inputs.address_2}',
            $this->birthDate => '{inputs.datetime}',
            $this->phoneNumber => '{inputs.phone}',
        ];
    }

    public function getPreparedArray(array $keys): array
    {
        $shortCodePool = $this->shortCodePool();
        $preparedArray = [];

        foreach ($keys as $key) {
            foreach ($shortCodePool as $pattern => $value) {
                if (preg_match("/$pattern/", $key)) {
                    $preparedArray[$key] = $value;
                    break; // Break the loop after finding a match
                }
            }
        }
        return $preparedArray;
    }
}
