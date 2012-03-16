<?php

/**
 * BaseGroup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property Doctrine_Collection $User
 * @property Doctrine_Collection $ACLMap
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGroup extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('auth_groups');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));


        $this->index('group_index', array(
             'fields' => 'name',
             'type' => 'unique',
             ));

        $this->setAttribute(Doctrine_Core::ATTR_VALIDATE, true);

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('User', array(
             'local' => 'id',
             'foreign' => 'group_id'));

        $this->hasMany('ACLMap', array(
             'local' => 'id',
             'foreign' => 'object_id'));
    }
}