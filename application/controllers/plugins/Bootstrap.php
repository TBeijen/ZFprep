<?php
class My_Controller_Front_Plugin_Bootstrap extends Zend_Controller_Plugin_Abstract
{
    /**
     * Bootstrap plugin
     * @param Zend_Controller_Request_Abstract $request
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->_loadConfig();
        $this->_initLayout();
    }

    /**
     * Loads config with proper section and stores in registry
     * @todo make file cache
     */
    protected function _loadConfig()
    {
        $configLoc = APP_ROOT . '/application/configs/application.ini';
        $config = new Zend_Config_Ini($configLoc, APP_ENVIRONMENT);
        Zend_Registry::set('config', $config);
    }

    protected function _initLayout()
    {
        Zend_Layout::startMvc();
        $layout = Zend_Layout::getMvcInstance();
        $layout->setLayoutPath(APP_ROOT . '/application/layouts/scripts');
    }
}