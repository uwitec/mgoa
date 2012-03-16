<?php
/**
 * Description of boot
 *
 * @author Nemo.xiaolan
 * @created 2011-1-19 19:04:56
 */

class Boot{

    /*
     * Boot::poweron()
     * Initalize the system
     */
    static public function poweron() {

        if(function_exists('ob_gzhandler')) {
            ob_start('ob_gzhandler');
        } else {
            ob_start();
        }
        
        import('system/share/exception/BaseException');
        import('system/share/exception/DoesNotExistsException');

        //set_exception_handler(array('BaseException', 'handler'));

        import('system/share/config/base');
        BaseConfig::init();

        self::BuildEnvironment();

        import('system/share/pluggable/base');
        
        import('system/share/network/request');
        Request::init();
		//echo "123";
        self::runApplication();
		
        self::output();
		
    }
    
    /*
     * Boot::runApplication()
     */
    static private function runApplication() {
        import('system/share/urls/base');
		
        BaseUrlParser::parse();
		
        BaseUrlParser::dispatch(BaseUrlParser::$app, BaseUrlParser::$action,
                                BaseUrlParser::$params);
								//echo "123";
    }

    /*
     * Boot::output();
     *
     * ob_end_flush(), output the HTML to the browser
     */
    static public function output() {
        Pluggable::trigger('after_system_exit');
        ob_end_flush();
    }

    static public function shutdown() {
        self::output();
        exit(0);
    }

    /*
     * Boot::BuildEnvironment()
     *
     * @param $run_mode String enum(devel, deploy, test)
     * @return void
     *
     * Build the runtime environment
     * 
     */
    static private function BuildEnvironment($run_mode='deploy') {

        $base_run_mode = ini('base/RUN_MODE');
        $run_mode = $base_run_mode? $base_run_mode : $run_mode;
        
        $run_mode = strtolower($run_mode);
        !defined('RUN_MODE') && define('RUN_MODE', $run_mode);
        import('system/environment/base');
        import(sprintf('system/environment/%s', $run_mode));
        
        import('system/share/config/runtime');
        RuntimeConfig::__init__($run_mode);
            
        $run_mode_classname = ucfirst($run_mode).'Environment';
        $runtime_environment = new $run_mode_classname();

    }
    
}


?>
