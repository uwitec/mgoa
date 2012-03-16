<?php
/**
 * Description of base
 *
 * @author Nemo.xiaolan
 * @created 2011-1-28 15:10:27
 */

class BaseEnvironment {

    static public $lang = 'en_US';
    
    public function __construct(array $config = null) {
        if(PATH_SEPARATOR == ':') {
            $server_os = 'linux';
        } else {
            $server_os = 'windows';
        }
        define('SERVER_OS', $server_os);
        $this->use_i18n();
    }

    private function use_i18n() {

        ini_set('date.timezone', ini('base/TIME_ZONE'));

        if(!ini('base/USE_I18N')) {
            define('USE_I18N', false);
            return true;            
        }

        define('USE_I18N', true);
        
        self::$lang = $lang = ini('base/LANGUAGE_CODE');
        if(!$lang) {
            $lang = 'en_US';
        }

        $package = 'messages';
        
        if(SERVER_OS == 'linux') {
            $lang.='.utf8';
            setlocale(LC_ALL, $lang);
        } else {
            putenv("LANG=".$lang);
            setlocale(LC_ALL, $lang);
        }
        
        bindtextdomain($package, Package::get_folder('etc/locale.d'));
        textdomain($package);
        bind_textdomain_codeset($package, 'UTF-8');

    }

}

if(!ini('base/USE_I18N') && !function_exists('_')) {
    function _($string) {
        return $string;
    }

    function gettext($string) {
        return $string;
    }
}


?>
