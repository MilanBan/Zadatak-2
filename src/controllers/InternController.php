<?php

namespace App\controllers;

use PDO;
use App\controllers\UserController;

class InternController extends UserController {

    public function setIntern($first_name, $last_name, $role_id, $group_id) {
        $role_id = 2;
        $sql = 'INSERT INTO users(first_name, last_name, role_id, group_id) VALUES (?, ?, ?, ?)';
        
        $array = [];
        array_push($array, $first_name, $last_name, $role_id, $group_id);
        
        return $this->setUser($sql, $array);
    }
    
    public function getInterns() {

        $sql = 'SELECT * FROM users WHERE role_id = 2';
        
        return $this->getUsers($sql);
    }
    
    public function getSingleIntern($id) {

        $sql = 'SELECT * FROM users WHERE id = '.$id.' AND role_id = 2';
        
        return $this->getUsers($sql);
    }

    public function deleteIntern($id) {
        
        return $this->deleteUser($id);
    }
    
    
}