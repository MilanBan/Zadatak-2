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

    protected function deleteUser($id) {
        
        $stmt = $this->connect()->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);

    }
}
