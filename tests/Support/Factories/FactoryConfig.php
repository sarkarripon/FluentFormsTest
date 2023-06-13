<?php
use League\FactoryMuffin\FactoryMuffin;

$fm = new FactoryMuffin();
try {
    $fm->loadFactories(__DIR__ . '/factories');
} catch (\League\FactoryMuffin\Exceptions\DirectoryNotFoundException $e) {
}

return $fm;
