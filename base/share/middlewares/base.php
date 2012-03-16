<?php
/*
 * File: base.php
 * 
 * Encoding: UTF-8
 * Created on: Feb 20, 2011 12:31:21 PM
 *
 * @author: xiaolan
 *
 * License:
 *
 * 
 * 
 *
 * Description:
 *  Change this.
 *
 */

/*
 * The BaseMiddlewareInterface
 */
interface BaseMiddlewareInterface {

    static public function init($base_app);

}

abstract class BaseMiddlewareAbstract {

    static abstract public function before();

    static abstract public function after();
    
}

class BaseMiddleware extends BaseMiddlewareAbstract
                     implements BaseMiddlewareInterface {

    static public function init($base_app) {}

    static public function before() {}

    static public function after() {}

}
    

?>
