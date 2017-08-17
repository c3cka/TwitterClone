<?php

use Phalcon\Mvc\Dispatcher,
    Phalcon\Events\Event,
    Phalcon\Acl;

class Permission extends \Phalcon\Mvc\User\Plugin
{

    protected $_publicResources = [
        'index' => '*',
        'signin' => '*'
    ];

    protected $_userResources = [
        'dashboard' => ['*']
    ];

    protected $_adminResources = [
        'admin' => ['*']
    ];


    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Get the current role
        $role = $this->session->get('role');
        if (!$role) {
            $role = 'guest';
        }

        // Get the current Controller/Action from the Dispatcher
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        // Get the ACL Rule List
        $acl = $this->_getAcl();

        // See if they have permission
        $allowed = $acl->isAllowed($role, $controller, $action);

        if ($allowed != Acl::ALLOW) {
            $this->flash->error("You do not have permission to access this area!");
            $this->response->redirect('index');
            // Stop the dispatcher at the current operation
            return false;
        }
    }

    protected function _getAcl()
    {
        if (!isset($this->persistent->acl)) {
            $acl = new Acl\Adapter\Memory();
            $acl->setDefaultAction(Acl::DENY);

            $roles = [
                'guest' => new Acl\Role('guest'),
                'user' => new Acl\Role('user'),
                'admin' => new Acl\Role('admin'),
            ];

            foreach ($roles as $role) {
                $acl->addRole($role);
            }

            // Public Resources
            foreach ($this->_publicResources as $resource => $action) {
                $acl->addResource(new Acl\Resource($resource), $action);
            }

            // User Resources
            foreach ($this->_userResources as $resource => $action) {
                $acl->addResource(new Acl\Resource($resource), $action);
            }

            // Admin Resources
            foreach ($this->_adminResources as $resource => $action) {
                $acl->addResource(new Acl\Resource($resource), $action);
            }

            // Allow All Roles to access the Public Resources
            foreach ($roles as $role) {
                foreach ($this->_publicResources as $resource => $action) {
                    $acl->allow($role->getName(), $resource, '*');
                }
            }

            // Allow User & Admin to access the User Resources
            foreach ($this->_userResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('user', $resource, $action);
                    $acl->allow('admin', $resource, $action);
                }
            }

            // Allow Admin to access the Admin Resources
            foreach ($this->_adminResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('admin', $resource, $action);
                }
            }

            $this->persistent->acl = $acl;
        }

        return $this->persistent->acl;
    }
}