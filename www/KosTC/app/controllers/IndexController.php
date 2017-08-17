<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

class IndexController extends ControllerBase
{

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

}

