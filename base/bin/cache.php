<?php
/**
 * Description of cache
 *
 * @author Nemo.xiaolan
 * @created 2011-1-21 16:43:41
*/

class CacheBackend {

    protected $error_message;

    static public $config = array(
        'use'=> 'xcache',
        'life'=> 3600,
        'cache_dir'=> 'tmp/runtime_cache'
    );

    static public $use;

    static private $object_instance;

    static public function is_available($cache_backend_name) {
        switch($cache_backend_name) {
            case 'xcache':
                return function_exists('xcache_set');
            case 'file':
                return is_dir(Package::get_folder(self::$config['cache_dir']))
                && is_writeable(Package::get_folder(self::$config['cache_dir']));
            case 'memcache':
                return class_exists('Memcached');
        }
        return false;
    }

    /*
     * CacheBackend::get_instance()
     *
     * @param array $config
     * @access public
     * @return object - Cache Instance
     *
     * Get the cache instance
     * <code>
     *  CacheBackend::get_instance()
     * </code>
     * 
     */
    static public function get_instance(array $config = null) {

        if(self::$object_instance instanceof CacheInterface) {
            return self::$object_instance;
        }

        if($config) {
            foreach($config as $key=>$value) {
                self::$config[$key] = $value;
            }
        }

        self::$config['use'] = self::$config['use'] ? self::$config['use']
                                                    : ini('base/CACHE_BACKEND');
        if(!self::$config['use'] || !self::is_available(self::$config['use'])) {
            self::$config['use'] = 'file';
        }

        if(is_object(self::$object_instance)
                && self::$object_instance instanceof $cache_instance_class) {
            return self::$object_instance;
        }

        $ini_config = ini('runtime/cache');
        if($ini_config) {
            foreach($ini_config as $key=>$value) {
                $this->config[$key] = $value;
            }
        }
        if($config) {
            foreach($config as $key=>$value) {
                self::$config[$key] = $value;
            }
        }

        import('system/share/cache/interface');
        import('system/share/cache/'.strtolower(self::$config['use']));
        $cache_instance_class = ucfirst(self::$config['use']);
        try {
            self::$object_instance = new $cache_instance_class();
            if(method_exists(self::$object_instance, 'check_available')) {
                $code = self::$object_instance->check_available();

                if($code !== true) {
                    import('system/share/exception/CacheException');
                    throw new CacheException((int)$code,
                            self::$object_instance->error_message);
                }
            }
        } catch(CacheException $e) {
            if(RUN_MODE == 'devel') {
                throw new CacheException(1006, self::$config['use']);
            } else {
                self::$object_instance = new File();
            }
        }
        return self::$object_instance;

    }

}
?>
