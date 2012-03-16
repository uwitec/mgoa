<?php

/**
 * Workflow
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Workflow extends BaseWorkflow
{
    static public $navigation = array(
        '客服' => array(
            '录入订单',
            '新增订单管理',
        ),
        '销售经理' => array(
            '新增订单管理',
            '跟进订单管理',
            '长期跟进订单',
            '拉黑订单管理',
            '签约订单管理',
        ),
        '销售顾问' => array(
            '新增订单管理',
            '跟进订单管理',
            '长期跟进订单',
            '拉黑订单管理',
            '签约订单管理',
        ),
        '财务' => array(
            '签约订单管理',
            '新增财务订单',
            '二期款项确认',
            '尾款提交确认',
        ),
        '技术经理' => array(
            '待技术经理分配',
            '签约订单管理',
            '已经上线',
        ),
        '设计师' => array(
            '签约订单管理',
            '已经上线',
        ),
        '布局师' => array(
            '签约订单管理',
            '布局任务',
            '已经上线',
        ),
        '程序员' => array(
            '签约订单管理',
            '程序任务',
            '已经上线',
        ),
        '售后经理' => array(
            '尾款确认',
            '已经上线',
        ),
    );

    static public function get_by_id($id) {
        $id = abs(intval($id));
        return Doctrine_Query::create()
                               ->select('w.*')
                               ->from('Workflow w')
                               ->leftJoin('w.Children wc')
                               ->where('w.id = ?', $id)
                               ->fetchOne();
    }
    /*
     * Workflow::get_by_name()
     * @params string $name
     * @return object
     *
     * Get the workflow detail by alias
     * <code>
     *  Workflow::get_by_alias('新增订单');
     * </code>
     */
    static public function get_by_alias($name) {
        return Doctrine_Query::create()
                               ->select('*')
                               ->from('Workflow w')
                               ->leftJoin('w.Children wc')
                               ->where('alias = ?', $name)
                               ->fetchOne();
    }

    /*
     * Workflow::get_navigation()
     * @params array $user_roles
     * @return object
     *
     * Get the current user's workflow navigation by roles
     * <code>
     *  Workflow::get_navigation(array(1,2,3))
     * </code>
     */
    static public function get_navigation($userinfo) {
        foreach($userinfo['role'] as $role) {
            $roles[] = $role['alias'];
        }

        $operations = Doctrine_Query::create()
                             ->select('w.*')
                             ->from('Workflow w')
                             ->orderBy('w.sequence ASC, w.id ASC')
                             ->fetchArray();

        foreach($roles as $role) {
            if(!self::$navigation[$role]){
                continue;
            }
            foreach(self::$navigation[$role] as $k=>$v) {
                $navs[] = $v;
            }
        }

        foreach($operations as $opera) {
            if(!$navs) {
                break;
            }
            /*
             * 符合当前用户的可操作流程
             */
            if(in_array($opera['alias'], $navs)) {
                $returns[] = $opera;
            }
        }

        return $returns;

    }


    /*
     * Workflow::get_operation()
     * @params $sequence integer
     * @return string
     *
     * 获取当前角色在当前工作流程中的可操作选项
     */
    static public function get_operation($sequence, $userinfo = null) {

        $operation = ini('order_config/operation/sequence_'.$sequence);

        if(!$operation) {
            return array();
        }

        if(!$userinfo['role']) {
            return $operation;
        }

        foreach($userinfo['role'] as $role) {
            $roles[] = $role['alias'];
        }

        /*
         * 遍历当前所有的操作
         */
        $ops = array();
        foreach($operation as $op) {
            /*
             * 多个角色可以进行此操作
             */
            if(is_array($op['role'])) {
                foreach($op['role'] as $r) {
                    if(in_array($r, $roles)) {
                        $ops[] = $op;
                        break;
                    }
                }
            }else if(in_array($op['role'], $roles)) {
                $ops[] = $op;
            /*
             * 没有对角色进行限制的时候， 默认当前流程的角色皆可以看到操作选项
             */
            } else if(!$op['role']) {
                $ops[] = $op;
            }
        }


        return $ops;

    }

}