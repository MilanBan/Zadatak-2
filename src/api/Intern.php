<?php

namespace App\api;

use App\controllers\InternController;

class Intern extends InternController {
    
    public function create($first_name, $last_name, $role_id, $group_id) {

        return InternController::setIntern($first_name, $last_name, $role_id, $group_id);

    }

    public function show($id = null) {

        if($id){
            
            return InternController::getSingleIntern($id);
            
        }if(!$id){
            
            return InternController::getInterns();
        }
    }

    public function update($id, $first_name=null, $last_name=null, $role_id=null, $group_id=null ) {
        
        return InternController::updateIntern($id, $first_name, $last_name, $role_id, $group_id);
    }

    public function delete($id) {

        return InternController::deleteIntern($id);
    }
}