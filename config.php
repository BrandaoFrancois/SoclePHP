<?php
/*
 *
 * File regrouping all the configuration of the website
 *
 */

 // Assets
 define('ASSETS_DIR',			'./assets/');
 define('ASSETS_JS_DIR',		ASSETS_DIR.'js/');
 define('ASSETS_CSS_DIR',		ASSETS_DIR.'css/');
 define('ASSETS_IMG_DIR',		ASSETS_DIR.'img/');

 // Database (MariaDB)
 $_DB_INFO = array(
     'mysqlDb' => array('URL' => 'localhost', 'BASE' => 'database', 'USER' => 'user', 'PASSWORD' => 'password')
 );

define('SESSION_KEY_USERMANAGER',	'user');
define('DATABASE_USERMANAGER',		'mysqlDb');

 // Security
define('UPLOADMANAGER_MAX_FILE_SIZE',	60000); // Change this line
define('SECURITY_PEPPER',		''); // Change this line before deploying the website
define('SECURITY_RECOVERYKEY_TIME_MS',	3600000);
define('IS_ARGON2_AVAILABLE',		0);

 $_PHP_SECURITY = true;

 $_AUTHORISED_PAGES = array();
?>
