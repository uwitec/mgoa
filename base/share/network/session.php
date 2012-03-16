<?php
/**
 * Description of session
 *
 * @author Nemo.xiaolan
 * @created 2011-2-16 10:47:28
 */

class Session {

    static public $started = false;
    
    static public function start() {
        if(ini('base/SESSION/CUSTOM')) {
            if(ini('base/SESSION/SAVE') == 'file') {
                ini_set('session.save_path',
                        Package::get_folder(ini('base/SESSION/DIR')));
            }
        }

        @session_start();
        self::$started = true;
        
    }


}


?>
