<?php
/*
 * File: yaml.php
 * 
 * Encoding: UTF-8
 * Created on: Feb 24, 2011 9:59:10 PM
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

class YamlBackend {
    
    /*
     * YamlBackend::load()
     * @param $file string
     * @param $cache int 3600
     */
    static public function load($file, $cache = 3600) {
        
        if($cache > 0  && RUN_MODE == 'deploy') {
            import('system/bin/cache');
            $cache_instance = CacheBackend::get_instance();
            $cache_id = 'yaml_'.str_replace(array('/', '.'), '_', $file);
            if($cache_instance->is_cached($cache_id)) {
                return $cache_instance->get($cache_id);
            } else {
                if(!is_file($file)) {
                    $file = Package::get_file($file);
                    if(!is_file($file)) {
                        return array();
                    }
                }
                
                import('system/vendors/spyc/spyc');
                $info = spyc_load_file($file);
                $cache_instance->set($cache_id, $info);
                return $info;
            }
        }

        if(!is_file($file)) {
            $file = Package::get_file($file);
            if(!is_file($file)) {
                return array();
            }
        }
        
        import('system/vendors/spyc/spyc');
        $info = spyc_load_file($file);
        return $info;
        
    }

}

    

?>
