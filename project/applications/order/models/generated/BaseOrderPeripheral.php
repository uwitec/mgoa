<?php

/**
 * BaseOrderPeripheral
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $order_id
 * @property integer $peripheral_id
 * @property Order $Order
 * @property Peripheral $Peripheral
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseOrderPeripheral extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('order_peripheral');
        $this->hasColumn('order_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('peripheral_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));


        $this->index('query', array(
             'fields' => 
             array(
              0 => 'order_id',
              1 => 'peripheral_id',
             ),
             ));
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Order', array(
             'local' => 'order_id',
             'foreign' => 'id'));

        $this->hasOne('Peripheral', array(
             'local' => 'peripheral_id',
             'foreign' => 'id'));
    }
}