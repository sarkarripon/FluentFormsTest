#!/bin/bash

read -rp "Enter class use statement(Ex, use Tests\FormData;): " namespace
read -rp "Enter the method name(Ex, CountryName): " method_name

# Extract the class name from the namespace using regex
class_name=$(echo "$namespace" | grep -oP '(?<=\\)([^\\;]+)(?=;|$)')


# Construct the PHP code
php_code="require 'vendor/autoload.php'; $namespace echo $class_name::$method_name();"

# Display full command
echo "Incase you don't want to input again, run below command"
echo "php -r 'require \"vendor/autoload.php\"; $namespace echo $class_name::$method_name();'"

# Execute the PHP code using eval
eval "php -r \"$php_code\""


