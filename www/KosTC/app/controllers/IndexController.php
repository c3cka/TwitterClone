<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $numberPage = $this->request->getQuery("page", "int", 1);
        $params['order'] = 'published DESC';
        $posts = Posts::find($params);
        $paginator = new Paginator(array(
            "data" => $posts,
            "limit"=> 10,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
    }

    public function destroySessionAction()
    {
        return $this->session->destroy();
    }

}

