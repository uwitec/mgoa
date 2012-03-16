<?php
/**
 * Description of ${name}
 *
 * @author Nemo.xiaolan
 * @created ${date} ${time}
 */

class Statics {
    
    static public $ltes;
    
    static private $elements = array(
        'js'=> '<script type="text/javascript" src="%s.js"></script>',
        'css'=> '<link type="text/css" href="%s.css" rel="stylesheet" />',
    );
    
    static public function load($path, $type='js', $extra = null) {
        $media_url = ini('base/MEDIA_URL');
        $file = Package::get_file('statics/'.$path, $type);
        if(is_file($file)) {
            return sprintf(self::$elements[$type], $media_url.$path, $extra);
        }
    }
    
    static public function load_lte($path, $type='js', $ie_version = 6) {
        $inner = self::load($path, $type);
        self::$ltes[$ie_version][] = $inner;
        
    }
    
    static public function lte_code($code, $ie_version = 6) {
        self::$ltes[$ie_version][] = $code;
    }
    
    static public function output_lte($baseapp) {
        if(!self::$ltes) {
            return '';
        }
        $str = '';
        foreach(self::$ltes as $ie_version => $lte) {
            if(!$lte) {
                continue;
            }
            $str .= "<!--[if lte IE {$ie_version}]>";
            foreach($lte as $item) {
                $str .= $item;
            }
            $str .= "<![endif]-->";
        }
        $baseapp->smarty->append_tpl_var('extra_statics', $str);
    }
    
}


?>