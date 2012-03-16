<?php
/**
 * Description of EmptyPHP
 *
 * @author Nemo.xiaolan
 * @created 2011-1-21 13:42:05
 */

class DeployEnvironment extends BaseEnvironment{
    
    public function __construct(array $config = null) {

        parent::__construct($config);

        if($config) {
            $this->config = $config;
        } else {
            $this->config = BaseConfig::$config['runtime'];
        }

        /*
         * Set the custom exception handler
         */
        set_exception_handler(array('BaseException', 'handler'));

        error_reporting(0);
        ini_set('display_errors', 'Off');
        if(ini_get('xdebug.auto_trace')) {
            ini_set('xdebug.auto_trace', 'Off');
            ini_set('xdebug.collect_params', 'Off');
            ini_set('xdebug.collect_return', 'Off');
            ini_set('xdebug.profiler_enable', 'Off');
            ini_set('xdebug.show_local_vars', 'Off');
            ini_set('xdebug.collect_vars', 'Off');
            ini_set('xdebug.collect_return', 'Off');
            ini_set('xdebug.collect_params', 'Off');
            ini_set('xdebug.collect_includes', 'Off');
            ini_set('xdebug.var_display_max_depth', 'Off');
            ini_set('xdebug.dump_globals', 'Off');
        }
        

    }

    public function set_cache() { }

}


?>
