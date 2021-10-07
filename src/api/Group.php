<?php

namespace App\api;

use App\controllers\GroupController;

class Group extends GroupController {
    
    public function create($g_name, $g_code) {
        
        return json_encode(GroupController::set($g_name, $g_code));
    }

    public function update($id, $g_name=null, $g_code=null) {
        
        return json_encode(GroupController::update($id, $g_name, $g_code));
    }

    public function show($author_id = null) {

        if($author_id){
            
            return json_encode(GroupController::getSingleGroup($author_id));
        }if(!$author_id){
            
            return json_encode(GroupController::getListOfGroups());
        }
    }

    public function delete($id) {

        return json_encode(GroupController::deleteGroup($id));
    }
}