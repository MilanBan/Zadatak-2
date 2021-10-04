<?php

namespace App\controllers;

use App\controllers\UserController;

class InternController extends UserController {

    protected function setIntern($first_name, $last_name, $role_id, $group_id) {
        
        $role_id = 2;

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
    
    protected function getInterns() {

        $sql = 'SELECT users.id, users.first_name, users.last_name, users.role_id, groups.name as group_name, comments.content
                FROM users 
                LEFT JOIN groups ON users.group_id = groups.id
                LEFT JOIN comments ON users.id = comments.user_id
                WHERE role_id = 2';
        
        return $this->getUsers($sql);
    }
    
    protected function getSingleIntern($id) {

        $sql = 'SELECT users.id, users.first_name, users.last_name, users.role_id, groups.name as group_name, comments.content
                FROM users
                LEFT JOIN groups ON users.group_id = groups.id
                LEFT JOIN comments ON users.id = comments.user_id 
                WHERE users.id = '.$id.' AND users.role_id = 2';
        
        return $this->getUsers($sql);
    }

    protected function updateIntern($id, $first_name, $last_name, $role_id, $group_id ){
        //grab user-intern
        $user = $this->getSingleIntern($id);

        //set args
        if($first_name == null){
            $first_name = $user[0]['first_name'];
        }
        if($last_name == null){
            $last_name = $user[0]['last_name'];
        }
        if($role_id == null){
            $role_id = $user[0]['role_id'];
        }
        if($group_id == null){
            $group_id = $user[0]['group_id'];
        }
        
        // group check
        if($group_id == 1 || $group_id == 2) {
            $this->group_id = $group_id;
        }else{
            $group_id = 3;
        }

        $data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role_id' => $role_id,
            'group_id' => $group_id,
            'id' => $id
        ];
    
        return $this->updateUser($data);
    }

    protected function deleteIntern($id) {
        
        $role_id = 2;
        return $this->deleteUser($id, $role_id);
    }
    
    
}