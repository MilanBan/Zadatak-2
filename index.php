<?php

// use App\controllers\User;
use App\controllers\InternController;

// include_once 'src/config/Database.php';

require_once realpath("vendor/autoload.php");

// echo "Index page";

$obj_I = new InternController();
// $obj_I->setIntern('Zarko', 'Vane', 1, 2);
// $obj_U = new User();

// $json_I = json_encode($obj_I->getInterns());
// $obj_U->setUser('John', 'Doe', 2, 1);
// $json_U = json_encode($obj_U->getUsers());
// $json_I = json_encode($obj_I->getSingleIntern(5));


// $json_U = json_encode($obj_U->deleteUser(16));
$json_I = json_encode($obj_I->deleteIntern(12));
$json_I = json_encode($obj_I->getInterns());
echo($json_I);



?>