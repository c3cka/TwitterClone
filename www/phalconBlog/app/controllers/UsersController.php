<?php

use Phalcon\Mvc\Model\Criteria,
    #Phalcon\Mvc\Model\Validator\Email as Email,
    Phalcon\Paginator\Adapter\Model as Paginator;

class UsersController extends ControllerBase {

    /**
     * Index action
     */
    public function indexAction() {
        $this->persistent->parameters = null;
        if ($this->cookies->has('user_id')) {
            $this->session->set('user_id', $this->cookies->get('user_id'));
        }
        if ($this->session->has("user_id")) {
            $this->dispatcher->forward([
                    "controller" => "users",
                    "action" => "search"
            ]);
            return;
        }
    }

    /**
     * Login action
     */
    public function loginAction() {
        if ($this->request->isPost()) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = Users::findFirst($username);
            if ($user && $this->security->checkHash($password, $user->password)) {
                $this->session->set("user_id", $user->id);
                $this->cookies->set('user_id', $user->id);
                $this->session->set('auth', array(
                    'id' => $user->id,
                    'name' => $user->name
                ));
                $this->flash->success("Welcome " . $user->name);
            }else{
                $this->flash->error("Username and Password combination not found");
            }
        }
        $this->dispatcher->forward([
                "controller" => "posts",
                "action" => "index"
        ]);
        return;
    }

    /**
     * Logout action
     */
    public function logoutAction() {
        $this->cookies->delete("user_id");
        $this->session->destroy();
        $this->flash->success("You have been logged out");
        $this->dispatcher->forward([
                "controller" => "posts",
                "action" => "index"
        ]);
        return;
    }

    /**
     * Searches for users
     */
    public function searchAction() {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Users", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $users = Users::find($parameters);
        if (count($users) == 0) {
            $this->flash->notice("The search did not find any users");
            $this->dispatcher->forward([
                    "controller" => "users",
                    "action" => "index"
            ]);
            return;
        }

        $paginator = new Paginator(array(
            "data" => $users,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displayes the creation form
     */
    public function newAction() {

    }

    /**
     * Edits a user
     *
     * @param string $id
     */
    public function editAction($id) {

        if (!$this->request->isPost()) {

            $user = Users::findFirst($id);
            if (!$user) {
                $this->flash->error("user was not found");
                $this->dispatcher->forward([
                        "controller" => "users",
                        "action" => "index"
                ]);
                return;
            }

            $this->view->id = $user->id;

            $this->tag->setDefault("id", $user->id);
            $this->tag->setDefault("username", $user->username);
            $this->tag->setDefault("password", $user->password);
            $this->tag->setDefault("name", $user->name);
            $this->tag->setDefault("email", $user->email);

        }
    }

    /**
     * Creates a new user
     */
    public function createAction() {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                    "controller" => "users",
                    "action" => "index"
            ]);
            return;
        }

        $user = new Users();

        $user->id = $this->request->getPost("id");
        $user->username = $this->request->getPost("username");
        $password = $this->request->getPost("password");
        $user->password = $this->security->hash($password);
        $user->name = $this->request->getPost("name");
        $user->email = $this->request->getPost("email", "email");


        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }
            $this->dispatcher->forward([
                    "controller" => "users",
                    "action" => "new"
            ]);
            return;
        }

        $this->flash->success("user was created successfully");
        $this->dispatcher->forward([
                "controller" => "users",
                "action" => "index"
        ]);
        return;

    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction() {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                    "controller" => "users",
                    "action" => "index"
            ]);
        }

        $id = $this->request->getPost("id");

        $user = Users::findFirst($id);
        if (!$user) {
            $this->flash->error("user does not exist " . $id);
            $this->dispatcher->forward([
                    "controller" => "users",
                    "action" => "index"
            ]);
        }

        $user->id = $this->request->getPost("id");
        $user->username = $this->request->getPost("username");
        $password = $this->request->getPost("password");
        $user->password = $this->security->hash($password);
        $user->name = $this->request->getPost("name");
        $user->email = $this->request->getPost("email", "email");


        if (!$user->save()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                    "controller" => "users",
                    "action" => "edit",
                    "params" => array($user->id)
            ]);
        }

        $this->flash->success("user was updated successfully");
        $this->dispatcher->forward([
                "controller" => "posts",
                "action" => "index"
        ]);

    }

    /**
     * Deletes a user
     *
     * @param string $id
     */
    public function deleteAction($id) {

        $user = Users::findFirst($id);
        if (!$user) {
            $this->flash->error("user was not found");
            $this->dispatcher->forward([
                    "controller" => "users",
                    "action" => "index"
            ]);
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                    "controller" => "users",
                    "action" => "search"
            ]);
        }

        $this->flash->success("user was deleted successfully");
        $this->dispatcher->forward([
                "controller" => "users",
                "action" => "index"
        ]);
    }

}