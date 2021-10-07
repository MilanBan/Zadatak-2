<?php

namespace App\controllers;

use PDO;
use App\config\Database;

class GroupController extends Database {
    
    protected function set($g_name, $g_code) {

        $g_name = ucwords(strtolower($g_name));
        $g_code = strtoupper($g_code);

        if(strlen($g_code) !== 2){
            return ['Group short name must have exactly 2 letters.'];
        }

        if(!$this->isExist($g_name) && !$this->isExist($g_code)){
            
            $sql = 'INSERT INTO groups(g_name, g_code) VALUES (?, ?)';
        
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$g_name, $g_code]);
        
            return [$g_name.' group with short name '.$g_code.' created successfully!'];

        }if($this->isExist($g_name)){

            return ['Group with name '.$g_name.' already exist. Please pick some unique name.'];

        }if($this->isExist($g_code)){

            return ['Group with short name '.$g_code.' already exist. Please pick some unique short name.'];

        }
    }

    protected function update(int $id, $g_name=null, $g_code=null){

        //check id and grab group
        if(is_int($id) && $id !== null) {
            $g = $this->connect()->query('SELECT * FROM groups WHERE id='.$id)->fetchAll(PDO::FETCH_ASSOC);;
        }else return ['ID of group is required and must be number.'];

        $g_name = trim($g_name);
        $g_code = trim($g_code);

        //check args
        if($g_name == null) {
            $g_name = $g[0]['g_name'];
        }else{
            $g_name = ucwords(strtolower($g_name));
        }
        if($g_code == null || $g_code == '') {
            $g_code = $g[0]['g_code'];
        }else{
            $g_code = strtoupper($g_code);
            if(strlen($g_code) !== 2){
                return 'Group short name must have exactly 2 letters.';
            }
        }
        // fill data
        $data = [
            'id' => $id,
            'g_name' => $g_name,
            'g_code' => $g_code
        ];

        $sql = 'UPDATE groups SET
            g_name=?,
            g_code=?
            WHERE id=?';
            
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(array($data['g_name'],$data['g_code'],$data['id']));
      
        return ['Group with id='.$id.' are successfully updated.'];
    }

    protected function getListOfGroups() {

        $sqlG = 'SELECT * FROM groups';
        $gs = $this->connect()->query($sqlG)->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach($gs as $g) {

            $sqlU = 'SELECT id FROM users WHERE group_id='.$g['id'];
            $us = $this->connect()->query($sqlU)->fetchAll(PDO::FETCH_ASSOC);

            $dataG = [
                'id' => $g['id'],
                'name' => $g['g_name'],
                'short name' => $g['g_code'],
                'members' => count($us)
            ];

            array_push($data, $dataG);
            
        }

        return $data;
    }

    protected function getSingleGroup($id) {
        
        if(is_int($id)) {
            
            $sqlG = 'SELECT * FROM groups
                WHERE id='.$id;   
            $sqlM = 'SELECT id, first_name, last_name FROM users
                WHERE group_id='.$id.' AND role_id=1';   
            $sqlI = 'SELECT id, first_name, last_name FROM users
                WHERE group_id='.$id.' AND role_id=2';   

            $g = $this->connect()->query($sqlG)->fetchAll(PDO::FETCH_ASSOC);
            $m = $this->connect()->query($sqlM)->fetchAll(PDO::FETCH_ASSOC);
            $i = $this->connect()->query($sqlI)->fetchAll(PDO::FETCH_ASSOC);
            
         
        }else{
            return ['Group ID is required and must be a number.'];
        }
        //check if exist
        if(!$g){
            return ['Group with id='.$id.' does not exist. Please try again with deferent id.'];
        }
        // get single group with mentors and inters
        $data = [
            'id' => $g[0]['id'],
            'name' => $g[0]['g_name'],
            'mentors' => $m,
            'interns' => $i
        ];

        return $data;
    }

    protected function deleteGroup($id) {
        //check is int and exist
        if(is_int($id)){
            
            if($this->isExist($id)){
                $stmt = $this->connect()->prepare('DELETE FROM groups WHERE id = ?');
                $stmt->execute([$id]);
    
                return ['Group with id='.$id.' is deleted successfully.'];
            
            }return ['Group with id='.$id.' does not exist.'];

        }return ['Group ID is required and must be a number.'];

    }

    //helper
    protected function isExist($param) {
        $stmt = [];
        if(is_int($param)){

            $sql = 'SELECT * FROM groups WHERE id='.$param; 
            $stmt = $this->connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $res = $stmt;

        }if(is_string($param) && strlen($param) > 2){
            
                $sql = "SELECT * FROM groups WHERE g_name = ?"; 
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$param]);
    
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }if(is_string($param) && strlen($param) == 2){
        
                $sql = "SELECT * FROM groups WHERE g_code = ?"; 
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$param]);
    
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        }
        return $res;
    }

}
 