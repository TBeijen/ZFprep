<?php
set_include_path(get_include_path() . PATH_SEPARATOR .
    '/www/shared/ZF/1.5.3/library/Zend'
);

require_once('Zend/Locale.php');

$locale = new Zend_Locale();

var_dump($locale);
