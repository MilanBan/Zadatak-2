<?php

namespace App\api;

use App\controllers\InternController;

class Intern extends InternController {
    
    public function create($first_name=null, $last_name=null, $group_id=null) {

        return json_encode(InternController::setIntern($first_name, $last_name, $group_id));
    }

    public function show($id = null) {

        if($id){
            
            return json_encode(InternController::getSingleIntern($id));
            
        }if(!$id){
            
            return json_encode(InternController::getInterns());

        }
    }

    public function update($id, $first_name=null, $last_name=null, $group_id=null ) {
        
        return json_encode(InternController::updateIntern($id, $first_name, $last_name, $group_id));
    }

    public function delete($id) {

        return json_encode(InternController::deleteIntern($id));
    }
}