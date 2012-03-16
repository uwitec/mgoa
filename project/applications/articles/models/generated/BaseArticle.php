<?php

/**
 * BaseArticle
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property integer $category_id
 * @property text $content
 * @property integer $author
 * @property Category $Category
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseArticle extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('articles');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('category_id', 'integer', 8, array(
             'type' => 'integer',
             'length' => 8,
             ));
        $this->hasColumn('content', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('author', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('alias', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));


        $this->index('nasha', array(
             'fields' => 
                 array(
                  0 => 'category_id',
                  1 => 'name',
                  2 => 'author',
                 ),
             )
        );
        $this->index('alias', array(
            'fields'=> array(
                0=> 'alias'
            ),
            'type'=> 'unique'
        ));
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Category', array(
             'local' => 'category_id',
             'foreign' => 'id'));

        $this->hasOne('User as Author', array(
             'local' => 'author',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}