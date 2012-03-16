<?php
/**
 * Description of CenterController
 *
 * @author Nemo.xiaolan
 * @created 2011-4-13 10:38:13
 */

class CenterController extends BaseApplication {

    public function __construct() {
        
        parent::__construct();
        
        parent::load('model', 'system/contrib/auth');
        import('system/share/network/redirect');

        $userinfo = User::info();
        /*当前客户登陆的话*/
        if($userinfo['role'][0]['alias'] == '客户' || (!$userinfo['role'] && User::is_authenticated())) {
            HTTPRedirect::to('customer');
        }
    }

    /*
     * 登陆之后的首页
     */
    public function index() {
        $smarty = parent::load('smarty');

        parent::load('model', 'articles');
        $news = Doctrine_Query::create()
                        ->select('id, name, created_at')
                        ->from('Article a')
                        ->orderBy('id DESC')
                        ->limit('6')
                        ->fetchArray();

        /*
         * 销售顾问或者销售经理， 显示最近已经联系但是未签约的十个订单
         */
        parent::load('model', 'system/contrib/auth.User');
        if(User::has_role('销售顾问') || User::has_role('销售经理')) {
            parent::load('model', 'order');
            $orders = Doctrine_Query::create()
                        ->select('o.*, oc.*')
                        ->from('Order o')
                        ->leftJoin('o.Customer oc')
                        ->where('o.seller_id = ?', User::info('id'))
                        ->addWhere('o.workflow_id BETWEEN ? AND ?', array(2, 6))
                        ->orderBy('o.subscribe_time DESC')
                        ->fetchArray();

            $smarty->assign('long_not_orders', $orders);
        }

        /*
         * 判断是否客服
         */
        if(User::has_role('客服')) {
            $smarty->assign('is_customer_service', true);
        }

        $smarty->assign('news', $news);

        $smarty->assign('page_title', '管理中心');
        $smarty->display('center/index');
    }

    public function center() {
        $smarty = parent::load('smarty');
        $smarty->display('center/mine_index');
    }

    /*
     * 工作计划
     */
    public function work_plan() {
        parent::load('model', 'work');
        parent::load('model', 'system/contrib/auth');
        $smarty = parent::load('smarty');
        if(!$this->is_post()) {

            return;
        }

        /*
         * ajax提交的工作计划信息
         */
    }

}


?>
