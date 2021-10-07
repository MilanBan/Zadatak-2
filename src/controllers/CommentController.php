<?php

namespace App\controllers;

use PDO;
use App\config\Database;

class CommentController extends Database {

    protected function set($mentor_id, $intern_id, $content) {

        $content = trim($content);
        
        if(!is_int($mentor_id) || !is_int($intern_id)){
            return ['ID of mentor and intern must be number.'];
        }
        if(strlen($content) < 2) {
            return ['Comment must contain at least two character.'];
        }

        //grab mentor and intern
        $m = $this->connect()->query('SELECT * FROM users WHERE id='.$mentor_id.' AND role_id=1')->fetchAll(PDO::FETCH_ASSOC);
        $i = $this->connect()->query('SELECT * FROM users WHERE id='.$intern_id.' AND role_id=2')->fetchAll(PDO::FETCH_ASSOC);
        if(!$m){
            return ['Mentor with id='.$mentor_id.' does not exist'];
        }
        if(!$i){
            return ['Intern with id='.$intern_id.' does not exist'];
        }
        if($m[0]['group_id'] == $i[0]['group_id']) {
            
            $sql = 'INSERT INTO comments(author_id, user_id, content) VALUES (?, ?, ?)';
        
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$mentor_id, $intern_id, $content]);

            return ['Comment created'];

        }else return ['Mentor and intern are not the same group.'];
        
    }

    protected function update($id, $content=null) {

        $content = trim($content);

        if(!is_int($id)){
            return ['ID of comment must be number.'];
        }
        if($content !== null){
            if(strlen($content) < 2) {
                return ['Comment must contain at least two character.'];
            }
        }
        $sql= 'UPDATE comments SET content=? WHERE id=?';
        $stmt = $this->connect()->prepare($sql);
        $res = $stmt->execute([$content, $id]);
        
        return ['Comment with id='.$id.' are successfully updated.'];

    }

    protected function getList() {
        //comment with author
        $sqlM = 'SELECT comments.id, comments.author_id, comments.user_id, comments.created_at, users.first_name, users.last_name, comments.content
                FROM comments
                LEFT JOIN users ON comments.author_id = users.id
                ORDER BY comments.created_at DESC
                ';
        //comment with intern
        $sqlI = 'SELECT comments.id, users.first_name, users.last_name
                FROM comments
                LEFT JOIN users ON comments.user_id = users.id
                ';

        $cms = $this->connect()->query($sqlM)->fetchAll(PDO::FETCH_ASSOC);
        $cis = $this->connect()->query($sqlI)->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach($cms as $cm){
            foreach($cis as $ci){
                if($cm['id'] == $ci['id']){
                    $dataC = [
                        'id' => $cm['id'],
                        'comment' => $cm['content'],
                        'made by' => $cm['first_name'].' '.$cm['last_name'],
                        'made for' => $ci['first_name'].' '.$ci['last_name'],
                        'created_at' => $cm['created_at']
                    ];
                    array_push($data, $dataC);
                }

            }
        }

        // $stmt = json_encode($stmt);
        
        return $data;
    }

    protected function getSingleComment($id) {

        if(!is_int($id)){
            return ['ID of comment must be number.'];
        }

        //comment with author
        $sqlM = 'SELECT comments.id, comments.author_id, comments.user_id, comments.content, comments.created_at, users.first_name, users.last_name 
                FROM comments
                LEFT JOIN users ON comments.author_id = users.id
                WHERE comments.id = '.$id. '
                ORDER BY comments.created_at DESC';

        $sqlI = 'SELECT comments.id, users.first_name, users.last_name 
                FROM comments
                LEFT JOIN users ON comments.user_id = users.id
                WHERE comments.id = '.$id;

        $cm = $this->connect()->query($sqlM)->fetchAll(PDO::FETCH_ASSOC);
        $ci = $this->connect()->query($sqlI)->fetchAll(PDO::FETCH_ASSOC);

        if(!$cm){
            return ['Comment with id='.$id.' does not exist.'];
        }

        $data = [
            'id' => $cm[0]['id'],
            'mentor' => $cm[0]['first_name'].' '.$cm[0]['last_name'],
            'intern' => $ci[0]['first_name'].' '.$ci[0]['last_name'],
            'content' => $cm[0]['content'],
            'created at' => $cm[0]['created_at']
        ];
        return $data;
        
    }

    protected function deleteComment($id) {
        if($this->isExist($id)){
            $stmt = $this->connect()->prepare('DELETE FROM comments WHERE id = ?');
            $stmt->execute([$id]);
        }return ['Comment with id='.$id.' does not exist.'];
    }

    //helper
    protected function isExist($param) {
        $stmt = [];
        if(is_int($param)){

            $sql = 'SELECT * FROM comments WHERE id='.$param; 
            $stmt = $this->connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $res = $stmt;
        }
        return $res;
    }
}
