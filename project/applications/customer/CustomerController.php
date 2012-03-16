<?php
/**
 * Description of CustomerController
 *
 * @author Nemo.xiaolan
 * @created 2011-4-7 11:34:35
 */

class CustomerController extends BaseApplication{

    public function __construct() {
        parent::__construct();
        parent::load('model', 'order');

        import('system/contrib/auth/plugins');
        AuthPlugins::required($this, '客户');
    }

    /*
     * 客户工作平台的首页
     */
    public function index() {
        $smarty = parent::load('smarty');

        $userinfo = User::info();
        $customer = Customer::get_by_id($userinfo['id']);

        $order_list = Order::get_by_customer($customer->id);


        $smarty->assign('orders', $order_list);
        $smarty->assign('customer', $customer);
        $smarty->display('customer/index');
    }

    /*
     * 选择设计师
     */
    public function select_designer($order_id, $designer_id = null) {
        import('system/share/network/redirect');
        
        $smarty = parent::load('smarty');
        $order = Order::get_by_id($order_id);

        if($order->Customer->CustomerUser->id != User::info('id')) {
            $message = sprintf('这个订单不是您的');
            HTTPRedirect::flash_to('', $message, $smarty, 'cus_flash_to');
        }

        $workflow = Workflow::get_by_alias('首页设计');
        $designer_id = abs(intval($designer_id));

        if($designer_id) {
            $designer = User::get_by_id($designer_id);
        } else {
            $smarty->assign('page_title', '选择设计师');

            /*
             * 这里可能对设计师的列表有一个条件
             */
            $smarty->assign('order', $order);
            $smarty->assign('designer', User::get_by_role_alias('设计师'));
        }

        if($designer_id && $designer) {
            $order->Workflow = $workflow;
            $order->Designer = $designer;
            $order->save();
            $message = sprintf('首页设计任务已经成功分配给 %s', $designer->name);
            HTTPRedirect::flash_to('customer', $message, $smarty, 'cus_flash_to');
        } else {
            $smarty->display('customer/select_designer');
        }
    }

    /*
     * 订单详情
     */
    public function detail($order_id) {
        parent::load('model', 'order');
        $smarty = parent::load('smarty');

        $order = Order::get_by_id($order_id);
        if(!$order || $order->Customer->CustomerUser->id != User::info('id')) {
            echo '无效的订单ID或者您不是此订单的所有者';
            return;
        }

        if($order->Payment) {
            $not_payed = 0;
            foreach($order->Payment as $p) {
                if($p->is_payed != 2) {
                    $not_payed += $p->price;
                }

                $p->public = $p->public ? '是' : '否';
                $p->invoice = $p->invoice ? '是' : '否';

                switch($p->is_payed) {
                    case 0:
                        $p->is_payed = '未付款';
                        break;
                    case 1:
                        $p->is_payed = '已付款， 待确认';
                        break;
                    case 2:
                        $p->is_payed = '已付款， 财务已经确认';
                        break;
                    case -1:
                        $p->is_payed = $p->content;
                        break;
                }
            }
        }

        $smarty->assign('not_payed', $not_payed);
        $smarty->assign('order', $order);
        $smarty->display('customer/order_detail');

    }

    /*
     * 首页确认
     */
    public function decide_index($order_id) {

        AuthPlugins::required($this, array('客户', '技术经理'));

        
        import('system/share/io/filesystem');
        FileSystem::init();
        $http_path = FileSystem::Upload($_FILES['attachment']);

        if(!$_FILES['attachment'] || !$http_path) {
            HTTPRedirect::flash_to('customer', '请您上传首页确认书的扫描件', $this->smarty, 'cus_flash_to');
        }
        
        $smarty = parent::load('smarty');
        import('system/share/network/redirect');

        $order = Order::get_by_id($order_id);
        /*
         * 此处需要验证一下客户是否已经支付了二期款项，如果已经支付， 直接转入内页设计
         * 支付状态为2是财务已经确认首款
         */
        $second_pay = Payment::get_by_order_and_state($order_id, 2, 'second');
        if($second_pay) {
            $workflow = Workflow::get_by_alias('内页设计');
        } else {
            $workflow = Workflow::get_by_alias('首页确认');
        }

        $userinfo = User::info();

        if(!$order || ($order->Customer->CustomerUser->id != $userinfo['id']
                || $userinfo['role']['0']['alias'] == '技术经理')) {
            echo '无效的订单ID或者您不是此订单的所有者';
            exit;
        }

        $order->index_decide_attachment = $http_path;
        $order->Workflow = $workflow;
        $order->save();

        $message = '恭喜您， 首页设计图确认成功';
        $flash_to = $userinfo['role']['0']['alias'] == '技术经理' ? 'order/list/'.$workflow->id
                    : 'customer';
        $template = $userinfo['role']['0']['alias'] == '技术经理' ? 'flash_to'
                    : 'cus_flash_to';
        HTTPRedirect::flash_to($flash_to, $message, $smarty, $template);
    }

    /*
     * 内页确认
     */
    public function decide_inner($order_id) {
        AuthPlugins::required($this, array('客户', '技术经理'));
        $smarty = parent::load('smarty');
        import('system/share/network/redirect');

        $order = Order::get_by_id($order_id);
        /*
         * 判断尾款是否已付，如果已付，直接转入售后部门上线
         */
        $last_pay = Payment::get_by_order_and_state($order_id, 2, 'last');
        $workflow = Workflow::get_by_alias('布局任务');

        $userinfo = User::info();

        if(!$order || ($order->Customer->CustomerUser->id != $userinfo['id']
                || $userinfo['role']['0']['alias'] == '技术经理')) {
            echo '无效的订单ID或者您不是此订单的所有者';
            exit;
        }
        
        $order->workflow_id = $workflow->id;
        $order->save();

        $message = '恭喜您， 内页确认成功';
        $flash_to = $userinfo['role']['0']['alias'] == '技术经理' ? 'order/list/'.$workflow->id
                    : 'customer';
        $template = $userinfo['role']['0']['alias'] == '技术经理' ? 'flash_to'
                    : 'cus_flash_to';
        HTTPRedirect::flash_to($flash_to, $message, $smarty, $template);

    }

    /*
     * 程序确认
     */
    public function decide_programe($order_id) {
        $workflow = Workflow::get_by_alias('程序验收完成');

        import('system/share/io/filesystem');
        FileSystem::init();
        $http_path = FileSystem::Upload($_FILES['attachment']);

        if(!$_FILES['attachment'] || !$http_path) {
            HTTPRedirect::flash_to('customer', '请您上传首页确认书的扫描件', $this->smarty, 'cus_flash_to');
        }

        $order = Order::get_by_id($order_id);
        $order->programe_decide_attachment = $http_path;
        $order->save();
        Order::set_workflow($order_id, $workflow);

        $smarty = parent::load('smarty');
        import('system/share/network/redirect');

        $message = '程序验收完成，等待客户付尾款即可上线';
        $flash_to = $userinfo['role']['0']['alias'] == '技术经理' ? 'order/list/'.$workflow->id
                    : 'customer';
        $template = $userinfo['role']['0']['alias'] == '技术经理' ? 'flash_to'
                    : 'cus_flash_to';
        HTTPRedirect::flash_to($flash_to, $message, $smarty, $template);
    }

}


?>
