<?php

namespace App\controllers;

use PDO;
use App\config\Database;

class UserController extends Database {

    protected function setUser($sql, $array) {
        
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($array);
    }

    protected function getUsers($sql) {
        
        $stmt = $this->connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        
        return $stmt;
    }
    
    protected function deleteUser($id, $role_id) {
        
        $stmt = $this->connect()->prepare('DELETE FROM users WHERE id = ? AND role_id = ?');
        $stmt->execute([$id, $role_id]);
    }

    protected function updateUser($data){
        
        $sql = 'UPDATE users SET 
            first_name=?,
            last_name=?,
            role_id=?,
            group_id=?
            WHERE id=?';

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($data['first_name'],$data['last_name'],$data['role_id'],$data['group_id'],$data['id']));
    }

}
