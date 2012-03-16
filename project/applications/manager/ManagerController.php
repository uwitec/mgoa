<?php
/**
 * Description of ManagerController
 *
 * @author Nemo.xiaolan
 * @created 2011-5-6 14:48:26
 */

class ManagerController extends BaseApplication {

    public function __construct() {
        parent::__construct();
        $this->smarty = parent::load('smarty');
        $this->smarty->assign('page_title', '系统设置');

        import('system/share/network/redirect');
    }

    /*
     * 管理首页
     */
    public function index() {
        $this->smarty->display('manager/index');
    }

    /*
     * 新增用户
     */
    public function new_user() {
        
        $register_form = parent::load('form', 'LoginForm', $_POST, 'system/contrib/auth');

        parent::load('model', 'system/contrib/auth');

        $roles = RoleTable::getInstance()->findAll();

        $this->smarty->assign('all_roles', $roles);

        $groups = GroupTable::getInstance()->findAll();
        $groups_cleaned = array();
        foreach($groups as $k=>$v) {
            $groups_cleaned[$v['id']] = $v['name'];
        }

        $this->smarty->assign('all_groups', $groups_cleaned);

        if($this->is_post()) {
            /*
             * 验证表单数据
             */
            if($register_form->is_valid() && Request::$method == 'POST') {
                $user = UserTable::findByUsername($register_form->data['username']);
                if($user) {
                    array_push($register_form->messages, '员工名称已经存在');
                } else {

                    $user = new User();

                    $user->username = $register_form->data['username'];
                    $user->password = User::generate_password(
                            $register_form->data['password']);
                    $user->group_id = abs(intval($_POST['group']));

                    /*
                     * 用户角色
                     */
                    if($_POST['roles']) {
                        foreach($roles as $k=> $role) {
                            if(in_array($role['id'], $_POST['roles'])) {
                                $user->Role[$k] = $role;
                            }
                        }
                    }

                    $user->save();
                    
                    HTTPRedirect::flash_to('manager/new_user', sprintf('添加新员工 %s 成功', $user->username), $this->smarty);
                }
            }

        }

        $this->smarty->assign('register_form', $register_form->output());
        $this->smarty->display('manager/users/new');
        
    }

    /*
     * 员工列表
     */
    public function user_list() {
        parent::load('model', 'system/contrib/auth');
        $users = UserTable::getInstance()->findAll();

        import('system/share/web/paginator');
        $paginator = new Paginator($users, $_GET['page'], 20);

        $this->smarty->assign('paginator', $paginator->output());

        $this->smarty->display('manager/users/list');

    }

    /*
     * 角色管理
     */
    public function roles() {}

    /*
     * 分类管理
     */
    public function article_categories() {
        parent::load('model', 'system/contrib/auth');
        parent::load('model', 'articles');

        import('system/share/web/paginator');

        $roles = RoleTable::getInstance()->findAll();
        $roles_cleaned = array();
        foreach($roles as $role) {
            $roles_cleaned[$role['id']] = $role['name'];
        }


        $categories = CategoryTable::getInstance()->findAll();
        foreach($categories as $k=>$v) {
            $c_roles = array_filter(explode(',', $v['manager']));
            $categories[$k]->manager = '';
            if($c_roles) {
                
                foreach($c_roles as $_k => $_v) {
                    $categories[$k]->manager.= ' '.$roles_cleaned[$_v];
                }
            }
            
        }
        $paginator = new Paginator($categories, $_GET['page'], 20);

        $this->smarty->assign('paginator', $paginator->output());
        $this->smarty->display('manager/article/category_list');
    }

    /*
     * 编辑分类
     */
    public function category_edit($id) {
        parent::load('model', 'articles');
        parent::load('model', 'system/contrib/auth');
        
        $category = CategoryTable::getInstance()->find($id);
        if(!$category) {
            HTTPRedirect::flash_to('manager/article_categories', '分类不存在', $this->smarty);
        }

        $roles = RoleTable::getInstance()->findAll();
        $roles_cleaned = array();
        foreach($roles as $role) {
            $roles_cleaned[$role['id']] = $role['name'];
        }

        $this->smarty->assign('roles', $roles_cleaned);
        $this->smarty->assign('checked', array_filter(explode(',', $category['manager'])));
        $this->smarty->assign('category', $category);

        if($this->is_post()) {
            $category->name = trim(strip_tags($_POST['name']));
            $category->manager = sprintf(',%s,', implode(',', $_POST['roles']));
            $category->save();

            HTTPRedirect::flash_to('manager/article_categories', '修改分类成功', $this->smarty);
        }

        $this->smarty->display('manager/article/category_edit');

    }

    /*
     * 工作流程列表权限
     */
    public function workflow_permission() {
        parent::load('model', 'workflow');
        parent::load('model', 'order');
        parent::load('model', 'system/contrib/auth');
        $workflows = WorkflowTable::getInstance()->findAll();

        $roles = RoleTable::getInstance()->findAll();
        $roles_cleaned = array();
        foreach($roles as $role) {
            $roles_cleaned[$role['id']] = $role['name'];
        }

        foreach($workflows as $k => $workflow) {
            $_roles = array_filter(explode(',', $workflow->roles));
            $workflows[$k]->roles = '';

            if($_roles) {
                foreach($_roles as $_r) {
                    $workflows[$k]->roles.= ' '.$roles_cleaned[$_r];
                }
            }
            
        }
        
        import('system/share/web/paginator');
        $paginator = new Paginator($workflows, $_GET['page'], 20);

        $this->smarty->assign('paginator', $paginator->output());
        $this->smarty->display('manager/order/workflow_list');
    }

    public function workflow_edit($id) {
        parent::load('model', 'workflow');
        parent::load('model', 'order');
        parent::load('model', 'system/contrib/auth');

        $workflow = WorkflowTable::getInstance()->find($id);
        $all_roles = RoleTable::getInstance()->findAll();

        $workflow_roles = array_filter(explode(',', $workflow->roles));

        $options = array();
        foreach($all_roles as $ar) {
            
            $options[$ar['id']] = $ar['name'];
        }

        if($this->is_post()) {
            $workflow->roles = sprintf(',%s,', implode(',', $_POST['roles']));
            $workflow->save();

            HTTPRedirect::flash_to('manager/workflow_permission', '编辑工作流程权限成功', $this->smarty);
        }

        $this->smarty->assign('roles', $workflow_roles);
        $this->smarty->assign('workflow', $workflow);

        $this->smarty->assign('all_roles', $options);

        $this->smarty->display('manager/order/workflow_edit');

    }

}

?>