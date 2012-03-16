<?php
/**
 * Description of PostController
 *
 * @author Nemo.xiaolan
 * @created 2011-3-1 10:57:58
 */

class EditorController extends BaseApplication{

    public function upload() {
        import('system/share/io/datastream');
        import('system/share/io/filesystem');
        FileSystem::init();
        $http_path = FileSystem::Upload($_FILES['imgFile'], true);
        if(!$http_path) {
            $data = array(
                'error'=> 1,
                'message'=> FileSystem::$message
            );
        } else {
            $data = array(
                'error'=> 0,
                'url'=> $http_path
            );
        }

        
        
        echo Datastream::output('json', $data);
    }

    public function filemanager() {}

}

?>
