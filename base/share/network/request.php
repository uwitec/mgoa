<?php
/**
 * Description of request
 *
 * @author Nemo.xiaolan
 * @created 2011-2-13 12:38:43
 */

class Request {

    static public $get, $post, $cookie, $file;
    
    static public $method = 'GET';

    /*
     * Request::init()
     * 
     * */
    static public function init() {
        if(ini_get('magic_quotes_gpc')){
            self::$get    = $_GET;
            self::$post   = $_POST;
        } else {
            self::$get    = $_GET = self::addSlashes($_GET);
            self::$post   = $_POST = self::addSlashes($_POST);
        }
        self::$cookie = $_COOKIE;
        self::$file   = $_FILES;
        
        self::$method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @ stripslashes()
     * @param data $data
     * @return string $data
     * addSlashes adverse function
     * */
    static public function stripslashes($data) {
        if (is_array($data)) {
              foreach ($data as $key => $value) {
                $data[$key] = self::stripSlashes($value);
              }
        } else {
              $data = stripSlashes(trim($data));
        }

        return $data;
    }

    /**
     *
     * @ addslashes()
     * @param data $data
     * @return string $data
     * use '\' to transferred meaning
     * */
    static public function addslashes($data) {
        if (is_array($data)) {
              foreach ($data as $key => $value) {
                $data[$key] = self::addSlashes($value);
              }
        } else {
              $data = addSlashes(trim($data));
        }
        return $data;
    }
}


?>
