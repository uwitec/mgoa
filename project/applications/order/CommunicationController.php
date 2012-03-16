<?php
/**
 * Description of CommunicationController
 *
 * @author Nemo.xiaolan
 * @created 2011-4-6 10:23:10
 */

class CommunicationController extends BaseApplication {

    /*
     * 增加销售沟通记录
     */
    public function add($order_id) {
        AuthPlugins::required($this,array('销售经理', '销售顾问'));
        $order_id = abs(intval($order_id));
        $content = trim(nl2br(strip_tags($_POST['content'])));
        if(!$order_id || !$this->is_post() || !$content) {
            return false;
        }
        parent::load('model', 'Order.Communication');
        $c = new Communication();
        $c->order_id = $order_id;
        $c->content = $content;
        $c->user_id = User::info('id');
        $c->save();

        echo 'ok';
    }

}


?>
