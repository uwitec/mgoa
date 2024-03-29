<?php

/**
 * OrderWork
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class OrderWork extends BaseOrderWork
{
    static public function change_percent($work_id, $percent) {}

    static public function get_by_order($order_id, $type = 'index_design') {
        return Doctrine_Query::create()
                               ->select('*')
                               ->from('OrderWork ow')
                               ->where('ow.order_id = ? AND ow.type = ?', array($order_id, $type))
                               ->fetchOne();
    }

    static public function get_by_user($user_id) {}

    static public function get_by_id($work_id) {}
}