<?php
/**
 * Description of plugins
 *
 * @author Nemo.xiaolan
 * @created 2011-2-26 15:28:32
 */

class GravatarPlugins {

    /*
     * use the gravatar 
     */
    public function load_gravatar($base_app) {
    	

        /*smarty function*/
        function smarty_function_get_gravatar($params, $tpl_obj) {
            RuntimeConfig::load_application_config('gravatar');
            /*
             * the params
             */
            $email = md5($params['email']);
            $size   = $params['size'] ? $params['size'] : ini('gravatar_config/size');
            $size   = $size ? $size : '80';
            $rating = $params['rating'] ? $params['rating'] : ini('gravatar_config/rating');
            $rating = $rating ? $rating : 'G';
            $default= $params['default'] ? $params['default'] : ini('gravatar_config/default');
            $default = $default ? $default : 'wavatar';

            /*
             * Cache the remote avatar to local server
             */
            $cache_dir = Package::get_folder(ini('gravatar_config/cache_dir'));
            $cache_img = $cache_dir.DS.$email.'_'.$size.'.jpg';
            if(is_file($cache_img) && filemtime($cache_img)
                    + ini('gravatar_config/cache_life') > time()) {
                $link = str_ireplace(BASE_DIR.DS, ini('base/BASE_URL'), $cache_img);
                $link = str_ireplace(DS, '/', $link);
            } else {
                $link = sprintf('http://www.gravatar.com/avatar/%s?rating=%s&size=%s&default=%s',
                        $email, $rating, $size, $default);
                $content = @file_get_contents($link);
                if(!$content) {
                    $link = $params['onerror'] ?
                            $params['onerror'] : ini('gravatar_config/onerror_img');
                } else {
                    if(ini('gravatar_config/caching') && $cache_dir && $params['email']) {
                        if(!is_dir($cache_dir)) {
                            @mkdir($cache_dir, 0777);
                        }
                        @file_put_contents($cache_img, $content);
                    }
                }
            }
            
            return <<<EOF
                <img src="{$link}" width="{$size}" height="{$size}" />
EOF;

        }

        /*
         * register smarty plugin
         */
        $smarty = $base_app->load('smarty');
        $smarty->registerPlugin('function', 'gravatar', 'smarty_function_get_gravatar');
    }

}



?>
