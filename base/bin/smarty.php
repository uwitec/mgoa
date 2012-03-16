<?php
/**
 * Description of smarty
 *
 * @author Nemo.xiaolan
 * @created 2011-1-22 12:37:58
 *
 * Extend the Smarty
 */

import('system/vendors/Smarty/Smarty.class');

class TemplateBackend extends Smarty {

    public $left_delimiter = '{%';

    public $right_delimiter = '%}';

    /*
     * set the smarty config and return the smarty instance
     */
    public function __construct() {

        parent::__construct();

        $this->template_dir   = Package::get_folder('var/templates');
        $this->compile_dir    = Package::get_folder('tmp/tpl_compiled');

        if(strtolower(ini('base/RUN_MODE')) == 'devel') {
            $this->debugging      = false;
            $this->debug_tpl      = Package::get_file('var/templates/smarty_debug', 'tpl');
            $this->config_dir     = Package::get_folder('etc/conf.d/smarty');
        } else {
            $this->caching        = false;
            $this->cache_lifetime = ini('runtime/template/cache_life');
            $this->cache_dir      = Package::get_folder('tmp/tpl_caches');
        }

        if(USE_I18N) {
            import('system/share/web/smarty_plugins/gettext');
            $this->registerPlugin('block', 'trans', 'smarty_translate');
        }

        import('system/share/web/smarty_plugins/common');
        $this->registerPlugin('function', 'url', 'smarty_function_url');
        $this->registerPlugin('function', 'load', 'smarty_function_load_dynamic_plugins');
        
        $this->assign_public_tpl_vars();
        return $this;
    }

    
    public function assign_public_tpl_vars() {
        $media_url = ini('base/MEDIA_URL');
        if(substr($media_url, 0, 4) != 'http') {
            $media_url = ini('base/BASE_URL').$media_url;
            BaseConfig::set('base/MEDIA_URL', $media_url);
        }

        $this->assign('BASE_URL', ini('base/BASE_URL'));
        $this->assign('MEDIA_URL', $media_url);
    }
    
    public function append_tpl_var($key, $content) {
        $this->assign($key, $this->getTemplateVars($key).$content);
    }

    /*
     * TemplateBackend::display()
     *  See: Smarty::display()
     *
     * @param $template string
     * @param $cache_id
     * @param $compile_id
     * @param $parent
     * @return void
     *
     * Override the Smarty::display() method,
     *  find the template in every application's own templates folder
     *
     */
    public function display($template, $cache_id = null, $compile_id = null, $parent = null) {

        //BaseApplication::_call_middleware('after');
        Pluggable::trigger('before_template_render');
        /*
         * echo big
         */
        $content = $this->fetch($template, $cache_id, $compile_id, $parent);
        function echobig($string, $bufferSize = 8192) {
            $splitString = str_split($string, $bufferSize);
            foreach($splitString as $chunk)
                echo $chunk;
        }

        echobig($content);
        
        Pluggable::trigger('after_template_render');
        
    }
    
    public function fetch($template, $cache_id = null, $compile_id = null, $parent = null) {
        
        $tpl = $this->get_template_real_path($template);
        try {
            return parent::fetch($tpl, $cache_id, $compile_id, $parent);
        } catch(Exception $e) {
            import('system/share/exception/TemplateException');
            throw new TemplateException(1009, $tpl.'. '.$e->getMessage());
        }
        
    }
    
    public function isCached($template, $cache_id = null, $compile_id = null, $parent = null) {
    	$template = $this->get_template_real_path($template);
    	return parent::isCached($template, $cache_id, $compile_id, $parent);
    }
    
    public function get_template_real_path($template) {
    	$installed_apps = ini('base/INSTALLED_APPS');
        $tpl = Package::get_file('applications/'.ini('runtime/application')
                .'/templates/'.$template, 'tpl');

        if(!is_file($tpl)) {
            foreach($installed_apps as $app) {
                $file = Package::get_file(sprintf('applications/%s/templates/%s',
                                $app, $template), 'tpl');
                if(is_file($file)) {
                    $finded = true;
                    $tpl = $file;
                    break;
                }
            }
            if(!$finded) {
                $tpl = Package::get_file('var/templates/'.$template, 'tpl');
            }
        }

        if(!is_file($tpl)) {
            throw new DoesNotExistsException(1008, $tpl);
        }
        
        return $tpl;
        
    }

}



?>
