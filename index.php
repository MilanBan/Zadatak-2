<?php

use App\api\Intern;
use App\api\Mentor;
use App\api\Comment;

require_once realpath("vendor/autoload.php");

$obj_I = new Intern();
$obj_M = new Mentor();
$obj_C = new Comment();

// echo '<pre>';
print_r($obj_M->update(4, 'Nadja', 'Higl', 2,1));
// echo '</pre>';


?>