<?php
/*
*
* The main file of the project.
* Where everything start...
*
*/

// Imports
require_once './config.php';

// Models
require_once './src/models/Users.class.php';

// Managers
require_once './src/Db.class.php';
require_once './src/UserManager.class.php';

// Start session
session_start();

UserManager::init();

// Loading page
echo 'Everything is OK !';


?>
