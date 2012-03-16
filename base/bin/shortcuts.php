<?php
/**
 * Description of shortcuts
 *
 * @author Nemo.xiaolan
 * @created 2011-1-22 14:47:55
 */

if(!function_exists('import')) {
    require FM_DIR.DS.'share'.DS.'package.php';
    function import($path, $ext='php') {
        return Package::import($path, $ext);
    }
}

if(!function_exists('ini')) {
    function ini($path = null) {
        return BaseConfig::get($path);
    }
}

if(!function_exists('url_reverse')) {
    function url_reverse($name) {
        return BaseUrlParser::$url_name_map[$name];
    }
}

function __autoload($classname) {

    $paths = array(
        'system/bin/',
        'system/share/',
        'system/share/exception/',
    );

    $models_path = 'system/models';
    foreach ($paths as $path){
        try {
            $re = import($path.$classname);
        } catch (DoesNotExistsException $e){
            try {
                $re = import($path.$classname.'/'.$classname);
            } catch (DoesNotExistsException $e1) {
                continue;
            }
        }
    }
}


?>
