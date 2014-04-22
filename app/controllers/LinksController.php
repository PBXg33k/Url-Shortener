<?php

use \Phalcon\Tag as Tag;

class LinksController extends ControllerBase
{

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "Links", $_POST);
            $this->session->conditions = $query->getConditions();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
            if ($numberPage <= 0) {
                $numberPage = 1;
            }
        }

        $parameters = array();
        if ($this->session->conditions) {
            $parameters["conditions"] = $this->session->conditions;
        }
        $parameters["order"] = "id";

        $links = Links::find($parameters);
        if (count($links) == 0) {
            $this->flash->notice("The search did not find any links");
            return $this->dispatcher->forward(array("controller" => "links", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $links,
            "limit"=> 10,
            "page" => $numberPage
            ));
        $page = $paginator->getPaginate();

        $this->view->setVar("page", $page);
    }


    public function editAction($id)
    {
        return true;
        $request = $this->request;
        if (!$request->isPost()) {

            $id = $this->filter->sanitize($id, array("int"));

            $links = Links::findFirst('id="'.$id.'"');
            if (!$links) {
                $this->flash->error("links was not found");
                return $this->dispatcher->forward(array("controller" => "links", "action" => "index"));
            }
            $this->view->setVar("id", $links->id);
            
            Tag::displayTo("id", $links->id);
            Tag::displayTo("token", $links->token);
            Tag::displayTo("longurl", $links->longurl);
            Tag::displayTo("visitor_count", $links->visitor_count);
        }
    }

    public function redirectAction() {
        $slug = $this->dispatcher->getParam("slug");
        $link = Links::findFirst('token="'.$slug.'"');

        // Check if $link has a password
        if( $link->password != null && ( !$this->request->isPost() || !$this->request->hasPost('password') ) ) {
            // $link has a password and user hasn't post anything yet, so let's show them a password prompt
            $this->view->setVar('slug', 'd'.$slug);
            $this->view->pick('index/password');
        } else {
            // Link has a password but user did post something
            if($this->request->isPost() && $this->request->hasPost('password')) {
                $password = sha1($this->request->getPost('password'));
                if($password != $link->password) {
                    $this->view->setVar('error', $this->translate->query('incorrect_password'));
                    $this->view->setVar('slug', 'd'.$slug);
                    $this->view->pick('index/password');
                    return;
                }
            }
            $check = Counts::findFirst(array('visitor_ip=:visitor_ip: AND links_id=:links_id:',
               'bind' => array('visitor_ip' => $this->getUserIP(), 
                   'links_id' => $link->id)
               ));
            if (!$check) {
                $counts = new Counts();
                $counts->links_id = $link->id;
                $counts->value = 1;
                $counts->visit_date = date("Y-m-d H:i:s");
                $counts->visitor_ip = $this->getUserIP();
                $counts->save();
                unset($counts);
                
                $counts_total = count(Counts::find(array("links_id" => $link->id)));
            }

            $link->visitor_count = $counts_total;
            $link->save();
            $this->view->linkurl = $link->longurl;

            $response = new \Phalcon\Http\Response();
            return $response->redirect($link->longurl, true);
        }
    }
    
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "index", "action" => "index"));
        }
        $check = Links::findFirst('longurl="'.$this->request->getPost("longurl").'"');
        if ($check) {
            $this->flash->success("links was already created");
            $this->view->token = $check->token;
            
            return $this->dispatcher->forward(array("controller" => "index", "action" => "index"));
        } else {
            $hash = md5($this->request->getPost("longurl").  microtime());
            $token = substr($hash, -7);

            $links = new Links();
            $links->token = $token;
            $links->longurl = trim($this->request->getPost("longurl"));

            // Check if user has checked the password checkbox
            if($this->request->hasPost('checkbox-password')) {
                $links->password = sha1($this->request->getPost("password"));
            }

            $links->visitor_count = 0;
            if (!$links->save()) {
                foreach ($links->getMessages() as $message) {
                    echo $message."<br />";
                    $this->flash->error((string) $message);
                } die;
                return $this->dispatcher->forward(array("controller" => "index", "action" => "index"));
            } else {
                $this->flash->success("links was created successfully");
                $this->view->token = $token;
                $this->view->tokenLink = 'd'.$token;
                return $this->dispatcher->forward(array("controller" => "index", "action" => "index"));
            }
        }
        

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "links", "action" => "index"));
        }

        $id = $this->request->getPost("id", "int");
        $links = Links::findFirst("id='$id'");
        if (!$links) {
            $this->flash->error("links does not exist ".$id);
            return $this->dispatcher->forward(array("controller" => "links", "action" => "index"));
        }
        $links->id = $this->request->getPost("id");
        $links->token = $this->request->getPost("token");
        $links->longurl = $this->request->getPost("longurl");
        $links->visitor_count = $this->request->getPost("visitor_count");
        if (!$links->save()) {
            foreach ($links->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "links", "action" => "edit", "params" => array($links->id)));
        } else {
            $this->flash->success("links was updated successfully");
            return $this->dispatcher->forward(array("controller" => "links", "action" => "index"));
        }

    }

    public function deleteAction($id){

        $id = $this->filter->sanitize($id, array("int"));

        $links = Links::findFirst('id="'.$id.'"');
        if (!$links) {
            $this->flash->error("links was not found");
            return $this->dispatcher->forward(array("controller" => "links", "action" => "index"));
        }

        if (!$links->delete()) {
            foreach ($links->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "links", "action" => "search"));
        } else {
            $this->flash->success("links was deleted");
            return $this->dispatcher->forward(array("controller" => "links", "action" => "index"));
        }
    }

}
