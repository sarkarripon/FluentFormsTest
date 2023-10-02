<?php

namespace Tests\Support\Factories\DataProvider;
use Hackzilla\PasswordGenerator\Generator\RequirementPasswordGenerator;

trait DataGenerator
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
//        $generator = new RequirementPasswordGenerator();
//        $generator
//            ->setLength(16)
//            ->setOptionValue(RequirementPasswordGenerator::OPTION_UPPER_CASE, true)
//            ->setOptionValue(RequirementPasswordGenerator::OPTION_LOWER_CASE, true)
//            ->setOptionValue(RequirementPasswordGenerator::OPTION_NUMBERS, true)
//            ->setOptionValue(RequirementPasswordGenerator::OPTION_SYMBOLS, true)
//            ->setMinimumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 2)
//            ->setMinimumCount(RequirementPasswordGenerator::OPTION_LOWER_CASE, 2)
//            ->setMinimumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 2)
//            ->setMinimumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 2)
//            ->setMaximumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 8)
//            ->setMaximumCount(RequirementPasswordGenerator::OPTION_LOWER_CASE, 8)
//            ->setMaximumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 8)
//            ->setMaximumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 8)
//        ;
//        $password = $generator->generatePasswords()[0];

//        $password = $this->faker->password(10, 18);

        foreach ($keys as $key => $value) {
            if ($value == 'password') {
                if (is_array($value)) {
                    foreach ($value as $method => $argument) {
                        $password = self::generatePassword(...$argument);
                        $generatedData[$key] = $password;
                    }
                }else{
                    $password = self::generatePassword(10, true, true, true, true);
                    $generatedData[$key] = $password;
                }

            }elseif ($value=='email'){
                $generatedData[$key] = $this->faker->userName() . '@' . self::randEmailTld();

            } elseif ($key == 'Repeat Password') {
                $generatedData[$key] = $password;

            }elseif ($value == 'url') {
                $generatedData[$key] = "https://www.sarkarripon.com/".$this->faker->userName();

            } elseif (!is_array($value) && strcasecmp($value, 'status') === 0) {
                $generatedData[$key] = self::taskStatus();

            } else {
                if (is_array($value)) {
                    foreach ($value as $method => $argument) {
                        $generatedData[$key] = $this->faker->{$method}($argument);
                    }
                }else{
                    $generatedData[$key] = $this->faker->{$value}();
                }
            }
        }
        return $generatedData;
    }

    public static function generatePassword(
        int $length,
        bool $useUpperCase = true,
        bool $useLowerCase = true,
        bool $useNumbers = true,
        bool $useSymbols = false
    ): string {
        $generator = new RequirementPasswordGenerator();
        $generator
            ->setLength($length)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_UPPER_CASE, $useUpperCase)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_LOWER_CASE, $useLowerCase)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_NUMBERS, $useNumbers)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_SYMBOLS, $useSymbols)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 2)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_LOWER_CASE, 2)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 2)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 0)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 8)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_LOWER_CASE, 8)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 8)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 0);

        return $generator->generatePasswords()[0];
    }
    public static function randEmailTld(): string
    {
        $TLDs =['gmail.com', 'live.com','yahoo.com','hotmail.com','outlook.com','aol.com','zoho.com','yandex.com','protonmail.com','icloud.com','mail.com','gmx.com'];
        return $TLDs[array_rand($TLDs)];
    }

    public static function taskStatus(): string
    {
        $status = ['To do','In progress','Done'];
        return $status[array_rand($status)];
    }
}
