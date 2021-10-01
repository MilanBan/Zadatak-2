<?php

namespace App\controllers;

use App\controllers\UserController;

class MentorController extends UserController {

    protected function setMentor($first_name, $last_name, $role_id, $group_id) {
        $role_id = 1;
        $sql = 'INSERT INTO users(first_name, last_name, role_id, group_id) VALUES (?, ?, ?, ?)';
        
        $array = [];
        array_push($array, $first_name, $last_name, $role_id, $group_id);
        
        return $this->setUser($sql, $array);
    }
    
    protected function getMentors() {

        $sql = 'SELECT * FROM users WHERE role_id = 1';
        
        return $this->getUsers($sql);
    }
    
    protected function getSingleMentor($id) {

        $sql = 'SELECT * FROM users WHERE id = '.$id.' AND role_id = 1';
        
        return $this->getUsers($sql);
    }

    protected function deleteMentor($id) {
        
        $role_id = 1;
        return $this->deleteUser($id, $role_id);
    }
    
    
}