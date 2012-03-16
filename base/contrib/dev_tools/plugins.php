<?php
/**
 * Description of ${name}
 *
 * @author Nemo.xiaolan
 * @created ${date} ${time}
 */

class DevToolsPlugins {
    
    static public function toolbar($base_app) {
    	if(RUN_MODE != 'devel') {
    		return;
    	}
        $smarty = $base_app->load('smarty');
        $smarty->caching = false;
        
        global $start_time;
        $smarty->assign('processed_in', microtime(true)-$start_time);
        $smarty->assign('config', ini());
        
        $toolbar = $smarty->fetch('dev_tools/toolbar');
        $content = ob_get_clean();
        if(function_exists('ob_gzhandler')) {
            ob_start('ob_gzhandler');
        } else {
            ob_start();
        }
        echo str_ireplace('</body>', $toolbar.'</body>', $content);
        ob_end_flush();
        $smarty->caching = true;
    }
} 


?>