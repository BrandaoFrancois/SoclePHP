<?php
/*
 *
 * Database component
 *
 */

class Db {
    private static $adapters = array();

    public static function getAdapter($dbConfigName) {
        if (!array_key_exists($dbConfigName, $_DB_INFO)) {
            die ('Error: Unknown database configuration asked !');
        }
        
        if (array_key_exists($dbConfigName, self::$adapters)) {
            $config = $_DB_INFO[$dbConfigName];
            try {
                self::$adapters[$dbConfigName] = new PDO('mysql:host='.$config['URL']
                    .';dbname='.$config['BASE'].';charset=utf8', $config['USER'], $config['PASSWORD']);
            } catch (Exception $e) {
                die ('Error: '.$e->getMessage());
            }
        }
        return self::$adapters[$dbConfigName];
    }
}
?>
