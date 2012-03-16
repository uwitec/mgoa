<?php
/*
 * File: redirect.php
 * 
 * Encoding: UTF-8
 * Created on: Feb 19, 2011 9:29:40 PM
 *
 * @author: xiaolan
 *
 * License:
 *
 * 
 * 
 *
 * Description:
 *  Change this.
 *
 */
class HTTPRedirect {

    static public $timeout = 3;

    /*
     * HTTPRedirect::to()
     * @param $url_pattern string
     */
    static public function to($url_pattern) {
        $url = BaseUrlParser::get_url($url_pattern);
        header('Location:'.$url);
        Boot::shutdown();
    }

    static public function flash_to($url_pattern, $message, $smarty,
                                     $template = 'flash_to') {
        $url = BaseUrlParser::get_url($url_pattern);

        $smarty->assign('page_title', '操作提示');

        $smarty->assign('message', $message);
        $smarty->assign('flash_to_url', $url);
        $smarty->assign('timeout', self::$timeout);
        $smarty->display($template);
        exit;
    }

    static public function back() {
        echo <<<EOF
        <script type="text/javascript">
            window.history.go(-1);
        </script>
EOF;
        Boot::shutdown();
    }

}
    

?>
