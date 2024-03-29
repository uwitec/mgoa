<?php

/**
 * Customer
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Customer extends BaseCustomer
{
    static public function get_by_id($customer_id) {
        return Doctrine_Query::create()
                               ->select('*, IFNULL(cu.nickname, cu.username) AS name')
                               ->from('Customer c')
                               ->leftJoin('c.Order co')
                               ->leftJoin('c.CustomerUser cu')
                               ->where('cu.id = ?', $customer_id)
                               ->fetchOne();
    }
}