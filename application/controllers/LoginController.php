<?php
class LoginController extends Zend_Controller_Action
{
    /**
     * Will generate current login info
     */
    public function userinfoAction()
    {
        $this->view->loggedIn = false;
    }
}