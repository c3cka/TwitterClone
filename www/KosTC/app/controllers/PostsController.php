<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PostsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $numberPage = $this->request->getQuery("page", "int", 1);
        $posts = Posts::find();
        $paginator = new Paginator(array(
               "data" => $posts,
               "limit"=> 10,
               "page" => $numberPage
           ));
           $this->view->page = $paginator->getPaginate();
    }

    /**
     * Searches for posts
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            //$query = Criteria::fromInput($this->di, "Posts",$_POST);
               //$this->persistent->parameters = $query->getParams();
               $this->persistent->parameters = $this->request->getPost();
           } else {
            $numberPage = $this->request->getQuery("page", "int");
        }
        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        //$parameters["order"] = "id";
        $query = $parameters['body'];
        //$posts = Posts::find($parameters);
        $phql = "SELECT * FROM Posts WHERE body LIKE '%$query%' OR
               excerpt LIKE '%$query%' OR title LIKE '%$query%' ORDER BY
                 id";
        $posts = $this->modelsManager->executeQuery($phql);

        $paginator = new Paginator([
            'data' => $posts,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a post
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $post = Posts::findFirstByid($id);
            if (!$post) {
                $this->flash->error("post was not found");

                $this->dispatcher->forward([
                    'controller' => "posts",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $post->id;

            $tagArray = array();
            foreach ($post->postTags as $postTag) {
                $tagArray[] = $postTag->tags->tag;
            }

            $this->tag->setDefault("id", $post->id);
            $this->tag->setDefault("title", $post->title);
            $this->tag->setDefault("body", $post->body);
            $this->tag->setDefault("tags", implode(",", $tagArray));

        }
    }

    /**
     * Creates a new post
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'index'
            ]);

            return;
        }

        if ($this->cookies->has('user_id')) {
            $this->session->set('user_id', $this->cookies->get('user_id'));
        }
        if (!$this->session->has("user_id")) {
            $this->flash->error("Please log in to create a post");
            $this->dispatcher->forward([
                "controller" => "users",
                "action" => "index"
            ]);
            return;
        }

        $post = new Posts();
        $post->users_id = $this->session->get("user_id");
        $post->title = $this->request->getPost("title");
        $post->body = $this->request->getPost("body");
        $post->published = $this->request->getPost("published");
        $post->tags = $this->request->getPost("tags");


        if (!$post->save()) {
            foreach ($post->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'new'
            ]);

            return;
        }

        $tags = explode(",", $this->request->getPost("tags", "lower"));
        $post->addTags($tags);

        $this->flash->success("post was created successfully");

        $this->dispatcher->forward([
            'controller' => "posts",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a post edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $post = Posts::findFirstByid($id);

        if (!$post) {
            $this->flash->error("post does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'index'
            ]);

            return;
        }

        $post->title = $this->request->getPost("title");
        $post->body = $this->request->getPost("body");
        $post->tags = $this->request->getPost("tags");

        if (!$post->save()) {

            foreach ($post->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'edit',
                'params' => [$post->id]
            ]);

            return;
        }

        $tags = explode(",", $this->request->getPost("tags", "lower"));
        $post->addTags($tags);

        $this->flash->success("post was updated successfully");

        $this->dispatcher->forward([
            'controller' => "posts",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a post
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $post = Posts::findFirstByid($id);
        if (!$post) {
            $this->flash->error("post was not found");

            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'index'
            ]);

            return;
        }

        if (!$post->delete()) {

            foreach ($post->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("post was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "posts",
            'action' => "index"
        ]);
    }

    /**
     * Shows posts
     */
    public function showAction($id)
    {
        if (!$this->request->isPost()) {
            $post = Posts::findFirst($id);
            if (!$post) {
                $this->flashSession->error("post was not found");
                $response = new \Phalcon\Http\Response();
                $response->setStatusCode(404, "Not Found");
                $response->redirect("posts/index");
            }
            $this->tag->prependTitle($post->title . " - ");
            $this->view->post = $post;
        }
    }

    public function commentAction(){
        $comment = new Comments();
        $comment->posts_id = $this->request->getPost("posts_id");
        $comment->body = $this->request->getPost("body");
        $comment->name = $this->request->getPost("name");
        $comment->email = $this->request->getPost("email");
        $comment->url = $this->request->getPost("url");
        $comment->submitted = date("Y-m-d H:i:s");
        $comment->publish = 0;
        $comment->save();

        if (!$comment->save()){
            foreach ($comment->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => 'posts',
                'action' => 'show',
                'params' => array($comment->posts_id)
            ]);
            return;
        }

        $this->flash->success("Your comment has been submitted.");
        $this->dispatcher->forward([
                'controller' => 'posts',
                'action' => 'show',
                'params' => array($comment->posts_id)
        ]);
        return;
    }
}