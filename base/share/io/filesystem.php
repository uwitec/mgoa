<?php
/**
 * Description of io
 *
 * @author Nemo.xiaolan
 * @created 2011-1-27 13:29:35
 */

class FileSystem {
    
    //file array
    static private $file;

    //settings
    static private $config;

    static private $is_img;

    static public $http_path;

    //the path to save to db or other position.
    static public  $save_path;

    //attachments save dir
    static private $attachment_dir;

    static public $instance;

    static public $_filename;

    static public $fileNewName;

    static public $pathinfo;

    static public $local_path;

    static public $message;

    static public function init($config = null){
        if($config) {
            self::$config = $config;
        } else {
            self::$config = ini('base/attachment');
        }
        self::$attachment_dir = Package::get_folder(self::$config['attachment_dir']);
    }

    /**
    * @name Upload
    * @param [array] $file
    * @return [boolean]
    * @todo upload file
    * */
    static public function Upload($file,$is_img = true,$filename=NULL){
        self::$is_img = $is_img;
        self::$file = $file;
        self::$_filename = $filename;
        if(!$file)
        {
            return false;
        }
        return self::MoveUploadFile();
    }

    /**
    * @name MoveUploadFile
    * @todo move upload file / files
    * */
    static private function MoveUploadFile(){
        if(!self::$file['tmp_name']) {
            self::$message = '没有上传文件';
            return false;
        }
        if(is_array(self::$file['tmp_name'])){
            $length = count(self::$file['tmp_name']);
            for($i=0;$i<$length;$i++){
                if(!self::checkAllowType(self::$file['tmp_name'][$i])){
                    return false;
                }
                $local_path = self::getNewFilePath(self::$file['name'][$i]);
                self::$save_path = $local_path;
                if(is_file($local_path))
                {
                    self::$save_path = $local_path = self::getNewFilePath(self::$file['name'][$i],true);
                }
                $tmp_result = move_uploaded_file(self::$file['tmp_name'][$i],$local_path);
                @chmod($local_path,0755);
                if(!$tmp_result){
                    return false;
                }
            }
            return true;
        }
        else
        {
            if(!self::checkAllowType(self::$file['tmp_name']))
            {
                return false;
            }

            self::$local_path = self::getNewFilePath(self::$file['name']);
            self::$save_path = $local_path;
            if(is_file($local_path))
            {
                self::$save_path = self::$local_path = self::getNewFilePath(self::$file['name'],true);
            }
            
            $tmp_result = move_uploaded_file(self::$file['tmp_name'], self::$local_path);
            self::$pathinfo = pathinfo(self::$local_path);
            return self::$http_path;
        }
    }

    static public function checkAllowType($fileName){
        if(self::$is_img){
            $array = self::$config['allow_type']['image'];
        }else{
            $array = self::$config['allow_type']['other'];
        }

        if(!is_array($array)) {
            self::$message = '不支持的文件类型';
            return false;
        }
        
        $mime = mime_content_type($fileName);
        if(in_array($mime, $array) || !$mime){
            return true;
        }
        
        self::$message = '不支持的文件类型'.$mime;
        return false;
    }

    /**
    * @name getNewFilePath
    * @todo get uploaded file path
    * @param [string] $file_name //$_FILES['tmp_name']
    * */
    static private function getNewFilePath($file_name,$repeat=false){
        $name = self::setNewFileName($file_name,$repeat);
        $attachment_folder = self::$attachment_dir.DS;
        $http_path = ini('base/BASE_URL').str_replace(BASE_DIR.'\\', '', self::$attachment_dir).'/';
        switch(self::$config['attachment_save_type']){
            case 1:
                $attachment_folder.=date("Y_m_d");
                $http_path.=date("Y_m_d");
                break;
            default:
                $attachment_folder.=date("Y_m");
                $http_path.=date("Y_m");
                break;
        }
        if(!is_dir($attachment_folder))
        {
            mkdir($attachment_folder);
        }
        @chmod($attachment_folder,0755);
        self::$http_path = $http_path.'/'.$name;
        return $attachment_folder.DS.$name;
    }

    /**
    * @name setNewFileName
    * @todo set uploaded new file name
    * @param [string] $file_name //$_FILES['tmp_name']
    * */
    static private function setNewFileName($file_name,$repeat=false){
        $pathinfo = pathinfo($file_name);
        if(self::$_filename)
        {
            return self::$fileNewName = self::$_filename;
        }
        switch(self::$config["how_to_named"])
        {
            case 1:
                #make random
                self::$fileNewName = substr(md5(time().$file_name),0,24).'.'.$pathinfo['extension'];
                break;
            default:
                #keep old
                $tmp = str_ireplace(".".$pathinfo['extension'],'',$file_name);
                if($repeat)
                {
                    $tmp .= "_".date("Y_m_d_H_i_s");
                }

                self::$fileNewName = $tmp.".".$pathinfo['extension'];
                break;
        }
        return self::$fileNewName;
    }


    /**
    * @name CreateFile
    * @todo create a new file.
    * @param [string] $filepath
    * @param [data]   $content
    * @return [boolean]
    * */
    static public function CreateFile($filePath,$content){
        $fileHandler = fopen($filePath,'w');
        if($fileHandler){
            if(fwrite($fileHandler,$content)){
                fclose($fileHandler);
                return true;
            }
            return false;
        }
        return false;
    }

    /**
    * @name DelFile
    * @todo unlink file
    * @param [string] $filepath //unlink one file
    * @param [string] $folder  //unlink all file in this folder
    * @param [boolean] $doNotRmDir = true // will remove directory or not
    * @return [boolean]
    * */
    static public function DelFile($filePath="",$folder="",$doNotRmDir=true){
        if($filePath && !$folder){
            return unlink($filePath) ? true : false;
        }elseif(!$filePath && $folder){
            $files = scandir($folder);
            foreach($files as $value){
                $fullPath = $folder.DS.$value;
                if($value != '.' && $value != '..'){
                    if(is_dir($fullPath)){
                        if($doNotRmDir){
                            self::$DelFile('',$fullPath);
                        }else{
                            @rmdir($fullPath);
                        }
                    }else{
                        if(!unlink($fullPath)){
                            return false;
                        }
                    }
                }
            }
            return true;
        }else{
            return false;
        }
    }

    /**
    * @name ReadFile
    * @todo read file by fopen
    * @param [string] $filepath
    * @return [string] $content || False
    * */
    static public function ReadFile($filePath){
        if($filePath){
            $handle = fopen($filePath,'r');
            $content = fread($handle,filesize($filePath));
            fclose($handle);
            return $content;
        }
        return false;
    }
    

    static public function cat($filename, $ext='php') {
        $filename = Package::get_file($filename);
        if(!is_file($filename) || !is_readable($filename)) {
            return false;
        }

        return file_get_contents($filename);
    }

    static public function write($path, $content, $ext='php') {
        $path = Package::get_file($path, $ext);
        return @file_put_contents($path, $content);
    }

}


?>
