<?php

// use App\controllers\User;
use App\api\Intern;
use App\api\Mentor;
// use App\controllers\InternController;

// include_once 'src/config/Database.php';

require_once realpath("vendor/autoload.php");

// echo "Index page";

// $obj_I = new InternController();
$obj_I = new Intern();
$obj_M = new Mentor();
$obj_M->create('Sima', 'Simic', 1, 3);
// $obj_I->delete(16);
// $json_I = json_encode($obj_I->show(12));
$json_I = json_encode($obj_I->show());
$json_M = json_encode($obj_M->show(4));
// $obj_I->setIntern('Zarko', 'Vane', 1, 2);
// $obj_U = new User();

// $json_I = json_encode($obj_I->getInterns());
// $obj_U->setUser('John', 'Doe', 2, 1);
// $json_U = json_encode($obj_U->getUsers());
// $json_I = json_encode($obj_I->getSingleIntern(5));


// $json_U = json_encode($obj_U->deleteUser(16));
// $json_I = json_encode($obj_I->deleteIntern(12));
// $json_I = json_encode($obj_I->getInterns());
echo("Interns: ".$json_I);
echo("\n");
echo("Mentors: ".$json_M);



?>