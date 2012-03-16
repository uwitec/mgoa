<?php
/**
 * Description of base
 *
 * @author Nemo.xiaolan
 * @created 2011-1-21 20:57:33
 */

class BaseUrlParser {

    static public $app, $action, $params;

    static public $url_patterns = array();

    static public $url_name_map = array();

    /*
     * BaseUrlParser::parse()
     */
    static public function parse() {

        $params = explode('/', $_SERVER['PATH_INFO']);
        @array_shift($params);

        $base_url = ini('base/BASE_URL');
        
        if(!$base_url) {
            $port = $_SERVER['SERVER_PORT'] == 80 ?
                                            '' : ':'.$_SERVER['SERVER_PORT'];
            $base_url = 'http://'.$_SERVER['SERVER_NAME'].$port.
                    str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
            BaseConfig::set('base/BASE_URL', $base_url);
        }
        

        /*
         * There isn't $_GET['to'] exists
         * call the base/DEFAULT_ACTION config set
         */
        if(count($params) < 1) {
            list($app, $action) = explode('/', ini('base/DEFAULT_ACTION'));
            $_params = array();
        /*
         * Only the app param exists, call the default named 'index'
         */
        } else if(count($params) == 1) {
            $app = $params[0];
            $action = 'index';
        /*
         * There is all app, action and params exists
         */
        } else {
            $app = array_shift($params);
            $action = array_shift($params);
        }

        self::$app = $app;
        self::$action = $action;
        self::$params = $params;
        
    }

    /*
     * BaseUrlParser::get_url()
     * @param string $action
     * @param array|string $params
     * @return string url
     *
     * get the url by action
     *
     * <code>
     *  BaseUrlParser::get_url('auth.login', 'id/1');
     * </code>
     */
    static public function get_url($action = null, $params=null) {

        /******************************************************/
        $action = $action ? $action : ini('base/DEFAULT_ACTION');
        if(!ini('base/USE_REWRITE')) {
            $script = 'index.php/';
        }
        $url = ini('base/BASE_URL').$script.$action.'/';

        //$url = ini('base/base_url').$action;
        /******************************************************/
        if(is_array($params) && $params) {
            foreach($params as $k=>$v) {
                $query_string .= $v.'/';
            }
            $url = $url.$query_string;
        } else if($params) {
            $url = $url.$params.'/';
        }

        return $url;
    }

    static public function get_url_by_name($name, $params = null) {
        if(!self::$url_name_map[$name]) {
            return false;
        }
        
        return self::get_url(self::$url_name_map[$name], $params);
    }

    /*
     * BaseUrlParser::dispatch()
     *
     * @param $app string
     * @param $view_action string 'index'
     * @param $params array null - Three params enough.
     *
     * @return void
     *
     * Dispatch the request to application
     */
    static public function dispatch($app, $view_action, array $params = null) {

        $view_action = $view_action ? $view_action : 'index';
        import('system/bin/application');
        import('system/bin/cache');

        /*
         * application's url pattern mapping
         */
        $app_map_array = YamlBackend::load('etc/conf.d/urls.yml');
        if($app_map_array['map'][$app]) {
            $app = $app_map_array['map'][$app];
        } else {
            if(array_keys($app_map_array['map'], $app)) {
                throw new DispatchException(1011, $app.'/'.$view_action);
            }
        }
        

        /*
         * Cache all INSTALLED APPS urls pattern
         */
        $cache_id = 'URLS_MAP';
        $url_name_map_cache_id = 'URL_NAME_MAP';
        $app_map_array_flip_cache_id = 'URL_APP_MAP_ARRAY_FLIP';
        
        $cache_instance = CacheBackend::get_instance();
        if($cache_instance->is_cached($cache_id) && RUN_MODE == 'deploy' && false) {
            self::$url_patterns = $cache_instance->get($cache_id);
            self::$url_name_map = $cache_instance->get($url_name_map_cache_id);
            $app_map_array_flip = $cache_instance->get($app_map_array_flip_cache_id);
        } else {
            $installed_apps = ini('base/INSTALLED_APPS');
            $app_map_array_flip = array_flip($app_map_array['map']);
            foreach($installed_apps as $installed_app) {
                $urlpattern = YamlBackend::load(
                           sprintf('applications/%s/urls.yml', $installed_app));

                if($app_map_array_flip[$installed_app]) {
                    $installed_app = $app_map_array_flip[$installed_app];
                }

                /*
                 * The url-name map to view action
                 * like: url name='auth_login' => auth.AuthController.login
                 */
                if($urlpattern) {
                    foreach($urlpattern as $key=>$value) {
                        if($value['name']) {
                            self::$url_name_map[$value['name']]
                                                      = $installed_app.'/'.$key;
                        }
                    }
                }

                self::$url_patterns[$installed_app] = $urlpattern;
            }
            
            $cache_instance->set($cache_id, self::$url_patterns);
            if(self::$url_name_map) {
                
                $cache_instance->set($url_name_map_cache_id, self::$url_name_map);
            }
            
            $cache_instance->set($app_map_array_flip_cache_id, $app_map_array_flip);
        }
        
        $app_map_name = array_key_exists($app, $app_map_array_flip) ?
                    $app_map_array_flip[$app] : $app;
        $urlpattern = self::$url_patterns[$app_map_name];


        try {
            /*
             * does not set the action key
             */
            if(!$urlpattern[$view_action]['action']) {
                $_c = ucfirst($app).'Controller';
                try {
                    import(Package::get_file(sprintf('applications/%s/%s', $app, $_c)));
                    $urlpattern[$view_action]['action'] = $_c.'.'.$view_action;
                } catch(DoesNotExistsException $e) {
                    throw new DispatchException(1011, $app.'/'.$view_action);
                }
                
            }
            list($controller, $method) = explode('.',
                    $urlpattern[$view_action]['action']);

            import(sprintf('applications/%s/%s', $app, $controller));


            if(!is_callable(array($controller, $method))) {
                throw new DispatchException(1011, $app.'/'.$view_action);
            }

            /*
             * Set current application and action
             */
            RuntimeConfig::set('runtime/application', $app);
            RuntimeConfig::set('runtime/action', $view_action);
            RuntimeConfig::set('runtime/view_action', $app.'/'.$view_action);

            BaseConfig::load_application_config($app);

            try {

                $controller = new $controller($params);
                
                RuntimeConfig::set('runtime/application_instance', $controller);
                /*
                 * Re-init the plugins with the application implements
                 */
                Pluggable::init($controller);
                /*
                 * Trigger the plugins in before_application_run
                 */
                Pluggable::trigger('before_application_run');

                /*
                 * Call the view-action method
                 */
                call_user_func_array(array($controller, $method), (array)$params);

            /*
             * Dependence exception
             */
            } catch(DependenceException $e) {
                //pass
            }

        /*
         * When the DispatchException catched
         * Return the 404
         */
        } catch(DispatchException $e) {
            $app = new BaseApplication();
            Pluggable::init($app);
            Pluggable::trigger('before_application_run');
            $app->load('smarty')->display('404');
        }
    }

}

?>
