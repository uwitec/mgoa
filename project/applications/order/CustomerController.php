<?php
/**
 * Description of CustomerController
 *
 * @author Nemo.xiaolan
 * @created 2011-3-30 18:40:46
 */

class CustomerController extends BaseApplication {

    /*
     * 客服录入新客户
     */
    public function add_customer () {
        AuthPlugins::required($this, '客服');
        $smarty = parent::load('smarty');
        $smarty->assign('page_title', '新增订单');
        if($this->is_post()) {
            unset($_POST['CSRF_TOKEN']);
            unset($_POST['sub4']);
            $model = parent::load('model', 'order');

            $time_str = sprintf('%s %s:%s', $_POST['subscribe_time'], $_POST['book_hour'], $_POST['book_minu']);
            $_POST['subscribe_time'] = date('Y-m-d H:i', strtotime($time_str));
            try {
                $customer = new Customer();
                $order = new Order();
                foreach($_POST as $k=>$v) {
                    if(isset($customer->$k)) {
                        $customer->$k = trim(htmlspecialchars($v));
                    } else if(isset($order->$k)) {
                        $order->$k = trim(htmlspecialchars($v));
                    }
                }
                /*
                 * 客户提供资料
                 */
                if($_FILES['cus_docs']) {
                    import('system/share/io/filesystem');
                    FileSystem::init();
                    $http_path = FileSystem::Upload($_FILES['cus_docs'], false);
                    $customer->docs = $http_path;
                }

                /*
                 * 保存客户信息
                 */
                $customer->save();

                /*
                 * 取得工作流程ID（订单状态）
                 */
                $workflow = Workflow::get_by_alias('新增订单管理');
                /*
                 * 新建订单， 并写入当前的订单初始信息
                 */

                $order->Customer = $customer;
                $order->Workflow = $workflow;
                
                /*
                 * 客服
                 */
                $order->CustomerService = User::current();
                $order->save();
                
                import('system/share/network/redirect');
                $message = '订单信息录入成功， 转入新增订单管理页面';

                /*
                 * 清除订单列表缓存
                 */
//                $smarty->clearCache('order/list');
                $smarty->clearAllCache();

                HTTPRedirect::flash_to($workflow['action'], $message, $smarty);
            } catch(Doctrine_Query_Exception $e) {
                $smarty->raise('system');
            }

        } else {
            parent::load('form', 'NewCustomer');
            $smarty->display('customer/add');
        }
    }

    public function detail($id) {
        $smarty = parent::load('smarty');
        $smarty->assign('page_title', '客户详情');

        $id = abs(intval($id));
        if(!$id) {
            $smarty->display(404);
        }

        parent::load('model', 'order');
        $order = Order::get_by_id($id);

        $smarty->assign('order', $order);
        $smarty->display('customer/detail');
    }

}


?>
