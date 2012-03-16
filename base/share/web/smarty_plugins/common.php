<?php
/*
 * File: common.php
 * 
 * Encoding: UTF-8
 * Created on: Feb 13, 2011 8:44:26 PM
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
 * smarty function
 * @param string $action
 * @param array|string  $params
 * @usage:
 * <code>
 *  {%url action='auth.index' params=$array%}
 * </code>
 */
function smarty_function_url($params, $smarty) {
    if($params['name']) {
        return BaseUrlParser::get_url_by_name($params['name']);
    } else {
        return BaseUrlParser::get_url($params['action'], $params['params']);
    }
    
}

/*
 * smarty function
 * @param $param
 * @param $smarty
 * 
 * Dynamic load plugins or smarty plugins
 */
function smarty_function_load_dynamic_plugins($params, $smarty) {
    if(array_key_exists('plugin', $params)) {
        list($app, $plugin) = explode('.', $params['plugin']);
        Pluggable::load_plugins($app, $plugin);
    } else if(array_key_exists('smarty_function', $params)) {
        $this->registerPlugin('function', $params['smarty_function'],
                                    'smarty_function_'.$params['function_name']);
    }
    
}


    

?>
