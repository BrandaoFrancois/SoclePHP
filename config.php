<?php
/*
 *
 * File regrouping all the configuration of the website
 *
 */

 // Assets
 define('ASSETS_DIR',       './assets/');
 define('ASSETS_JS_DIR',     ASSETS_DIR.'js/');
 define('ASSETS_CSS_DIR',    ASSETS_DIR.'css/');
 define('ASSETS_IMG_DIR',    ASSETS_DIR.'img/');


 // Database (MariaDB)
 $_DB_INFO = array(
     'mysqlDb' => array('URL' => 'localhost', 'BASE' => 'database', 'USER' => 'user', 'PASSWORD' => 'password')
 );

 // Security
 $_PHP_SECURITY = true;

 $_AUTHORISED_PAGES = array();
?>
