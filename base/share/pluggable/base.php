<?php
/**
 * Description of base
 *
 * @author Nemo.xiaolan
 * @created 2011-2-22 15:10:48
 */

class Pluggable {

    static public $hooks = array();

    static public $application = null;

    static public $plugins = array();

    static public $inited = false;

    static public function init(BaseApplication $application) {
    	self::$inited = true;
    	
        if($application) {
            self::$application = $application;
        }
        
        self::load_plugins();
        
    }

    

    /*
     * Pluggable::init()
     * @param $application object | instanse of BaseApplication
     * @return void
     *
     * initalize the pluggins
     *
     */
    static public function load_plugins($_application = null, $_plugin_name = null, $_position = null) {

        /*
         * the global plugins
         */
        $plugins = YamlBackend::load('etc/conf.d/plugins.yml');
        if($plugins) {
            foreach((array)$plugins as $hook_name=> $plugin) {
                if(!$plugin) {
                    continue;
                }
                foreach((array)$plugin as $plugin_name=>$plugin_action) {
                    self::register($hook_name,$plugin_name, $plugin_action);
                }
            }
        }

        /*
         * load the single application's plugins
         */
        if($_application) {
            $installed_apps = array($_application);
        } else {
            $installed_apps = ini('base/INSTALLED_APPS');
        }
        
        $installed_apps_config = BaseConfig::get_apps_config($installed_apps);
        
        foreach((array)$installed_apps_config as $app_config) {
            
            foreach((array)$app_config['plugins'] as $hook_name=> $ps) {
                if(!$ps) {
                    continue;
                }
                
                /*
                 * load the decided plugin
                 */
                if($_plugin_name && $ps[$_plugin_name]) {
                    self::register($hook_name, $_plugin_name, $ps[$_plugin_name]);
                    return;
                }
                foreach((array)$ps as $name=> $plugin) {
                    self::register($hook_name, $name, $plugin);
                }
            }
            
        }
        
    }

    /*
     * Pluggable::register()
     *
     * <code>
     *  Pluggable::register('before_display', 'auth/middleware.AuthMiddleware::method');
     * </code>
     */
    static public function register() {
        list($hook_name, $name, $info) = func_get_args();
        list($pluggable_file, $object) = explode('.', $info);
        list($class, $method) = explode('::', $object);
        $file = $pluggable_file ? $pluggable_file : 'applications/'.$pluggable_file;
        $plugin_info = array(
            'class' => $class,
            'method'=> $method,
            'file'  => $file
        );

        if(!in_array($plugin_info, (array)self::$hooks[$hook_name])) {
            self::$hooks[$hook_name][] = $plugin_info;
        }
        
        
        if($name) {
            self::$plugins[$name] = $info;
        } else {
            array_push(self::$plugins, $info);
        }
        
        

    }

    /*
     * Pluggable::trigger();
     *
     * @params $hook_name string
     * @return void
     *
     * trigger the hook
     */
    static public function trigger() {
    	
    	if(!self::$inited and ini('runtime/application_instance') instanceof BaseApplication) {
    		self::init(ini('runtime/application_instance'));
    	}
    	
        list($hook_name, $params) = func_get_args();
        
        $params = (array)$params;
        if(!$hook_name || !key_exists($hook_name, self::$hooks)) {
            return false;
        }
        
        if($hook_name == 'before_template_render') {
            
        }
        
        
        foreach((array)self::$hooks[$hook_name] as $k=>$v) {
            if(!is_callable(array($v['class'], $v['method']))) {
                $file = Package::get_file($v['file']);
                if(!is_file($file)) {
                    continue;
                }
                import($file);
            }
            
            array_unshift($params, self::$application);
            
            if(is_callable(array($v['class'], $v['method']))) {
                $result = call_user_func_array(
                    array($v['class'], $v['method']), $params
                );

                /*
                 * Call the callback function
                 */
                if($params['callback']) {
                    $result = call_user_func_array($params['callback'], (array)$result);
                }

            }

        }
    }

}

?>
