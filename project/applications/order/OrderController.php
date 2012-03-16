<?php
/**
 * Description of ${name}
 *
 * @author Nemo.xiaolan
 * @created ${date} ${time}
 *
 * @TODO 在每个工作流程中， 加入对订单状态的判断。以及在订单列表中， 针对某个人的列表。 DONE
 * @TODO 自首页确认之后流程的 操作选项和 权限验证 DONE
 * @TODO 客服修改客户信息
 * @TODO 销售修改方案
 * @TODO 客户上传确认书
 * @TODO 设计师，程序员填写预览地址
 * @TODO 重写可查看列表导航部分。 根据has_role 挨个处理。 现在的有点乱。Workflow::get_navigation()
 * @TODO 表单验证
 * @TODO 订单详情中 可编辑内容
 * @TODO 分销售一部二部？
 * @TODO 用户角色的默认首页
 * @TODO 驳回款项， 以及订单复活
 */

class OrderController extends BaseApplication {

    private $workflow_en_alias = array(
        /*跟进中*/
        'followed' => array(
            'need_person'=> array(
                '销售顾问', '销售经理'
            ),
            'alias'=> '跟进订单管理'
        ),
        'long_followed'=> array(
            'need_person'=> array(
                '销售顾问', '销售经理'
            ),
            'alias'=> '长期跟进订单'
        ),
        /**/
        'blacklist'=> array(
            'need_person'=>'销售顾问',
            'alias'=> '拉黑订单管理'
        ),
        /*已签约订单*/
        'ordered' => array(
            'need_person'=> array(
                '设计师', '销售顾问', '布局师', '程序员'
            ),
            'alias'=> '签约订单管理'
        ),
    );

    private $role_map = array(
        '销售顾问' => 'seller_id',
        '设计师'  => 'designer_id',
        '布局师'  => 'layouter_id',
        '程序员'  => 'programmer'
    );
    

    /*
     * Order类的构造， 首先调用父类的构造函数
     * 然后载入model 和一些常用的应用。
     */
    public function __construct() {

        parent::__construct();
        parent::load('model', 'order');
        parent::load('model', 'system/contrib/auth');

        import('system/share/network/redirect');
        $this->smarty->assign('active_navigation', 1);
    }

    /*
     * ls的别名方法， order的首页
     */
    public function index($workflow = null) {
        HTTPRedirect::to('order/list');
    }

    /*
     * 某些特定的工作流程中列表
     */
    public function workflow($workflow_en_alias) {
        if(!key_exists($workflow_en_alias, $this->workflow_en_alias)) {
            HTTPRedirect::to('order/list');
        }

        $current = $this->workflow_en_alias[$workflow_en_alias];
        $userinfo = User::info();
        if(User::has_role('售后经理')) {
            $w23 = Workflow::get_by_alias('尾款确认');
            HTTPRedirect::to('order/list/'.$w23->id);
        }
        $workflow = Workflow::get_by_alias($current['alias']);

        if(count($workflow->Children) > 0) {
            $workflow_id = array();
            foreach($workflow->Children as $child) {
                $workflow_id[] = $child->id;
            }
            $workflow_id[] = $workflow->id;
        }

        $query = Doctrine_Query::create()
                             ->select('o.*, c.*, w.*, os.*, cs.*, op.*')
                             ->from('Order o')
                             ->leftJoin('o.Workflow w')
                             ->leftJoin('o.Customer c')
                             ->leftJoin('o.CustomerService cs')
                             ->leftJoin('o.Seller os')
                             ->leftJoin('o.Payment op');

        if(is_array($workflow_id) && $workflow_id){
            $workflow_id = implode(',', $workflow_id);
            $query->where('o.workflow_id IN ('.$workflow_id.')');
        } else {
            $query->where('o.workflow_id = ? ', $workflow->id);
        }
        
        
        /*
         * 需要只调用某个人的列表
         */
        if($current['need_person']) {
            if(is_array($current['need_person'])) {
                foreach($current['need_person'] as $role_person) {
                    if(User::has_role($role_person)) {
                        $field = $this->role_map[$role_person];
                        break;
                    }
                }
            } else {
                $field = $this->role_map[$current['need_person']];
            }
            if($field) {
                $query->addWhere(sprintf('o.%s = ?', $field), $userinfo['id']);
            }
        }

        $query->orderBy('o.id DESC');

        $orders = $query->fetchArray();
        $this->ls($workflow, true, $orders);

    }
    
    /*
     * 获取订单列表部分的工作流程导航， 依据为当前角色的工作流程权限
     * 获取订单列表， 查询依据为工作流程
     */
    public function ls($workflow = null, $mix = false, $orders = null) {
        
        $smarty = parent::load('smarty');
        $userinfo = User::info();

        /*
         * 缓存ID
         */
        $cache_id = sprintf('order_list_%s_%s_%s', $workflow, $_GET['page'], User::info('id'));

        /*
         * 订单导航
         */
        $_navigation = Workflow::get_navigation($userinfo);

        if(!$workflow) {
            if($_navigation[0]['alias'] == '录入订单') {
                $action = $_navigation[1]['action'];
            } else {
                $action = $_navigation[0]['action'];
            }
            HTTPRedirect::to($action);
        }

        

        if(!$workflow instanceof Workflow) {
            $workflow = Workflow::get_by_id($workflow);
        }

        $smarty->assign('page_title', $workflow->name);

        /*
         * 当前工作流程是否允许当前用户查看
         */
        $role_ids = array_filter(explode(',', $workflow->roles));
        AuthPlugins::required($this, $role_ids);

        /*
         * 当前导航
         */
        foreach($_navigation as $nav) {
            if($nav['id'] == $workflow->id) {
                $navigation[$nav['id']]['active'] = true;
            }
            $navigation[$nav['id']] = $nav;
        }

        $smarty->assign('page_title', $navigation[$workflow->id]['name']);
        $smarty->assign('active_workflow', $workflow->id);
        $smarty->assign('order_navigation', $navigation);

        /*
         * 获取工作流程中， 当前的可操作选项
         */
         $operation = Workflow::get_operation($workflow->sequence, User::info());
         $smarty->assign('operations', $operation);
         $smarty->assign('workflow', $workflow);
         if(!$mix) {

             if(method_exists('OrderController', 'order_list_custom_'.$workflow)) {
                 $method_name = 'order_list_custom_'.$workflow->id;
                 $orders = $this->$method_name($workflow->id);
             } else {
                 /*
                 * 订单列表
                 */
                if(count($workflow->Children) > 0) {
                    $get_by_id = array();
                    foreach($workflow->Children as $child) {
                        $get_by_id[] = $child->id;
                    }
                    $get_by_id[] = $workflow->id;
                } else {
                    $get_by_id = $workflow->id;
                }

                /*
                 * 在跟进订单之后 只显示当前用户所有的
                 */
                if($workflow->id > 2 && !User::has_role('总经理')) {
                    $orders = Order::get_list($get_by_id, $userinfo['id'], $userinfo['role'][0]['alias']);
                } else {
                    $orders = Order::get_list($get_by_id);
                }
             }

             if(User::has_role('技术经理')) {
                 $operation[] = array(
                     'label'=> '分配任务',
                     'action'=> 'order/select_designer'
                 );
             }

         }


        /*
         * 分页
         */
        import('system/share/web/paginator');
        $paginator = new Paginator($orders, $_GET['page'], 10);

        $smarty->assign('paginator', $paginator->output());

        /*
         * 是否客服
         */
        if(User::has_role('客服')) {
            $smarty->assign('is_customer_service', true);
        }
            

        /*
         * 尝试显示对应操作的模板
         */
        try {
            if($workflow->template) {
                $tpl = $workflow->template;
            } else {
                $tpl = str_replace('order/list/', 'order/list_', $navigation[$workflow->id]['action']);
            }
            $smarty->display($tpl);
        } catch(DoesNotExistsException $e) {
            $smarty->display('order/list');
        }
        
    }

    /*
     * 为客服准备的 已经联系到之后的列表
     */
    public function contacted_list() {
        
        parent::load('model', 'system/contrib/auth');
        parent::load('model', 'order');

        $orders = Doctrine_Query::create()
                                  ->select()
                                  ->from('Order o')
                                  ->leftJoin('o.Customer oc')
                                  ->leftJoin('o.Seller os')
                                  ->leftJoin('o.CustomerService ocs')
                                  ->leftJoin('o.Workflow ow')
                                  ->orderBy('o.id DESC')
                                  ->where('o.customer_service_id = ?', User::info('id'))
                                  ->limit('30')
                                  ->fetchArray();

        $smarty = parent::load('smarty');
        $smarty->assign('orders', $orders);
        $smarty->display('order/contacted_list');

    }

    /*
     * 订单详细页面
     */
    public function detail($id = null) {
        $smarty = parent::load('smarty');
        $cache_id = 'order_detail_'.$id;

        $smarty->assign('page_title', '订单详情');

        $id = abs(intval($id));
        if(!$id) {
            $smarty->display(404);
        }

        $order = Order::get_by_id($id);

        if($order->Payment[0]) {
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

        
        /*
         * 获取工作流程中， 当前的可操作选项
         */
        $workflow = Workflow::get_by_id($order['workflow_id']);

        /*
         * 在订单未联系之前 销售人员不能查看订单， 防止挑
         */
         if($workflow->alias == '新增订单管理' &&
                        !User::has_role('客服') && !User::has_role('总经理')){
             HTTPRedirect::flash_to('order/list', '在联系订单之前，您没有权限进行此操作', $smarty);
         }


        $operation = Workflow::get_operation($workflow['sequence'], User::info());

        if(User::has_role('技术经理')) {
             $operation[] = array(
                 'label'=> '分配任务',
                 'action'=> 'order/select_designer'
             );
         }

        $smarty->assign('operations', $operation);
        $smarty->display('order/detail', $cache_id);
    }

    /*
     * 联系订单
     */
    public function contact($id) {
        
        AuthPlugins::required($this, array('销售经理', '销售顾问'));

        $workflow = Workflow::get_by_alias('跟进订单管理');
        $order = Order::get_by_id($id);

        
        if(!$order) {
            return false;
        }
        $order->workflow_id = $workflow['id'];
        $order->seller_id = User::info('id');
        $order->save();
        
        HTTPRedirect::flash_to('order/list/'.$workflow['id'],
                                '联系订单成功， 进入跟进订单页面', $this->smarty);
    }

    /*
     * 订单详情页面的 可编辑区域
     */
    public function editable($order_id) {
        $key = str_replace('editable__', '', $_POST['key']);
        if($key == 'content'){
            $checked = AuthPlugins::required($this, array('销售经理', '销售顾问', '客服', '技术经理', '设计师', '布局师', '程序员', '售后经理'), true);
        } else {
            $checked = AuthPlugins::required($this, array('销售经理', '销售顾问', '客服'), true);
        }
        
        if(!$checked) {
            echo '您没有权限进行此操作';
            return;
        }

        $order_id = abs(intval($order_id));
        if(!$order_id) {
            echo '无效的参数';
            return;
        }

        $content = nl2br(trim(strip_tags($_POST['content'])));
        
        if(!$content || !$key) {
            echo '参数不能为空';
            return;
        }

        $order = Order::get_by_id($order_id);
        if(isset($order->$key)) {
            $order->$key = $content;
            $order->save();
        } else if(isset($order->Customer->$key)) {
            $order->Customer->$key = $content;
            $order->Customer->save();
        } else {
            echo '未知字段';
            return;
        }

        /*
         * 清空订单详情页面缓存
         */
        $cache_id = 'order_detail_'.$order_id;
        $smarty = parent::load('smarty');
//        $smarty->clearCache('order/detail', $cache_id);
        
        $smarty->clearAllCache();
//        var_dump($smarty->isCached('order/detail',$cache_id));
    }

    /*
     * 长期跟进订单
     */
    public function follow($id) {
        AuthPlugins::required($this, array('销售经理', '销售顾问'));
        $workflow = Workflow::get_by_alias('长期跟进订单');

        Order::set_workflow($id, $workflow);

        HTTPRedirect::flash_to('order/list/'.$workflow['id'],
                                '长期跟进成功， 进入长期跟进订单管理页面', $this->smarty);
    }

    /*
     * 拉黑订单
     */
    public function blacklist($id) {
        AuthPlugins::required($this, array('销售经理', '销售顾问'));
        $workflow = Workflow::get_by_alias('拉黑订单管理');
        $order = Order::get_by_id($id);
        if(!$order) {
            return false;
        }
        $order->Workflow = $workflow;
        $order->save();

        HTTPRedirect::flash_to('order/list/'.$workflow['id'],
                                '拉黑订单成功， 进入拉黑订单管理页面', $this->smarty);
    }

    /*
     * 复活订单
     */
    public function chunge($id) {
        AuthPlugins::required($this, array('销售经理', '销售顾问'));
        $workflow = Workflow::get_by_alias('跟进订单管理');

        Order::set_workflow($id, $workflow);

        HTTPRedirect::flash_to('order/list/'.$workflow['id'],
                                '订单复活成功， 进入跟进订单管理页面', $this->smarty);
    }

    /*
     * OrderController::contract()
     * @params integer $order_id
     * @params stirng $step
     * 签约订单
     * 1. 确定订单里的信息
     * 2. 确定需求方案 solution
     * 3. 确定报价信息 price
     * 4. 上传合同扫描件 paper
     * 5. 付款信息(首，二期，尾款，已付) payment 这里需要下给财务
     * 6. 签约完成 end
     *
     * @TODO 在签约完成后， 创建客户用户
     */
    public function contract($order_id, $step = null) {

        AuthPlugins::required($this, array('销售经理', '销售顾问'));

        $order_id = abs(intval($order_id));
        $order = Order::get_by_id($order_id);
        if(!$step) {
            $step = 'solution';
        }
        
        $smarty = parent::load('smarty');
        $smarty->assign('order', $order);

        switch($step) {
            case 'solution':
                $solution_id = abs(intval($_GET['id']));
                if($solution_id) {
                    /*
                     * 全部设为非选定方案
                     */
                    Solution::set_unchecked();
                    /*
                     * 选定某个方案
                     */
                    Solution::select($solution_id);
                    HttpRedirect::to('order/contract/'.$order_id.'/paper');
                } else {
                    $solutions = Solution::get_by_order($order_id);
                    if(!$solutions) {
                        $message = '您还没有为此订单添加方案， 请返回添加';
                        HTTPRedirect::flash_to('order/detail/'.$order_id, $message, $smarty);
                    }

                    $smarty->assign('page_title', '签约订单 - 选定方案 Step 1');
                    $smarty->display('contract/solution');
                }
                break;
            case 'paper':
                if(!Solution::get_checked($order_id)) {
                    $message = '您还没有选择方案， 请返回选择';
                    HTTPRedirect::flash_to('order/contract/'.$order_id.'/solution',
                            $message, $smarty);
                }
                if($this->is_post() || $_FILES) {
                    import('system/share/io/filesystem');
                    FileSystem::init();
                    $http_path = FileSystem::Upload($_FILES['paper_attachment'], false);
                    if(!FileSystem::$local_path) {
                        $message = '不支持的附件类型， 请检查';
                        HTTPRedirect::flash_to('order/detail/'.$order_id, $message, $smarty);
                    }
                    $order->paper_attachment = $http_path;
                    $order->save();

                    HTTPRedirect::flash_to('order/contract/'.$order_id.'/payment', '上传合同成功', $this->smarty);
                } else {
                    $smarty->assign('page_title', '签约订单 - 上传合同附件 Step 2');
                    $smarty->display('contract/paper');
                }

                break;
            case 'payment':
                if($this->is_post()) {
                    /*
                     * 获取选定的订单方案
                     */
                    $solution = Solution::get_checked($order_id);
                    /*首付款*/
                    $first_pay = new Payment();
                    $first_pay->order_id = $order_id;
                    $first_pay->type = 'first';
                    $first_pay->price = abs(intval($_POST['deposit']));
                    $first_pay->invoice = abs(intval($_POST['invoice']));
                    $first_pay->public  = abs(intval($_POST['pub']));
                    $first_pay->bank  = trim(strip_tags($_POST['bank']));
                    $first_pay->is_payed = abs(intval($_POST['is_deposit']));
                    $first_pay->save();
                    /*二期款*/
                    $second_pay = new Payment();
                    $second_pay->order_id = $order_id;
                    $second_pay->type = 'second';
                    $second_pay->price = abs(intval($_POST['payment']));
                    $second_pay->invoice = abs(intval($_POST['invoice']));
                    $second_pay->public  = abs(intval($_POST['pub']));
                    $second_pay->bank  = trim(strip_tags($_POST['bank']));
                    $second_pay->is_payed = abs(intval($_POST['is_payment']));
                    $second_pay->save();
                    /*尾款*/
                    $last_pay = new Payment();
                    $last_pay->order_id = $order_id;
                    $last_pay->type = 'last';
                    $last_pay->price = abs(intval($_POST['last_pay']));
                    $last_pay->invoice = abs(intval($_POST['invoice']));
                    $last_pay->public  = abs(intval($_POST['pub']));
                    $last_pay->bank  = trim(strip_tags($_POST['bank']));
                    $last_pay->is_payed = abs(intval($_POST['is_last_pay']));
                    $last_pay->save();

                    $old_workflow = $order->Workflow->action;

                    $workflow = Workflow::get_by_alias('新增财务订单');
                    $order->Workflow = $workflow;
                    $order->save();

                    /*
                     * 在用户表中写入客户的登录信息
                     * 登录名为客户填写的名字加订单ID
                     * 密码为'MG-客服ID-订单号'
                     */
                    $user = new User();
                    $user->username = $order->Customer->name.$order->id;
                    $user->password = User::generate_password(sprintf('MG-%s-%s',
                                            $order->customer_service_id, $order->id));
                    $user->Role[0] = Role::get_by_alias('客户');
                    $user->save();

                    $order->Customer->CustomerUser = $user;
                    $order->Customer->save();


                    $message = '恭喜您签约订单成功， 目前订单已转入财务管理页面';
                    HTTPRedirect::flash_to('order/list/6', $message, $smarty);

                } else {
                    $smarty->assign('page_title', '签约订单 - 付款信息 Step 3');
                    $smarty->display('contract/payment');
                }
                break;
        }


        
    }

    /*
     * 首款
     */
    public function first_pay($order_id) {

        AuthPlugins::required($this, '财务');

        $payment = Payment::get_by_order_and_state($order_id, 1, 'first');
        $payment->is_payed = 2;
        $payment->save();

        $order = Order::get_by_id($order_id);
        $workflow = Workflow::get_by_alias('等待下单');
        $order->Workflow = $workflow;
        $order->save();

        $message = '确认首付款项成功， 转回销售部';
        HTTPRedirect::flash_to('order/list/'.$workflow->id, $message, $this->smarty);
    }

    /*
     * 驳回款项
     */
    public function disallow_pay($order_id, $payment_id) {
        AuthPlugins::required($this, '财务');
    }

    /*
     * 下单
     */
    public function order_it($order_id) {
        AuthPlugins::required($this, '销售经理');

        $workflow = Workflow::get_by_alias('待技术经理分配');
        $order = Order::get_by_id($order_id);
        $order->Workflow = $workflow;
        
        $order->save();
        $message = '下单成功， 订单已经转入技术部';
        HTTPRedirect::flash_to('', $message, $this->smarty);
    }

    /*
     * 选择设计师
     *
     * 这里可以是客户选择， 也可以是技术经理选择
     */
    public function select_designer($order_id, $type='', $user_id = null) {
        AuthPlugins::required($this, array('技术经理'));
        
        $userinfo = User::info();
        foreach($userinfo['role'] as $role) {
            $roles[] = $role['alias'];
        }

        $order = Order::get_by_id($order_id);
        $workflow = Workflow::get_by_alias('首页设计');
        $user_id = abs(intval($user_id));

        /*
         *
         */
        $smarty = parent::load('smarty');
        if($user_id) {
            $user = User::get_by_id($user_id);
        } else {
            $smarty->assign('page_title', '分配任务');

            /*
             * 这里可能对设计师的列表有一个条件
             */
            $smarty->assign('order', $order);
            $smarty->assign('designer', User::get_by_role_alias('设计师'));
            $smarty->assign('layouter', User::get_by_role_alias('布局师'));
            $smarty->assign('programmer', User::get_by_role_alias('程序员'));
        }
        
        /*
         * 技术经理指定
         *
         * 选择设计师 则改变当前的工作流程 进行下一步
         */
        if($user_id && $user) {
            
            switch($type) {
                case 'designer':
                    $order->designer_id = $user_id;
                    $order->Workflow = $workflow;
                    break;
                case 'layouter':
                    $order->layouter_id = $user_id;
                    break;
                case 'programmer':
                    $order->programmer = $user_id;
                    break;
            }

            $order->save();
            $message = sprintf('任务已经成功分配给 %s', $user->name);
            HTTPRedirect::flash_to('order/select_designer/'.$order->id, $message, $smarty);
        } else {
            $smarty->display('order/select_designer');
        }

    }

    /*
     * 首页设计
     * 流程到这里需要设计师开始设计首页， Controller路由到work应用 新建一个订单的工作
     * 首页确认
     * 首页确认是需要客户或者技术经理来做的， 所以此部分功能在customer应用中实现
     */
    public function index_design() {}
    public function index_decide() {}

    /*
     * 首页确认之后客户需要支付二期款项
     * 如果客户在初始时已经支付了二期款项， 则工作流程直接跳转到内页设计
     */
    public function second_pay($order_id) {
        AuthPlugins::required($this, array('销售顾问', '销售经理'));
        $workflow = Workflow::get_by_alias('二期款项确认');
        $order = Order::get_by_id($order_id);

        $action = $order->Workflow->action;

        $payment = Payment::get_by_order_and_state($order_id, 0, 'second');
        $payment->is_payed = '1';
        $payment->save();

        Order::set_workflow($order, $workflow);

        $message = '已经转入财务工作流程， 等待财务确认二期款项';
        HTTPRedirect::flash_to('order/workflow/ordered', $message, $this->smarty);
    }

    /*
     * 财务确认二期款项
     */
    public function second_pay_confirm($order_id) {
        AuthPlugins::required($this, '财务');
        $payment = Payment::get_by_order_and_state($order_id, '1', 'second');
        $payment->is_payed = 2;
        $payment->save();

        Order::set_workflow($order_id, Workflow::get_by_alias('内页设计'));

        $message = '二期款项确认成功， 订单转入内页设计';
        HTTPRedirect::flash_to($action, $message, $this->smarty);
    }

    /*
     * 内页设计
     * 内页设计通首页设计， 在work应用中实现
     * 内页设计完成
     * 在work应用中实现， 需要验证是否已经分配了布局师和程序员
     */
    public function inner_design() {}
    public function inner_design_complete() {}

    /*
     * 技术经理分配布局师和程序
     * 这里不涉及到工作流程的变动， 只是赋予订单布局师和程序员的一个过程
     */
    public function dispatch($order_id, $complete = false) {
        
        AuthPlugins::required($this, '技术经理');
        $smarty = parent::load('smarty');
        
        $order = Order::get_by_id($order_id);

        if($complete && $this->is_post()) {
            $order->layouter_id = abs(intval($_POST['layouter']));
            $order->programmer  = abs(intval($_POST['programmer']));
            $order->save();
        } else {

            $samrty->assign('page_title', '选择设计师和程序员');

            $smarty->assign('order', $order);

            $smarty->assign('layouter', Role::get_users_by_alias('布局师'));
            $smarty->assign('programmer', Role::get_users_by_alias('程序员'));

            $smarty->display('order/dispatch');
        }

    }


    /*
     * 开始布局 以及布局完成， 在work应用中实现
     */
    public function layout() {}
    public function layout_complete() {}

    /*
     * 开始制作程序 以及程序制作完成， 在work应用中实现
     */
    public function develop() {}
    public function develop_complete() {}

    /*
     * 程序验收确认, 在客户应用中实现， 或者技术经理也可以操作
     */
    public function program_decide() {}

    /*
     * 提交财务确认尾款
     */
    public function last_pay($order_id) {
        AuthPlugins::required($this, array('销售顾问', '销售经理'));
        $workflow = Workflow::get_by_alias('尾款提交确认');
        $order = Order::get_by_id($order_id);

        $action = $order->Workflow->action;

        $payment = Payment::get_by_order_and_state($order_id, 0, 'last');
        if(!$payment) {
            HTTPRedirect::flash_to('order/detail/'.$order_id, '款项信息不存在', $this->smarty);
        }
        $payment->is_payed = '1';
        $payment->save();

        Order::set_workflow($order, $workflow);

        $message = '已经转入财务工作流程， 等待财务确认尾款';
        HTTPRedirect::flash_to($action, $message, $this->smarty);
    }

    /*
     * 财务确认尾款
     */
    public function last_pay_confirm($order_id) {
        AuthPlugins::required($this, '财务');
        $payment = Payment::get_by_order_and_state($order_id, '1', 'last');
        $payment->is_payed = 2;
        $payment->save();

        Order::set_workflow($order_id, Workflow::get_by_alias('尾款确认'));

        $message = '尾款确认成功， 订单已转入售后部门安排上线';
        HTTPRedirect::flash_to($action, $message, $this->smarty);
    }

    /*
     * 上线 - 标记整个工作流程完成
     */
    public function publish($order_id) {
        AuthPlugins::required($this, '售后经理');
        
        $workflow = Workflow::get_by_alias('已经上线');
        Order::set_workflow($order_id, $workflow);

        $message = '网站已成功上线， 订单流程完成';
        HTTPRedirect::flash_to('order/list/'.$workflow->id, $message, $this->smarty);
    }

    /*
     * 售后服务？ 还有这个玩意
     */
    public function service() {}


    /*
     * 财务的新增财务订单页面， 需要定制一些东西
     * 7是workflow的sequence, 14是二次付款的
     *
     * 获取订单的未付款信息
     */
    private function order_list_custom_7($workflow_id) {
        return Order::get_list($workflow_id, null, null, 1, 'first');
    }

    private function order_list_custom_14($workflow_id) {
        return Order::get_list($workflow_id, null, null, 1, 'second');
    }


}


?>