<?php
/**
 * Description of ${name}
 *
 * @author Nemo.xiaolan
 * @created ${date} ${time}
 */
 
 class DevController extends BaseApplication {
 	
 	public function syncdb($application = null) {
        if($_GET['confirm'] == 'true') {
            import('system/bin/doctrine');
            DatabaseBackend::syncdb($application);
        } else {
            $this->load('smarty')->display('dev_tools/confirm_syncdb');
        }
 	}
 	
 }


?>
