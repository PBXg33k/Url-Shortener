<?php

/**
 * IndexController
 * 
 * @author Oguzhan Uysal <development.php@oguzhanuysal.eu>
 * @package default
 * @uses ControllerBase
 * 
 * @version 1.0.0
 */
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

