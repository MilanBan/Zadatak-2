<?php

namespace App\api;

use App\controllers\MentorController;
use App\controllers\CommentController;

class Mentor extends MentorController {
    
    public function show($id = null) {

        if($id){
            
            return MentorController::getSingleMentor($id);
        }if(!$id){
            
            return MentorController::getMentors();
        }
    }

    public function update($id, $first_name=null, $last_name=null, $role_id=null, $group_id=null ) {
        
        return MentorController::updateMentor($id, $first_name, $last_name, $role_id, $group_id);
    }

    public function create($first_name, $last_name, $role_id, $group_id) {

        return MentorController::setMentor($first_name, $last_name, $role_id, $group_id);
    }

    public function delete($id) {

        return MentorController::deleteMentor($id);
    }
}