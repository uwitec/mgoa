<?php
/*
 * File: AdminController.php
 * 
 * Encoding: UTF-8
 * Created on: Mar 1, 2011 6:22:33 PM
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

class AdminController extends BaseApplication {
	
    /*
     * @variable AdminController::$smarty
     * the smarty instance in this process
     */
	public $smarty;

    /*
     * 
     */
    public function __construct() {
       
        
        /*
         * Call parent construct
         */
        parent::__construct();
        
        import('system/contrib/admin/base');
        import('system/contrib/auth/plugins');
        
        /*
         * Initialize the Pluggable if it doesn't initialized.
         */
        if(!Pluggable::$inited) {
        	Pluggable::init($this);
        }
        
        /*
         * smarty instance
         */
        $this->smarty = $this->load('smarty');
        
        /*
         * admin_required, if use RBAC, this will another use
         */
        AuthPlugins::admin_required($this);
        
        Pluggable::trigger('before_admin_site_run');
        
        $this->smarty->assign('admin_menus', BaseAdmin::build_menus());
    }
    
    public function index() {
    	$this->smarty->display('admin/index');
    }

	/*
	 * Will clear:
	 *   1. smarty template cache
	 *   2. memory cache and file cache
	 * */
    public function clear_cache() {
        import('system/bin/cache');
        CacheBackend::get_instance()->flush();
        $this->smarty->clearAllCache();
    }

}

    

?>
