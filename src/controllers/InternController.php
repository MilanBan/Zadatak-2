<?php

namespace App\controllers;

use App\controllers\UserController;

class InternController extends UserController {

    protected function setIntern($first_name, $last_name, $role_id, $group_id) {
        $role_id = 2;
        $sql = 'INSERT INTO users(first_name, last_name, role_id, group_id) VALUES (?, ?, ?, ?)';
        
        $array = [];
        array_push($array, $first_name, $last_name, $role_id, $group_id);
        
        return $this->setUser($sql, $array);
    }
    
    protected function getInterns() {

        $sql = 'SELECT * FROM users WHERE role_id = 2';
        
        return $this->getUsers($sql);
    }
    
    protected function getSingleIntern($id) {

        $sql = 'SELECT * FROM users WHERE id = '.$id.' AND role_id = 2';
        
        return $this->getUsers($sql);
    }

    protected function deleteIntern($id) {
        
        $role_id = 2;
        return $this->deleteUser($id, $role_id);
    }
    
    
}