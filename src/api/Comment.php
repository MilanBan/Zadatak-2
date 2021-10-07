<?php

namespace App\api;

use App\controllers\CommentController;

class Comment extends CommentController {
    
    public function create($mentor_id, $intern_id, $content) {
        
        return json_encode(CommentController::set($mentor_id, $intern_id, $content));
    }

    public function update($id, $content=null) {
        
        return json_encode(CommentController::update($id, $content));
    }

    public function show($author_id = null) {

        if($author_id){
            
            return json_encode(CommentController::getSingleComment($author_id));
            
        }if(!$author_id){
            
            return json_encode(CommentController::getList());
        }
    }

    public function delete($id) {

        return json_encode(CommentController::deleteComment($id));
    }
}