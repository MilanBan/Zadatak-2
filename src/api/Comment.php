<?php

namespace App\api;

use App\controllers\CommentController;

class Comment extends CommentController {
    
    public function create($mentor_id, $intern_id, $content) {

        return CommentController::set($mentor_id, $intern_id, $content);
    }

    public function show($author_id = null) {

        if($author_id){
            
            return CommentController::getSingleComment($author_id);
        }if(!$author_id){
            
            return CommentController::getList();
        }
    }

    public function delete($id) {

        return CommentController::deleteComment($id);
    }
}