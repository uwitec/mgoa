<?php
/**
 * Description of WorkController
 *
 * @author Nemo.xiaolan
 * @created 2011-4-7 15:51:19
 */

class WorkController extends BaseApplication {

    private $available_type = array(
        'index_design'=> '首页设计',
        'inner_design'=> '内页设计',
        'layout'      => '布局任务',
        'programe'    => '程序任务'
    );

    private $available_next_type = array(
        'index_design'=> '首页设计完成',
        'inner_design'=> '内页设计完成',
        'layout'      => '程序任务',
        'programe'    => '程序制作完成'
    );

    private $available_type_permission = array(
        'index_design'=> '设计师',
        'inner_design'=> '设计师',
        'layout'      => '布局师',
        'programe'    => '程序员'
    );

    /*
     * WorkController::start()
     * @params string $type | enum
     * @params integer $order_id
     * @return void
     *
     * 新建一个订单相关工作
     */
    public function start($type, $order_id) {
        
        AuthPlugins::required($this, $this->available_type_permission[$type]);

        if(!array_key_exists($type, $this->available_type)) {
            $this->unsupported($type);
        }

        $smarty = parent::load('smarty');
        import('system/share/network/redirect');
        parent::load('model', 'system/contrib/auth');
        parent::load('model', 'order');
        parent::load('model', 'work');

        /*
         * 是否此人工作
         */
        $order = Order::get_by_id($order_id);
        $userinfo = User::info();
        if($order->designer_id != $userinfo['id']
                && $order->layouter_id != $userinfo['id']
                && $order->programmer != $userinfo['id']) {
            $message = '这份工作好像不属于你';
            HTTPRedirect::flash_to('order', $message, $smarty);
        }

        /*
         * 下一工作流程
         */
        $workflow = Workflow::get_by_alias($this->available_type[$type]);
        $work = OrderWork::get_by_order($order_id, $type);
        /*
         * 工作已经开始
         */
        if($work) {
            $message = sprintf('此订单的 %s 工作已经开始', $this->available_type[$type]);
            HTTPRedirect::flash_to('order/list/'.$workflow->id, $message, $smarty);
        }

        $work = new OrderWork;
        $work->order_id = $order_id;
        $work->process  = '10';
        $work->type     = $type;
        $work->user_id  = User::info('id');

        $work->save();

        $message = '标记工作开始成功， 工作进度被设为10%， 请及时登记您的工作进度';
        HTTPRedirect::flash_to('order/list/'.$workflow->id, $message, $smarty);

    }

    /*
     * 工作结束
     */
    public function end($type, $order_id) {
        parent::load('model', 'work');
        parent::load('model', 'order');
        import('system/share/network/redirect');
        
        $smarty = parent::load('smarty');
        $work = OrderWork::get_by_order($order_id, $type);
        $workflow = Workflow::get_by_alias($this->available_next_type[$type]);
        
        if(!$work) {
            $message = sprintf('此订单的 %s 工作还没开始', $type);
            HTTPRedirect::flash_to('order/list/'.$workflow->id, $message, $smarty);
        }

        $work->process = 100;
        $work->save();

        Order::set_workflow($order_id, $workflow);

        $message = '此工作已经完成， 将转入下一工作流程';
        HTTPRedirect::flash_to('order/list/'.$workflow->id, $message, $smarty);
    }

    private function unsupported($type) {
        import('system/share/network/redirect');
        $message = sprintf('不支持的工作类型 %s', $type);
        HTTPRedirect::flash_to('order/list', $message, $smarty);
        exit;
    }

}

?>
