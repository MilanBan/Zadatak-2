<?php

// use App\models\Intern.php;

include_once 'src/config/Database.php';

require_once realpath("vendor/autoload.php");

echo "Index page";

$obj = new Database();
$obj->connect();

?>