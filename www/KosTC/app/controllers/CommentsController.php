<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

class CommentsController extends ControllerBase {

    public function indexAction() {
        $numberPage = $this->request->getQuery("page", "int", 1);
        $comments = Comments::query()
            ->order("submitted DESC")
            ->execute();
        $paginator = new Paginator(array(
            "data" => $comments,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
    }

    public function editAction($id) {
        if (!$this->request->isPost()) {
            $comment = Comments::findFirst($id);
            if (!$comment) {
                $this->flash->error("comment was not found");
                $this->dispatcher->forward([
                        "controller" => "comments",
                        "action" => "index"
                    ]);
            }
            $this->view->id = $comment->id;

            $this->tag->setDefault("id", $comment->id);
            $this->tag->setDefault("body", $comment->body);
            $this->tag->setDefault("name", $comment->name);
            $this->tag->setDefault("email", $comment->email);
            $this->tag->setDefault("submitted", $comment->submitted);
            $this->tag->setDefault("publish", $comment->publish);
            $this->tag->setDefault("posts_id", $comment->posts_id);
        }
    }

    public function saveAction() {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                    "controller" => "comments",
                    "action" => "index"
            ]);
        }

        $id = $this->request->getPost("id");
        $comment = Comments::findFirst($id);
        if (!$comment) {
            $this->flash->error("comment does not exist " . $id);
            $this->dispatcher->forward([
                    "controller" => "comments",
                    "action" => "index"
                ]);
        }
        $comment->id = $this->request->getPost("id");
        $comment->body = $this->request->getPost("body");
        $comment->name = $this->request->getPost("name");
        $comment->email = $this->request->getPost("email", "email");
        $comment->url = $this->request->getPost("url");
        $comment->publish = $this->request->getPost("publish");

        if (!$comment->save()) {
            foreach ($comment->getMessages() as $message) {
                $this->flash->error($message);
            }
             $this->dispatcher->forward([
                    "controller" => "comments",
                    "action" => "edit",
                    "params" => array($comment->id)
                ]);
        }
        $this->flash->success("comment was updated successfully");
         $this->dispatcher->forward([
                "controller" => "comments",
                "action" => "index"
            ]);
    }

    public function deleteAction($id) {
        $comment = Comments::findFirst($id);
        if (!$comment) {
            $this->flash->error("comment was not found");
             $this->dispatcher->forward([
                    "controller" => "comments",
                    "action" => "index"
                ]);
        }
        if (!$comment->delete()) {
            foreach ($comment->getMessages() as $message) {
                $this->flash->error($message);
            }
             $this->dispatcher->forward([
                    "controller" => "comments",
                    "action" => "search"
                ]);
        }
        $this->flash->success("comment was deleted successfully");
         $this->dispatcher->forward([
                "controller" => "comments",
                "action" => "index"
            ]);
    }
}