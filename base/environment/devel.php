<?php
/**
 * Description of devel
 *
 * @author Nemo.xiaolan
 * @created 2011-1-20 12:35:21
 */

class DevelEnvironment extends BaseEnvironment{

    public $config = array();

    public function __construct(array $config=Null) {
        
        

        parent::__construct($config);

        if($config) {
            $this->config = $config;
        } else {
            $this->config = BaseConfig::$config['runtime'];
        }

        $ebits = ini_get('error_reporting');
        error_reporting(E_ALL ^ E_NOTICE);
        
        if(function_exists('xdebug_break')
                && $this->config['xdebug']['enable'] != false) {
            
            ini_set('html_errors', 'On');

            ini_set('xdebug.auto_trace', 'On');
            ini_set('xdebug.show_exception_trace', 'Off');
            
            ini_set('xdebug.collect_vars', 'on');
            ini_set('xdebug.var_display_max_depth', '10');
            ini_set('xdebug.show_local_vars', 'Off');
            ini_set('xdebug.dump_globals', 'on');
            
            ini_set('xdebug.collect_params', '4');
            ini_set('xdebug.collect_assignments', 'On');
            ini_set('xdebug.collect_return', 'On');
            ini_set('xdebug.collect_return', 'On');
            ini_set('xdebug.collect_includes', 'On');
            
            ini_set('xdebug.profiler_append', 'On');
            ini_set('xdebug.trace_format', 'On');
            ini_set('xdebug.profiler_output_name', 'script');
            ini_set('xdebug.cli_color', 'On');

        } else {
            RuntimeConfig::set('runtime/xdebug/enable', false);
        }
        

    }

    public function set_cache() {
        
    }

}

?>
