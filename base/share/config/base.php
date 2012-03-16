<?php
/**
 * Description of base_config
 *
 * @author Nemo.xiaolan
 * @created 2011-1-21 15:15:33
 */

class BaseConfig{

    static public $config = array(
        'base' => array(),
        'runtime' => array()
    );

    static protected $inited = false;

    /*
     * BaseConfig::init();
     *
     * Initalize the base config in common.yml.php
     */
    static public function init() {
        if(self::$inited == true) {
            return true;
        }
        import('system/bin/yaml');
        import('system/bin/cache');
        $cache_instance = CacheBackend::get_instance(array('use'=>'xcache'));
        $cache_id = '__BASE__CONFIG__';
        if($cache_instance->is_cached($cache_id) && RUN_MODE == 'deploy') {
            self::$config['base'] = $cache_instance->get($cache_id);
        } else {
            self::$config['base'] = YamlBackend::load('etc/common.yml', false);
            $cache_instance->set($cache_id, self::$config['base']);
        }
        
        
        self::$inited = true;
    }

    /*
     * BaseConfig::load()
     *
     * @param $yml_path String
     * @return void
     */
    static public function load($yml_path, $key = null) {
        self::init();
        try{
            $tmp = explode(DS, $yml_path);
            if(!$key) {
                $key = array_shift(explode('.', end($tmp)));
            }
            self::$config[$key] = YamlBackend::load($yml_path);
        } catch (Exception $e){
            return;
        }
    }

    /*
     * BaseConfig::load_application_config()
     * @param $app string
     */
    static public function load_application_config($app) {
        $yml_path = Package::get_file(sprintf('applications/%s/config.yml', $app));
        self::load($yml_path, $app.'_config');
    }

    /*
     * BaseConfig::get()
     * @param $path String
     * @return mixed
     * <code>
     *  BaseConfig::get('base/site/url');
     * </code>
     */
    static public function get($path = null) {
        if(!$path) {
            return self::$config;
        }
        
        $paths = explode('/', $path);
        $ini = self::$config;
        foreach($paths as $value) {
            $ini = $ini[$value];
        }
        return $ini;
    }

    /*
     * BaseConfig::set()
     *
     * @param $path String
     * @param $data Mixed
     * @return void
     *
     * eg:
     * <code>
     *     BaseConfig::set('base/site/title', 'Page title');
     * </code>
     *
     * like the array(
     *  'application' => array(
     *                      'site' => array(
     *                          'title' => 'Page title'
     *                      ),
     *                  ),
     * );
     */
    static public function set($path, $data = null) {
        
        if(!is_array($data)) {
            if(strpos($path, "/") === false) {
                self::$config[$path] = $data;
                return;
            }

            $paths = explode("/", $path);
            $length = count($paths);
            $position =& self::$config;

            for($i=0;$i<$length;$i++) {
                $current = $paths[$i];
                if($i == $length-1) {
                    $position[$current] = $data;
                } else {
                    if(!isset($position[$current])) {
                        $position[$current] = array();
                    }
                    $position =& $position[$current];
                }
            }

        } else {
            foreach($data as $k => $v) {
                self::set($path.'/'.$k, $v);
            }
        }
    }
    
    static public function get_apps_config($apps) {
    	
		foreach($apps as $app) {    	
    		$file = Package::get_file(sprintf(
                    'applications/%s/config.yml', $app));
            if(!is_file($file)) {
                continue;
            }
            /*
             * get the applications's config
             */
            $app_config = self::$config['apps_configs'][$app];
            if(!$app_config) {
                $app_config = YamlBackend::load($file);
                self::$config['apps_configs'][$app] = $app_config;
            }
		}
		
		return self::$config['apps_configs'];
		
    }

}


?>