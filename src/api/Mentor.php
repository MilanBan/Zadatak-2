<?php

namespace App\api;

use App\controllers\MentorController;

class Mentor extends MentorController {
    
    public function create($first_name=null, $last_name=null, $group_id=null) {

        return json_encode(MentorController::setMentor($first_name, $last_name, $group_id));
    }

    public function show($id = null) {

        if($id){
            
            return json_encode(MentorController::getSingleMentor($id));

        }if(!$id){
            
            return json_encode(MentorController::getMentors());
            
        }
    }

    public function update($id, $first_name=null, $last_name=null, $group_id=null ) {
        
        return json_encode(MentorController::updateMentor($id, $first_name, $last_name, $group_id));
    }


    public function delete($id) {

        return json_encode(MentorController::deleteMentor($id));
    }
}