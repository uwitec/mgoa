<?php
/*
 * File: base.php
 * 
 * Encoding: UTF-8
 * Created on: Mar 1, 2011 6:28:46 PM
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

class BaseAdmin {
	
    /*
     * The admin site menus
     */
	static private $menus = array();

    /*
     * BaseAdmin::add_menu()
     * @param array $urlpatterns
     * @param string $menu_group
     * <code>
     *  BaseAdmin::add_menu();
     * </code>
     */
    static final public function add_menu(array $url, $menu_group) {
    	
        if('admin_site' != $url['position'] || 
               !in_array('admin_site', (array)$url['position'])) {
    		return;
   		}
   		$label = $url['label'] ? $url['label'] : $url['name'];
   		$label = $label ? $label : $key;
        self::$menus[$menu_group]['name'] = _($menu_group);
        self::$menus[$menu_group]['items'][$url['name']] = array( 
   			'label'=> _($label),
    		'class'=> $url['class'],
            'action_name'=> $url['name']
    	);
    }
    
    static final public function build_menus() {
    	foreach(BaseUrlParser::$url_patterns as $map_name=>$actions) {
    		foreach($actions as $k=>$v) {
                self::add_menu($v, $v['menu_group']);
            }
    	}
        return self::$menus;
    }
    
}

    

?>
