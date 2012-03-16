<?php
/**
 * Description of SolutionController
 *
 * @author Nemo.xiaolan
 * @created 2011-4-6 11:56:43
 */

class SolutionController extends BaseApplication {

    /*
     * 某个订单增加方案
     */
    public function add($order_id) {

        import('system/share/network/redirect');

        AuthPlugins::required($this, array('销售经理', '销售顾问'));

        $order_id = abs(intval($order_id));
        if(!$this->is_post() || !$order_id) {
            return false;
        }

        /*
         * 上传方案附件
         */
        import('system/share/io/filesystem');
        FileSystem::init();
        $file_path = FileSystem::Upload($_FILES['attachment'], false);

        if(!$file_path) {
            HTTPRedirect::flash_to('order/detail/'.$order_id, '文件上传失败：'.FileSystem::$message, $this->smarty);
        }

        /*
         * 写入方案表
         */
        parent::load('model', 'order');
        $solution = new Solution();
        $solution->order_id = $order_id;
        $solution->solution_code = trim(strip_tags($_POST['solution_code']));
        $solution->name = trim(strip_tags($_POST['name']));
        $solution->attachment = $file_path;
        $solution->price = abs(intval($_POST['price']));

        $solution->save();

        HTTPRedirect::flash_to('order/detail/'.$order_id, '添加方案成功', $this->smarty);

    }

}


?>
