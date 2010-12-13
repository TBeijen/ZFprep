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
        $this->_initDb();
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

    /**
     * Initialize layout
     */
    protected function _initLayout()
    {
        Zend_Layout::startMvc();
        $layout = Zend_Layout::getMvcInstance();
        $layout->setLayoutPath(APP_ROOT . '/application/layouts/scripts');
    }

    /**
     * Connect to db
     */
    protected function _initDb()
    {
        $db = Zend_Db::factory(Zend_Registry::get('config')->database);
        // force connection
        $conn = $db->getConnection();
        Zend_Db_Table::setDefaultAdapter($db);

        // setup db cache
        $frontendOptions = array('automatic_serialization' => true);
        $backendOptions = array('cache_dir' => Zend_Registry::get('config')->paths->cache->db);
        $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);

        Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
    }
}