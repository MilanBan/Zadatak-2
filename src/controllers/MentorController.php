<?php

namespace App\controllers;

use App\controllers\UserController;

class MentorController extends UserController {

    protected function setMentor($first_name, $last_name, $role_id, $group_id) {
        
        $role_id = 1;

        // group check
        if($group_id == 1 || $group_id == 2) {
            $this->group_id = $group_id;
        }else{
            $group_id = 3;
        }

        $sql = 'INSERT INTO users(first_name, last_name, role_id, group_id) VALUES (?, ?, ?, ?)';
        
        $array = [];
        array_push($array, $first_name, $last_name, $role_id, $group_id);
        
        return $this->setUser($sql, $array);
    }
    //NIJE GOTOV
    protected function updateMentor($id, ){
        $role_id = 1;
        
        // group check
        if($group_id == 1 || $group_id == 2) {
            $this->group_id = $group_id;
        }else{
            $group_id = 3;
        }

        $sql = 'UPDATE users SET (first_name, last_name, role_id, group_id) VALUES (?, ?, ?, ?)';
        
        $array = [];
        array_push($array, $first_name, $last_name, $role_id, $group_id);
        
        return $this->setUser($sql, $array);
    }
    
    protected function getMentors() {
        
        $sql = 'SELECT users.id, users.first_name, users.last_name, users.role_id, groups.name as group_name, comments.content
                FROM users 
                LEFT JOIN groups ON users.group_id = groups.id
                LEFT JOIN comments ON users.id = comments.author_id
                WHERE role_id = 1';

        return $this->getUsers($sql);
    }
    
    protected function getSingleMentor($id) {

        $sql = 'SELECT users.id, users.first_name, users.last_name, users.role_id, groups.name as group_name, comments.content
                FROM users
                LEFT JOIN groups ON users.group_id = groups.id
                LEFT JOIN comments ON users.id = comments.author_id 
                WHERE users.id = '.$id.' AND users.role_id = 1';        
        return $this->getUsers($sql);
    }

    protected function deleteMentor($id) {
        
        $role_id = 1;
        return $this->deleteUser($id, $role_id);
    }
    
    
}