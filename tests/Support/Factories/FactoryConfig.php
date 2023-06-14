<?php
use League\FactoryMuffin\FactoryMuffin;

$fm = new FactoryMuffin();
try {
    $fm->loadFactories(__DIR__ . '/Factories');
} catch (\League\FactoryMuffin\Exceptions\DirectoryNotFoundException $e) {
}

return $fm;
