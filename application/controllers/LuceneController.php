<?php
class LuceneController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->view->assign('title', 'Lucene');
    }

}