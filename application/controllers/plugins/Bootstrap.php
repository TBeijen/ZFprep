<?php
class My_Controller_Front_Plugin_Bootstrap extends Zend_Controller_Plugin_Abstract
{
    /**
     * Bootstrap plugin
     * @param Zend_Controller_Request_Abstract $request
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->_initLayout();
    }

    protected function _initLayout()
    {
        Zend_Layout::startMvc();
        $layout = Zend_Layout::getMvcInstance();
        $layout->setLayoutPath(APP_ROOT . '/application/layouts/scripts');
    }
}