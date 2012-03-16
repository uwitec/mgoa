<?php
/*
 * File: middlewares.php
 * 
 * Encoding: UTF-8
 * Created on: Feb 20, 2011 11:59:31 AM
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
class AuthPlugins {

    /*
     * AuthMiddleware::init()
     *
     * @param $base_app object | instance of BaseApplication
     * @return void
     *
     * assign the user info to template
     */
    static public function userinfo($base_app) {
        $smarty = $base_app->load('smarty');
        $base_app->load('model', 'system/contrib/auth.User');
        
        if(User::is_authenticated()) {
            $user = array(
                'is_authenticated'=> true,
                'info'=> User::$info
            );
            if(User::has_role('人力资源') || User::has_role('总经理')) {
                $user['is_super_admin'] = true;
            }
        } else {
            $user = array(
                'is_authenticated'=> false
            );
        }
        $smarty->assign('user', $user);
    }

    /*
     * Check it
     *
     * 1. User
     * 2. Role
     * 3. Group
     */
    static public function check_action_ACL($base_app) {

        $has_permission = false;
        
        $action = ini('runtime/application').'/'.ini('runtime/action');
        if(ini('runtime/application') == 'system/contrib/auth' || ini('runtime/application') == 'system/contrib/dev_tools') {
            return true;
        }

        $base_app->load('model', 'system/contrib/auth');

        if(!User::is_authenticated()) {
            import('system/share/network/redirect');
            HTTPRedirect::to('accounts/login');
        }

        $smarty = $base_app->load('smarty');

        $userinfo = User::info();

        /*
         * 客户只有查看
         */
        if($userinfo['role'][0]['alias'] == '客户') {
            
        }

        $has_permission = self::__check_action_ACL($userinfo['id'], $action, 'User', 'action', $smarty);
        if($has_permission === true) {
            return true;
        }

        if($userinfo['group']) {
            $has_permission = self::__check_action_ACL($userinfo['group']['id'], $action, 'Group', 'action', $smarty);
            if($has_permission === true) {
                return true;
            }
        }

        if($userinfo['role']) {
            foreach($userinfo['role'] as $role) {
                $has_permission = self::__check_action_ACL($role['id'], $action, 'Role', 'action', $smarty);
                if($has_permission === true) {
                    return true;
                }
            }
        }


        
        $smarty->display(403);
        Boot::shutdown();
    }

    /*
     */
    static public function __check_action_ACL() {
        list($a, $b, $c, $d, $smarty) = func_get_args();
        $has_permission = ACL::has_permission($a, $b, $c, $d);
        if($has_permission || $has_permission === null) {
            return true;
        } else if($has_permission !== false){
            $smarty->display(403);
            Boot::shutdown();
        }
        return false;
    }


    /*
     * Neet user login
     */
    static public function login_required($base_app) {
        $base_app->load('model', 'system/contrib/auth.User', false);
        if(!User::is_authenticated()) {
            import('system/share/network/redirect');
            HTTPRedirect::to('accounts/login');
            Boot::shutdown();
        }
        return true;
    }

    /*
     * 
     */
    static public function admin_required($base_app) {
        $base_app->load('model', 'system/contrib/auth.User', false);
        if(!User::is_superadmin()) {
            $base_app->smarty->display('403');
            Boot::shutdown();
        }
        return true;
    }

    /*
     * AuthPlugins::required()
     * @param $role_id_or_name mixed
     * @return boolean
     */
    static public function required($base_app, $role_id_or_name, $only_check = false) {

        $has_permission = false;

        $base_app->load('model', 'system/contrib/auth.User', false);
        $userinfo = User::info();


        /*
         * Multi check
         */
        if(is_array($role_id_or_name)) {
            foreach($role_id_or_name as $value) {
                if(abs(intval($value)) > 0) {
                    $field = 'id';
                } else {
                    $field = 'alias';
                }
                $has_permission = self::__required($userinfo['role'], $value, $field);
                if($has_permission) {
                    return true;
                }
            }
        }

        /*
         * check by id or name
         */
        if(abs(intval($role_id_or_name)) > 0) {
            $field = 'id';
        } else {
            $field = 'alias';
        }
        
        $has_permission = self::__required($userinfo['role'], $role_id_or_name, $field);
        if($has_permission) {
            return true;
        }

        if($only_check) {
            return false;
        } else {
            $base_app->smarty->display(403);
            Boot::shutdown();
        }
    }

    static public function __required($roles, $role_id_or_name, $field='id') {
        if(!$roles || !is_array($roles)) {
            return false;
        }

        foreach($roles as $role) {
            if($role[$field] == $role_id_or_name) {
                return true;
            }
        }
        
        return false;
    }

}
    

?>
