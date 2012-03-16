<?php
/**
 * Description of mongo
 *
 * @author Nemo.xiaolan
 * @created 2011-3-29 14:07:44
 */

interface MongoInterface {

    static public function setup($dbinfo);

}

class MongoBackend{
    
    static public $collection;

    static public $instance;

    static public function get_instance($dbinfo) {
        if(self::$instance instanceof Mongo) {
            return self::$instance;
        }

        self::$instance = new Mongo($dbinfo['host'].':'.$dbinfo['port']);
        self::$instance->$dbinfo['name'];

        return self::$instance;
    }
}



?>
