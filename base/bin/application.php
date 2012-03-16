<?php
/**
 * Description of application
 *
 * @author Nemo.xiaolan
 * @created 2011-1-20 13:16:48
 */

class BaseApplication {
    
    protected $smarty_instance = null;

    protected $cache_instance = null;

    protected $params;

    static public $instance;

    static public $current_application;

    public function __get($property) {
        $method_name = sprintf('__load__%s__', $property);
        if(method_exists($this, $method_name)) {
            return $this->$method_name();
        }
    }

    public function __call($method, $args_array) {
        $method_name = sprintf('__load__%s__', $method);
        if(method_exists($this, $method_name)) {
            return call_user_func_array(array($this, $method_name), $args_array);
        }
    }

    /*
     * BaseApplication::__construct();
     */
    public function __construct($params = null) {
        self::$instance = $this;
        self::$current_application = ini('runtime/application');
        self::_check_dependence(self::$current_application);
        
        Pluggable::trigger('after_application_construct');

        /*
         * 基础是否登录权限判断
         */
        if(ini('runtime/application') != 'system/contrib/auth' && 
           ini('runtime/action') != 'login'
           && ini('runtime/application' != 'system/contrib/dev_tools')) {
            import('system/contrib/auth/plugins');
            AuthPlugins::login_required($this);
        }
    }

    /*
     * BaseApplication::load()
     *
     * @param $package_name String
     * @param $config array
     * @return object of some instance
     *
     * <code>
     *  $smarty = BaseApplication::load('smarty', array('debug'=> false))
     *
     *  $smarty->assign('key', $value);
     *  $smarty->display('index.tpl');
     * </code>
     */
    public final function load() {
        $_params = func_get_args();
        $method_name = sprintf('__load__%s__', array_shift($_params));
        if(!method_exists($this, $method_name)) {
            throw new DoesNotExistsException(1007, $method_name);
        }
		
        return call_user_func_array(array($this, $method_name), $_params);
    }

    /*
     * BaseApplication::is_post()
     * @param boolean $include_data |
     * @return boolean
     */
    public final function is_post($include_data = true) {
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            return false;
        }
        
        if($include_data) {
            return $_POST ? true : false;
        }
        return true;
    }

    /*
     * BaseApplication::__load__smarty__()
     *
     * @access private
     * @param $config array
     * @param $new boolean
     * @return object Smarty Instance
     */
    protected function __load__smarty__(array $config = null, $new = false) {
        if($this->smarty_instance instanceof TemplateBackend && !$new) {
            return $this->smarty_instance;
        }

        import('system/bin/smarty');
        
        $this->smarty_instance = new TemplateBackend();
        $this->smarty_instance->assign_public_tpl_vars();

        if($config) {
            foreach($config as $key=>$value) {
                $this->smarty_instance->$key = $value;
            }
        }
        
        return $this->smarty_instance;
        
    }

    /*
     * BaseApplication::__load__cache__()
     *  see: CacheBackend::get_instance();
     *
     * @param $config array
     * @return object CacheBackend Instance
     */
    protected function __load__cache__(array $config = null, $new = false) {
        if(is_object($this->cache_instance) && !$new) {
            return $this->cache_instance;
        }
        import('system/bin/cache');
        $this->cache_instance = CacheBackend::get_instance($config);
        return $this->cache_instance;
    }

    /*
     * BaseApplication::__load__model__()
     *
     * @param $config array
     * @return void
     *
     * <code>
     *  Parent::get('model', array('model'=>'user'));
     * </code>
     */
    protected function __load__model__($model, $init_connect = true, $dsn = null) {
        import('system/bin/doctrine');
        $tmp = explode('.', $model);

        DatabaseBackend::init($dsn, $init_connect);
        DatabaseBackend::load_model($tmp[0], $tmp[1]);
    }

    protected function __load__mongo_model__($model) {
        import('system/bin/mongo');
        
        list($model_path, $model_name) = explode('.', $model);
        import('applications/'.$model_path.'/mongo_models/'.$model_name);

        BaseConfig::load(Package::get_file('etc/conf.d/database.yml'));
        $dbinfo = ini('database/mongo_'.RUN_MODE);
        call_user_func(array($model_name, 'setup'), $dbinfo);
//        $model_name::setup($dbinfo);

    }

    /*
     * BaseApplication::__load__form__()
     *
     * @param $config array
     * @return object. form instance
     */
    protected function __load__form__($form, $data = null, $application = null) {
    	
        if(!$application) {
            $application = ini('runtime/application');
        }

        import('system/share/web/forms/forms');
        import(sprintf('applications/%s/forms/%s', $application, $form));
        $form_instance = new $form($form, $application, $data);

        /*
         * Register the smarty plugins for form if the smarty instance exists.
         */
        import('system/share/web/smarty_plugins/forms');
        if(!$this->smarty_instance instanceof Smarty) {
            $this->smarty_instance = $this->load('smarty');
        }

        $this->smarty_instance->registerPlugin('modifier', 'as_table',
                                            'smarty_modifier_as_table');
        $this->smarty_instance->registerPlugin('modifier', 'as_p',
                                        'smarty_modifier_as_p');
        $this->smarty_instance->registerPlugin('modifier', 'as_ul',
                                        'smarty_modifier_as_ul');
        $this->smarty_instance->registerPlugin('modifier', 'as_div',
                                        'smarty_modifier_as_div');
        $this->smarty_instance->registerPlugin('function', 'csrf_protected',
                                        'smarty_function_csrf_protected');

        if(method_exists($form_instance, 'set_up')) {
            $form_instance->set_up($this->smarty_instance);
        }
        
        return $form_instance;
    }

    protected function __load__session__() {
        import('system/share/http/session');
        Session::start();
    }



    /*
     * BaseApplication::check_dependence();
     * @param string $application
     * @return void|boolean
     *
     */
    static final public function _check_dependence($application) {
        $dependences = ini('runtime/application_config/'.$application.'/dependent');
        if(!$dependences) {
            return true;
        }
        $installed_apps = ini('base/INSTALLED_APPS');
        foreach((array)$dependences['application'] as $depend) {
            if(!in_array($depend, (array)$installed_apps)) {
                throw new DependenceException(1012, $application.' depend '.$depend);
            }
        }
    }

    /*
     * BaseApplication::raise();
     * @param string $code
     */
    static final public function raise($code, $message = null) {
        import('system/share/network/http');
        $func_name = 'E_'.$code;
        HTTP::$func_name($message);
        Boot::shutdown();
    }

    public function alert($msg, $to = null) {
        header('content:text/html; charset=utf-8');
        if(!$to) {
            $to = 'window.history.go(-1);';
        } else {
            $to = 'window.location.href="'.$to.'"';
        }
        $msg = addslashes($msg);
        echo <<<EOF
            <html>
            <head>
            <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
            <script type="text/javascript">
                alert('{$msg}');
                {$to}
            </script>
            </head>
            <body></body>
            </html>
EOF;
        Boot::shutdown();
    }

}


?>
