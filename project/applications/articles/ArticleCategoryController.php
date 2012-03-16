<?php
/**
 * Description of ArticleCategoryController
 *
 * @author Nemo.xiaolan
 * @created 2011-4-13 9:10:42
 */

class ArticleCategoryController extends BaseApplication {
    
    public function index($id_or_alias) {
        parent::load('model', 'system/contrib/auth');
        parent::load('model', 'articles');
        
        $articles = Article::get_by_category($id_or_alias);

        import('system/share/web/paginator');
        $paginator = new Paginator($articles, $_GET['page'], 10);

        $category = CategoryTable::getInstance()->findByAlias($id_or_alias);
        
        $smarty = parent::load('smarty');
        $smarty->assign('category', $category[0]);
        $smarty->assign('paginator', $paginator->output());
        $smarty->assign('page_title', $category[0]->name);
        $smarty->display('article/list');
    }

}

?>
