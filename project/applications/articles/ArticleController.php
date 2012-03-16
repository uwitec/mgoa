<?php
/**
 * Description of ArticleController
 *
 * @author Nemo.xiaolan
 * @created 2011-4-13 9:09:23
 */

class ArticleController extends BaseApplication{

    /*
     * 增加/删除文章
     */
    public function post_or_edit($id = null) {

        parent::load('model', 'articles');
        parent::load('model', 'system/contrib/auth');
        $smarty = parent::load('smarty');

        $categories = Category::get_select(User::info());
        
        if(!$categories) {
            $smarty->display('403');
            Boot::shutdown();
        }

        if($id) {
            $article = ArticleTable::getInstance()->find($id);
            
            $has_role = Category::has_role($article->Category->id, User::info());
            if((!$has_role || $article->author != User::info('id')) && !User::has_role('人力资源') && !User::has_role('总经理')) {
                $this->smarty->display(403);
                Boot::shutdown();
            }
            
            if(!$article) {
                $smarty->display('404');
                Boot::shutdown();
            }
            $article->content = stripslashes($article->content);
            $smarty->assign('article', $article);
            $smarty->assign('selected_category', $article->category_id);
            $smarty->assign('page_title', '修改文章');
        } else {
            if($_GET['category']) {
                $smarty->assign('selected_category', $_GET['category']);
            }
            $article = new Article;
            $smarty->assign('page_title', '添加新文章');
        }

        if($this->is_post()) {
            $category = Category::has_role($_POST['category_id'], User::info());
            if(!$category) {
                $smarty->display('403');
                Boot::shutdown();
            }
            $article->name = trim(strip_tags($_POST['name']));
            $article->content = $_POST['content'];
            $article->Category = $category;
            $search = array('/', ' ', '?', '&');
            $replace = array('_', '-', '.', '-');
            $article->alias = str_replace($search, $replace, strip_tags($_POST['alias']));
            $article->author = User::info('id');

            $article->save();

            import('system/share/network/redirect');
            $act = $id ? '编辑' : '添加新的';
            HTTPRedirect::flash_to('articles/detail/'.$article->id,
                            sprintf('%s %s 成功', $act, $category->name), $smarty);
        } else {
            $smarty->assign('categories', $categories);
            $smarty->display('article/add');
        }
    }

    /*
     * 文章详情
     */
    public function detail($id_or_alias) {
        $smarty = parent::load('smarty');
        parent::load('model', 'system/contrib/auth');
        parent::load('model', 'articles');

        if((int)$id_or_alias) {
            $article = ArticleTable::getInstance()->find($id_or_alias);
        } else {
            $article = ArticleTable::getInstance()->findByAlias($id_or_alias);
            $article = $article[0];
        }

        $article->content = stripslashes($article->content);
        
        $smarty->assign('page_title', $article->Category->name);
        $smarty->assign('article', $article);
        $smarty->display('article/detail');
    }

    public function delete($id) {
        parent::load('model', 'articles');
        parent::load('model', 'system/contrib/auth.User');
        $article = ArticleTable::getInstance()->find($id);
        /*
         * 判断是否有权限修改此类文章
         */
        $has_role = Category::has_role($article->Category->id, User::info());

        if(!$has_role || !User::has_role('人力资源') || !User::has_role('总经理')) {
            $this->smarty->display(403);
            Boot::shutdown();
        }

        if($article) {
            $article->delete();
            $message = '删除成功';
        } else {
            $message = '文章不存在';
        }
        
        import('system/share/network/redirect');
        HTTPRedirect::flash_to('', $message, $this->smarty);
    }

}


?>
