<?php

namespace App\controllers;

use PDO;
use App\config\Database;

class CommentController extends Database {

    public function set($mentor_id, $intern_id, $content) {
        
        $sql = 'INSERT INTO comments(author_id, user_id, content) VALUES (?, ?, ?)';
        

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$mentor_id, $intern_id, $content]);

        return 'Comment created';
    }

    protected function getList() {
        //comment with author
        $sql1 = 'SELECT comments.id, comments.author_id, comments.user_id, users.first_name, users.last_name, comments.content
                FROM comments
                LEFT JOIN users ON comments.author_id = users.id
                ';
        //comment with intern
        $sql2 = 'SELECT comments.id, users.first_name, users.last_name
                FROM comments
                LEFT JOIN users ON comments.user_id = users.id
                ';

        $stmt1 = $this->connect()->query($sql1)->fetchAll(PDO::FETCH_ASSOC);
        $stmt2 = $this->connect()->query($sql2)->fetchAll(PDO::FETCH_ASSOC);

        for($i=0; $i<count($stmt1); $i++){
            $stmt[] = [
                'id' => $stmt1[$i]['id'],
                'comment' => $stmt1[$i]['content'],
                'made by' => $stmt1[$i]['first_name'].' '.$stmt1[$i]['last_name'],
                'made for' => $stmt2[$i]['first_name'].' '.$stmt2[$i]['last_name'],
            ];
        }

        $stmt = json_encode($stmt);
        
        return $stmt;
    }

    protected function getSingleComment($id) {

        //comment with author
        $sql1 = 'SELECT comments.id, comments.author_id, comments.user_id, users.first_name, users.last_name, comments.content
                FROM comments
                LEFT JOIN users ON comments.author_id = users.id
                WHERE users.id = '.$id;

        $stmt1 = $this->connect()->query($sql1)->fetchAll(PDO::FETCH_ASSOC);

        $intern_id = $stmt1[0]['user_id'];

        //comment with intern
        $sql2 = 'SELECT comments.id, users.first_name, users.last_name
                FROM comments
                LEFT JOIN users ON comments.user_id = users.id
                WHERE users.id = '.$intern_id;

        $stmt2 = $this->connect()->query($sql2)->fetchAll(PDO::FETCH_ASSOC);

        for($i=0; $i<count($stmt1); $i++){
            $stmt[] = [
                'id' => $stmt1[$i]['id'],
                'comment' => $stmt1[$i]['content'],
                'made by' => $stmt1[$i]['first_name'].' '.$stmt1[$i]['last_name'],
                'made for' => $stmt2[$i]['first_name'].' '.$stmt2[$i]['last_name'],
            ];
        }

        $stmt = json_encode($stmt);
        
        return $stmt;
    }

    protected function deleteComment($id) {
        
        $stmt = $this->connect()->prepare('DELETE FROM comments WHERE id = ?');
        $stmt->execute([$id]);
    }
}
