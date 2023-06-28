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
 define('DB_URL', 'localhost');
 define('DB_BASE', 'database');
 define('DB_USER', 'user');
 define('DB_PASSWORD', 'password');

 // Security
 $_PHP_SECURITY = true;

 $_AUTHORISED_PAGES = array();

?>
