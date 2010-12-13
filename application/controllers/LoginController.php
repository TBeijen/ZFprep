<?php
class LoginController extends Zend_Controller_Action
{
    /**
     * Will generate current login info
     */
    public function userinfoAction()
    {
        $tblUser = new User();

        $this->view->loggedIn = false;
    }
}