<?php

/**
 * BaseACLMap
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $acl_id
 * @property integer $object_id
 * @property string $object_type
 * @property integer $permission
 * @property ACL $ACL
 * @property Group $Group
 * @property User $User
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseACLMap extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('auth_acl_map');
        $this->hasColumn('acl_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('object_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('object_type', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('permission', 'integer', 1, array(
             'type' => 'integer',
             'length' => '1',
             ));


        $this->index('ids_index', array(
             'fields' => 
             array(
              0 => 'acl_id',
              1 => 'object_id',
              2 => 'permission',
             ),
             ));
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ACL', array(
             'local' => 'acl_id',
             'foreign' => 'id'));

        $this->hasOne('Group', array(
             'local' => 'object_id',
             'foreign' => 'id'));

        $this->hasOne('User', array(
             'local' => 'object_id',
             'foreign' => 'id'));
    }
}