<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        if (!$this->view->token) {
            $this->view->token = "";
        }
        if(!$this->view->tokenLink) {
        	$this->view->tokenLink = "";
        }
        
    }

}

