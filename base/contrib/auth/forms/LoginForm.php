<?php
/*
 * File: login_form.php
 * 
 * Encoding: UTF-8
 * Created on: Feb 12, 2011 8:10:00 PM
 *
 * @author: xiaolan
 *
 * License:
 *
 * 
 * 
 *
 * Description:
 *  Change this.
 *
 */

class LoginForm extends BaseForm {

    public $fields = array();

    public $data   = array();
    
    public $form_name = 'LoginForm';

    public function set_up($smarty) {
        /*
         * Load the forms style
         */
        import('system/share/web/statics');
        $smarty->append_tpl_var('extra_statics', 
                            Statics::load('yaml/screen/forms', 'css'));
        
        Statics::load_lte('html5/jquery.html5forms', 'js', 9);
        $code = <<<EOF
            <script type="text/javascript">
                $(function(){
                    $('#login-form').html5form({
                        'async': false,
                        'messages': 'en',
                        'responseDiv': '#header'
                    });
                });
            </script>
EOF;
        Statics::lte_code($code, 9);
        
    }
    
}

    

?>
