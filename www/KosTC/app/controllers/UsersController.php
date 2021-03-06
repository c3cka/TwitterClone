<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class UsersController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
        if ($this->session->has("user_id")) {
            $this->dispatcher->forward([
                "controller" => "users",
                "action" => "search"
            ]);
            return;
        }
    }

    /**
     *  Login action
     */
    public function loginAction() {
        if ($this->request->isPost()) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = Users::findFirst(array(
                "username = :username: AND password = :password:",
                'bind' => array('username' => $username, 'password' => sha1($password))
            ));

            if ($user != false) {
                $this->session->set("user_id", $user->id);
                $this->session->set("user_role", $user->role);
                $this->session->set('user_name', $user->name);
                $this->cookies->set('user_id', $user->id);
                $this->flash->success('Welcome ' . $user->name);

                $this->dispatcher->forward([
                    "controller" => "index",
                    "action" => "index",
                ]);
                return;

            }else {
                $this->flash->error('Wrong username/password! Try again');
                $this->dispatcher->forward([
                    "controller" => "users",
                    "action"     => "index",
                ]);
            }
        }
    }

    /**
     * Logout action
     */
    public function logoutAction()
    {
        $this->session->remove("user_id");
        $this->flash->success("You have been logged out");
        $this->dispatcher->forward([
            "controller" => "index",
            "action" => "index"
        ]);
        return;
    }

    /**
     * Searches for users
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Users', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
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

        $paginator = new Paginator([
            'data' => $users,
            'limit' => 10,
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
     * Edits a user
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $user = Users::findFirst($id);
            if (!$user) {
                $this->flash->error("user was not found");

                $this->dispatcher->forward([
                    'controller' => "users",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $user->id;

            $this->tag->setDefault("id", $user->id);
            $this->tag->setDefault("username", $user->username);
            #$this->tag->setDefault("password", $user->password );
            $this->tag->setDefault("name", $user->name);
            $this->tag->setDefault("email", $user->email);
            $this->tag->setDefault("role", $user->role);

        }
    }

    /**
     * Creates a new user
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);
            return;
        }

        $user = new Users();

        $user->id = $this->request->getPost("id");
        $user->username = $this->request->getPost("username");
        $user->password = $this->request->getPost("password");
        $password = $this->request->getPost("password");
        $confirm_password = $this->request->getPost("confirm_password");
        $user->name = $this->request->getPost("name");
        $user->email = $this->request->getPost("email", "email");


        if ($password != $confirm_password){
            $this->flash->error("Passwords don't match");
            $this->dispatcher->forward([
                'controller' => 'users',
                'action' => 'new'
            ]);
        }
        else {
            if (!$user->save()) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward([
                    'controller' => 'users',
                    'action' => 'new'
                ]);
                return;
            }

            $this->flash->success("Your account was created successfully!");
            $this->dispatcher->forward([
                'controller' => 'users',
                'action' => 'index'
            ]);
            return;
        }
    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        };

        $id = $this->request->getPost("id");
        $user = Users::findFirst($id);

        if (!$user) {
            $this->flash->error("user does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

        $user->username = $this->request->getPost("username");
        $user->password = $this->request->getPost("password");
        $user->name = $this->request->getPost("name");
        $user->email = $this->request->getPost("email", "email");


        if (!$user->save()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => 'users',
                'action' => 'edit',
                'params' => [$user->id]
            ]);

            return;
        }

        $this->flash->success("Your account was updated successfully");

        $this->dispatcher->forward([
            'controller' => 'users',
            'action' => 'edit',
            'params' => [$user->id]
        ]);
    }

    /**
     * Deletes a user
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $user = Users::findFirst($id);
        if (!$user) {
            $this->flash->error("user was not found");

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("user was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "users",
            'action' => "index"
        ]);
    }
}