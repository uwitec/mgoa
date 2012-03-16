<?php
/**
 * Description of ${name}
 *
 * @author Nemo.xiaolan
 * @created ${date} ${time}
 *
 *
 *
 *
 *
 * !!!!!!################# CSRF_TOKEN 有问题 SESSION不同步 或者再次生成
 */

class CSRF {
    
    static public $csrf_token = false;

    static public $valid = false;

    static public $name = 'CSRF_TOKEN';
    
    static public function generate($name = null) {
        import('system/share/network/session');
        $name = $name ? $name : self::$name;
        Session::start();
        $_SESSION[$name] = self::$csrf_token = md5(uniqid(rand(), true));
        return $_SESSION[$name];
    }
    
    /*
     * CSRF::check();
     * @return Integer
     *   -1: there's not CSRF_TOKEN seted
     *   1 : success
     *   0 : not match, or somthing wrong
     */
    static public function check($csrf_token = null) {

        if(self::$valid === true) {
            return 1;
        }

        if(!$csrf_token) {
            $csrf_token = $_POST[self::$name];
        }
        
        import('system/share/network/session');
        Session::start();

        unset($_SESSION[self::$name]);
        
        if(!self::$csrf_token) {
            $state = -1;
        } else if(self::$csrf_token == $csrf_token || !$csrf_token) {
            $state = 1;
        } else {
            $state = 0;
        }
        return $state;
    }

    /*
     * CSRF::auth_check()
     * The auto-check CSRF Token plugin.
     */
    static public function auto_check($base_app) {
        if('POST' == !$_SERVER['REQUEST_METHOD']  || !isset($_POST[self::$name])) {
            return true;
        }

        if(self::check() < 1) {
            self::deny($base_app);
        }

        self::$valid = true;
    }

    static public function deny($base_app) {
        header('HTTP/1.1 403 Forbidden');
        $smarty = $base_app->load('smarty');
        $smarty->assign('page_title', 'Error - HTTP 403 Forbidden');
        $smarty->assign('message_title', 'Your request has been expired');
        $smarty->assign('message', 'Please do not report a duplicate data or refresh the page.');
        $smarty->display('403');
        Boot::shutdown();
    }
    
}


?>
