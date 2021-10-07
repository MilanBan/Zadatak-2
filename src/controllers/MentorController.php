<?php

namespace App\controllers;

use PDO;
use App\controllers\UserController;

class MentorController extends UserController {

    protected function setMentor($first_name, $last_name, $group_id, $role_id=1) {
        
        if(!is_string($first_name) || !is_string($last_name)){
            return ['First name and Last name are required'];
        }

        $first_name = trim(ucwords(strtolower($first_name)));
        $last_name = trim(ucwords(strtolower($last_name)));
        $role_id=1;

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
        
        return ['Mentor '.$first_name.' '.$last_name.' is created successfully.'];
    }
    
    protected function updateMentor(int $id, string $first_name=null, string $last_name=null, int $group_id=null, $role_id=1 ){

        if(!is_string($first_name) || !is_string($last_name)){
            return ['First name and Last name are required'];
        }

        $first_name = trim(ucwords(strtolower($first_name)));
        $last_name = trim(ucwords(strtolower($last_name)));
        $role_id=1;

        // group check
        if($group_id !== null){
            if(!$this->checkGroup($group_id)){
                $group_id = null;
            }
        };

        $u = $this->isExist($id);
        
        if($u && $u[0]['role_id'] == 1){
            //grab user-mentor
            
            $user = json_decode(json_encode($this->getSingleMentor($id)), true);
        }else{
            return ['Mentor with id='.$id.' does not exist.'];
        }
        
        //set args
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

        return ['Mentor with id='.$id.' is successfully updated.'];
    }
    
    protected function getMentors() {
        
        $sqlG = 'SELECT users.id, users.first_name, users.last_name, users.role_id, groups.g_code as group_name
                FROM users 
                LEFT JOIN groups ON users.group_id = groups.id
                WHERE role_id = 1';

        $mgs = $this->getUsers($sqlG); //array users-mentors
        $array =[];

        foreach($mgs as $mg){

            $sqlC = 'SELECT comments.id, comments.author_id, comments.content,comments.created_at, users.first_name, users.last_name
                    FROM comments 
                    LEFT JOIN users ON comments.user_id = users.id
                    WHERE author_id ='. $mg['id'];
            $mcs = $this->getUsers($sqlC); //array comments of mentor

            $data = [
                'id' => $mg['id'],
                'first_name' => $mg['first_name'],
                'last_name' => $mg['last_name'],
                'group_name' => $mg['group_name'],
                'comments' => []
            ];

            foreach($mcs as $mc){
                if($mg['id'] == $mc['author_id']){

                    $dataC = [
                        'id' => $mc['id'],
                        'intern' => $mc['first_name'].' '.$mc['last_name'],
                        'content' => $mc['content'],
                        'created_at' => $mc['created_at']
                    ];

                    array_push($data['comments'], $dataC);
                }
            }

            array_push($array, $data);
            
        }

        return $array;
    }
    
    protected function getSingleMentor($id) {

        if(!is_int($id)){
            return ['ID of mentor must be number.'];
        }

        $sqlG = 'SELECT users.id, users.first_name, users.last_name, users.role_id, groups.g_name as group_name
                FROM users 
                LEFT JOIN groups ON users.group_id = groups.id
                WHERE role_id = 1 AND users.id='.$id;

        $mg = $this->getUsers($sqlG); //array user with group
        
        if(!$mg) {
            return ['Mentor with id='.$id.' does not exist.'];
        }

        $sqlC = 'SELECT comments.id, comments.author_id, comments.content,comments.created_at, users.first_name, users.last_name
                FROM comments 
                LEFT JOIN users ON comments.user_id = users.id
                WHERE author_id ='.$mg[0]['id'];

        $mcs = $this->getUsers($sqlC); //array mentor comments

        $data = [
            'id' => $mg[0]['id'],
            'mentor' => $mg[0]['first_name'].' '.$mg[0]['last_name'],
            'group_name' => $mg[0]['group_name'],
            'comments' => []
        ];

        foreach($mcs as $mc){
            if($mg[0]['id'] == $mc['author_id']){

                $dataC = [
                    'id' => $mc['id'],
                    'intern' => $mc['first_name'].' '.$mc['last_name'],
                    'content' => $mc['content'],
                    'created_at' => $mc['created_at']
                ];

                array_push($data['comments'], $dataC);
            }
        }


        return $data;
    }

    protected function deleteMentor($id) {
        if(!is_int($id)){
            return ['ID of mentor for deletion must be number.'];
        }
        $u = $this->isExist($id);
        if($u && $u[0]['role_id'] == 1){
            $this->deleteUser($id,1);
            return ['Mentor with id='.$id.' is successfully deleted.'];
        }return ['Mentor with id='.$id.' does not exist.'];
    }

    //helper
    protected function isExist($param) {
        $stmt = [];
        if(is_int($param)){

            $sql = 'SELECT * FROM users WHERE id='.$param; 
            $stmt = $this->connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $res = $stmt;
        }
        return $res;
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
    
}