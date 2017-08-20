<?php

use Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Acl;

class Security extends Plugin {

    public function __construct($dependencyInjector) {
        $this->_dependencyInjector = $dependencyInjector;
    }

    public function getAcl() {
        if (!isset($this->persistent->acl)) {

            $acl = new Phalcon\Acl\Adapter\Memory();
            $acl->setDefaultAction(Phalcon\Acl::DENY);

            $roles = array(
                'users' => new Phalcon\Acl\Role('Users'),
                'guests' => new Phalcon\Acl\Role('Guests'),
                'admin' => new Phalcon\Acl\Role('Admin'),
            );

            foreach ($roles as $role) {
                $acl->addRole($role);
            }

            $private = array(
                'comments' => array('index', 'edit', 'delete','save'),
                'posts' => array('new', 'edit', 'save', 'create', 'delete'),
                'users' => array('search', 'new', 'edit', 'save', 'create', 'delete', 'logout')
            );
            foreach ($private as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            $public = array(
                'index' => array('index'),
                'posts' => array('index', 'search', 'show', 'comment'),
                'users' => array('login', 'index', 'new', 'create', 'save')
            );
            foreach ($public as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            foreach ($roles as $role) {
                foreach ($public as $resource => $actions) {
                    foreach ($actions as $action) {
                        $acl->allow($role->getName(), $resource, $action); }
                }
            }

            foreach ($private as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('Users', $resource, $action);
                    $acl->allow('Admin', $resource, $action);
                }
            }
            $this->persistent->acl = $acl;
        }
        return $this->persistent->acl;
    }

    public function beforeDispatch(Event $event, Dispatcher $dispatcher) {
        $user = $this->session->get('user_id');
        if (!$user) {
            $role = 'Guests';
            $this->session->set('user_role', $role);
        } else {
            $role = 'Users';
        }
        /**
       if ($this->session->has('user_id')){
           $role = $this->session->get('user_role');
       }
       else {
           $role = 'Guests';
       }**/
       $controller = $dispatcher->getControllerName();
       $action = $dispatcher->getActionName();
       $acl = $this->getAcl();
       $allowed = $acl->isAllowed($role, $controller, $action);

       if ($allowed != Acl::ALLOW) {
            $this->flash->error("You don't have access to this module");
            $dispatcher->forward(
                array(
                    'controller' => 'index',
                    'action' => 'index'
                )
            );
            return false;
        }
    }
}