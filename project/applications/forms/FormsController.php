<?php
/**
 * Description of FormsController
 *
 * @author Nemo.xiaolan
 * @created 2011-4-22 16:03:25
 */

class FormsController extends BaseApplication {

    public $maps = array(
        '请假申请'=> 'leave',
        '入职表' => 'injob',
        '出差申请'=> 'travel'
    );

    /*
     * 入职表单
     */
    public function injob() {}

    /*
     * 请假单
     */
    public function leave() {
        $smarty = parent::load('smarty');
        $leave_form = parent::load('form', 'LeaveForm', $_POST);

        parent::load('model', 'forms');
        parent::load('model', 'system/contrib/auth.User');

        if(!$this->is_post()) {
            import('system/share/web/paginator');
            if(User::has_role('人力资源') || User::has_role('总经理')) {
                $data = Forms::get_by_type_and_user('请假申请');
                $smarty->assign('has_role', true);
            } else {
                $data = Forms::get_by_type_and_user('请假申请', User::info('id'));
            }
            
            $paginator = new Paginator((array)$data, $_GET['page'], 10);
            $smarty->assign('paginator', $paginator->output());

            $smarty->assign('page_title', '请假申请');
            $smarty->assign('leave_form', $leave_form->output());
            $smarty->display('forms/leave');
            return;
        }

        
        $form_data = new Forms();
        $form_data->user_id = User::info('id');
        $form_data->state   = 0;
        $form_data->type    = '请假申请';
        $form_data->form_data = serialize($_POST);
        $form_data->save();

        

        import('system/share/network/redirect');
        HTTPRedirect::flash_to('forms/leave', '提交请假申请成功, 请耐心等待审核', $smarty);
        
    }

    /*
     * 出差申请
     */
    public function travel() {}

    /*
     * 表单状态修改
     */
    public function state() {

        $id = abs(intval($_GET['id']));
        $state = abs(intval($_GET['state']));

        echo $id;

        parent::load('model', 'forms');
        import('system/share/network/redirect');
        $form = FormsTable::getInstance()->find($id);

        if(!$form) {
            return false;
        }

        $form->state = $state;
        $form->save();

        HTTPRedirect::flash_to('forms/'.$this->maps[$form->type], '操作成功', $this->smarty);
    }


}

?>
