<?php
/*
 * File: AuthController.php
 * 
 * Encoding: UTF-8
 * Created on: Jan 28, 2011 7:26:23 PM
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

class AuthController extends BaseApplication {

    /*
     * Just for test
     */
    public function index() {
        
        parent::load('model', 'system/contrib/auth');

        #AuthPlugins::login_required($this);
        /*
        parent::load('model', 'auth');
        $permission = new Permission;
        $permission->name = '注册';
        $permission->action = 'auth/register';
        $permission->save();

        $gp = new GroupPermission();
        $gp->group_id = 1;
        $gp->permission_id = $permission->id;
        $gp->save();
         * 
         */

//        
//        import('system/bin/doctrine');
//        DatabaseBackend::syncdb('auth');exit;

        /*
        $cache = parent::load('cache');
        //$cache->set('test_key', 'test_data', 10000);
        if(!$cache->is_cached('test_key')) {
            $cache->set('test_key', 'test_data', 10000);
        }

        echo $cache->get('test_key');
         * 
         */
        /*
        parent::load('model','auth');
        $group = new Group();
        $group->name = 'System';
        $group->save();
        $user = Doctrine_Query::create()
                                ->select('*')
                                ->from('User u')
                                ->where('id=2')
                                ->fetchOne();
        $user->Group = $group;
        $user->save();
        //$user->Group[0]->name = 'Default';
        //$user->save();
        exit;
         * 
         */

        $this->smarty->display('auth/index');
    }

    /*
     * AuthController::login()
     * @param $next string | login forward
     * @return void
     */
    public function login($next = null) {

        parent::load('model','system/contrib/auth.User');
        /*
         * Loggined redirect to default
         */
        if(User::is_authenticated()) {
            import('system/share/network/redirect');
            HTTPRedirect::to(ini('base/DEFAULT_ACTION'));
        }

        
        $smarty = parent::load('smarty');
        $login_form = parent::load('form', 'LoginForm', $_POST);

        /*
         * not post, just display
         */
        import('system/share/security/csrf');
        Session::start();
        if(!$this->is_post()) {
            $smarty->assign('login_form', $login_form->output());
            $smarty->display('auth/login');
            return;
        }

        /*
         * Validate the login form data
         */
        if(!$login_form->is_valid()) {
            $smarty->assign('login_form', $login_form->output());
        } else if($_SESSION['vdcode'] !== strtoupper($_POST['vdcode'])) {
            $login_form->messages[] = '验证码错误';
            $smarty->assign('login_form', $login_form->output());
        } else {
            
            /*
             * Call the User Model to authentication
             */
            $user = User::authentication($login_form->data['username'],
                                         $login_form->data['password']);
            if(User::is_authenticated()) {
                import('system/share/network/redirect');
                HTTPRedirect::to($next);
            } else {
                array_push($login_form->messages, $user);
                $smarty->assign('login_form', $login_form->output());
            }
        }
        
        if($next) {
            $smarty->assign('params', array($next));
        }

        $smarty->display('auth/login');

    }

    public function register() {

        return false;

        parent::load('model','system/contrib/auth.User');
        /*
         * Loggined redirect to default
         */
        if(User::is_authenticated()) {
            import('system/share/network/redirect');
            HTTPRedirect::to(ini('base/DEFAULT_ACTION'));
        }

        $smarty = parent::load('smarty');
        $register_form = parent::load('form', 'LoginForm', $_POST);

        if(!$this->is_post()) {
            $smarty->assign('register_form', $register_form->output());
            $smarty->display('auth/register');
            return;
        }

        if($register_form->is_valid() && Request::$method == 'POST') {
            $user = UserTable::findByUsername($register_form->data['username']);
            if($user) {
                array_push($register_form->messages, _('Username exists'));
            } else {
                $user = new User();
                $user->username = $register_form->data['username'];
                $user->password = User::generate_password(
                        $register_form->data['password']);
                $user->save();
                User::authentication($user->username, $register_form->data['password']);
                import('system/share/network/redirect');
                HTTPRedirect::to(url_reverse('auth_index'));
            }
        }

        $smarty->assign('register_form', $register_form->output());
        $smarty->display('auth/register');
        
    }

    public function logout() {
        parent::load('model', 'system/contrib/auth.User');
        User::logout();
        import('system/share/network/redirect');
        HTTPRedirect::to(url_reverse('auth_login'));
    }
    
    public function lost_password() {
        
    }

    public function change_password() {
        parent::load('model', 'system/contrib/auth.User');
        $user = UserTable::getInstance()->find(User::info('id'));
        import('system/share/network/redirect');
        
        if($this->is_post()) {
            list($func, $random, $encryped) = explode('$', $user->password);
            /*
             * 验证原密码
             */
            if($user->password && $user->password === User::generate_password(
                                                $_POST['old_password'], $random, $func)) {
                $user->password = User::generate_password($_POST['new_password']);
                $user->save();

                User::logout();
                $message = '修改密码成功， 请重新登录';
                HTTPRedirect::flash_to(url_reverse('auth_login'), $message, $this->smarty);
                
            } else {
                $message = '原密码不正确， 请重试';
                HTTPRedirect::flash_to('accounts/change_password', $message, $this->smarty);
            }
            
        }

        $this->smarty->display('auth/change_password');
    }

    /*
     * 注册验证码
     */
    public function check_code() {
        import('system/contrib/auth/checkcode');
        import('system/share/network/session');

        Session::start();

        $a = new ValidationCode();
        $a->outimg();
        $_SESSION['vdcode'] = $a->checkcode;
    }

}
    

?>
