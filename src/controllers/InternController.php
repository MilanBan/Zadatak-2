<?php

namespace App\controllers;

use PDO;
use App\controllers\UserController;

class InternController extends UserController {

    protected function setIntern($first_name, $last_name, $group_id, $role_id=2) {
        
        if(!is_string($first_name) || !is_string($last_name)){
            return ['First name and Last name are required and must be string.'];
        }

        $first_name = trim(ucwords(strtolower($first_name)));
        $last_name = trim(ucwords(strtolower($last_name)));
        $role_id=2;

        // first and last name check
        if(strlen($first_name) < 1 || strlen($first_name) < 1){
            return ['First Name and Last Name must must have at least one characters.'];
        }

        // group check
        if($group_id !== null){
            if(!$this->checkGroup($group_id)){
                $group_id = null;
            }
        };
        
        $sql = 'INSERT INTO users(first_name, last_name, group_id, role_id) VALUES (?, ?, ?, ?)';
        
        $array = [];
        array_push($array, $first_name, $last_name, $group_id, $role_id);
        
        $this->setUser($sql, $array);

        return ['Intern '.$first_name.' '.$last_name.' is created successfully.'];

    }
    
    protected function getInterns() {

        $sqlG = 'SELECT users.id, users.first_name, users.last_name, users.role_id, groups.g_code as group_name
                FROM users 
                LEFT JOIN groups ON users.group_id = groups.id
                WHERE role_id = 2';
        
        $igs = $this->getUsers($sqlG); //array of interns
        $array = [];

        foreach($igs as $ig){

            $sqlC = 'SELECT comments.id, comments.user_id, comments.content, comments.created_at, users.first_name, users.last_name
                    FROM comments 
                    LEFT JOIN users ON comments.author_id = users.id 
                    WHERE user_id ='. $ig['id'];
            $ics = $this->getUsers($sqlC); //array comments of intern with author_id

            $data = [
                'id' => $ig['id'],
                'intern' => $ig['first_name'].' '.$ig['last_name'],
                'group_name' => $ig['group_name'],
                'comments' => []
            ];

            foreach($ics as $ic){
                if($ig['id'] == $ic['user_id']){

                    $dataC = [
                        'id' => $ic['id'],
                        'mentor' => $ic['first_name'].' '.$ic['last_name'],
                        'content' => $ic['content'],
                        'created_at' => $ic['created_at']
                    ];

                    array_push($data['comments'], $dataC);
                }
            }

            array_push($array, $data);
            
        }

        return $array;
    }
    
    protected function getSingleIntern($id) {

        if(!is_int($id)){
            return ['ID of intern must be number.'];
        }

        $sqlG = 'SELECT users.id, users.first_name, users.last_name, users.role_id, groups.g_name as group_name
                FROM users 
                LEFT JOIN groups ON users.group_id = groups.id
                WHERE users.id = '.$id.' AND users.role_id = 2';
        
        $ig = $this->getUsers($sqlG); //array interns with group
        
        if(!$ig) {
            return ['Intern with id='.$id.' does not exist.'];
        }

        $sqlC = 'SELECT comments.id, comments.user_id, comments.content,comments.created_at, users.first_name, users.last_name
                FROM comments 
                LEFT JOIN users ON comments.author_id = users.id
                WHERE user_id ='.$ig[0]['id'];

        $ics = $this->getUsers($sqlC); //array intern comments

        $data = [
            'id' => $ig[0]['id'],
            'intern' => $ig[0]['first_name'].' '.$ig[0]['last_name'],
            'group_name' => $ig[0]['group_name'],
            'comments' => []
        ];

        foreach($ics as $ic){
            if($ig[0]['id'] == $ic['user_id']){

                $dataC = [
                    'id' => $ic['id'],
                    'mentor' => $ic['first_name'].' '.$ic['last_name'],
                    'content' => $ic['content'],
                    'created_at' => $ic['created_at']
                ];

                array_push($data['comments'], $dataC);
            }
        }


        return $data;
    }

    protected function updateIntern(int $id, string $first_name=null, string $last_name=null, int $group_id=null, $role_id=2 ){
        
        if(!is_string($first_name) || !is_string($last_name)){
            return ['First name and Last name are required'];
        }
        
        $first_name = trim(ucwords(strtolower($first_name)));
        $last_name = trim(ucwords(strtolower($last_name)));
        $role_id=2;

        if($group_id !== null){
            if(!$this->checkGroup($group_id)){
                $group_id = null;
            }
        };

        $u = $this->isExist($id);

        if($u && $u[0]['role_id'] == 2){
            //grab user-intern
            
            $user = json_decode(json_encode($this->getSingleIntern($id)), true);
        }else{
            return ['Intern with id='.$id.' does not exist.'];
        }

        //check args
        if($first_name == null){
            $first_name = $user['first_name'];
        }
        if($last_name == null){
            $last_name = $user['last_name'];
        }
        if($group_id == null){
            $group_id = $user['group_id'];
        }
        
        $data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role_id' => $role_id,
            'group_id' => $group_id,
            'id' => $id
        ];
    
        $this->updateUser($data);

        return ['Intern with id='.$id.' is successfully updated.'];
    }

    protected function deleteIntern($id) {
        if(!is_int($id)){
            return ['ID of mentor for deletion must be number.'];
        }
        $u = $this->isExist($id);
        
        if($u && $u[0]['role_id'] == 2){
            $this->deleteUser($id,2);
            return ['Intern with id='.$id.' is successfully deleted.'];
        }return ['Intern with id='.$id.' does not exist.'];
    }


    //helper
    protected function checkGroup($param) {
        $stmt = [];
        if(is_int($param)){

            $sql = 'SELECT * FROM groups WHERE id='.$param; 
            $stmt = $this->connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $res = $stmt;
        }
        return $res;
    }
    protected function isExist($param) {
        $stmt = [];
        if(is_int($param)){

            $sql = 'SELECT * FROM users WHERE id='.$param; 
            $stmt = $this->connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $res = $stmt;
        }
        return $res;
    }
    
}