<?php
/**
 * Description of package
 *
 * @author Nemo.xiaolan
 * @created 2011-1-19 19:04:14
 */

class Package{

    
    static public $includes = array();

    static public $split = '/';

    static public $ignore = array(
        '.svn', '.git', '.', '..', '.gitignore'
    );

    /*
     * Package::import()
     * @param string $path | like 'system/share/package'
     * @param string $ext
     * @return void
     *
     * @shortcut import()
     * <code>
     *
     * </code>
     */
    static public function import($path, $ext='php'){
        $path = self::get_contrib_real_path($path);
        $paths = explode(self::$split, $path);

        $included = get_included_files();
        $included = $included ? $included : array();

        if(is_file($path) && !in_array($path, $included)) {
            require($path);
            return;
        }

        /*
         * 导入所有"Package"
         */
        if(end($paths) == '*') {
            array_pop($paths);
            if($paths[0] == 'system') {
                array_shift($paths);
                $dir = FM_DIR.DS.implode(DS, $paths);
            } else {
                $dir = BASE_DIR.DS.implode(DS, $paths);
            }
            if(!is_dir($dir)) {
                throw new DoesNotExistsException(1002, $dir);
            }
            $dir_handle = @opendir($dir);
            if(!$dir_handle) {
                throw new DoexNotExistsException(1002, $dir);
            }
            
            while(($file = readdir($dir_handle)) !== false) {

                if(in_array($file, self::$ignore)) {
                    continue;
                }

                $file_name_array = explode('.', $file);
                $_ext = end($file_name_array);
                if(is_array($ext)) {
                    if(!in_array($_ext, $ext)) {
                        continue;
                    }
                } elseif($ext != '*') {
                    if($_ext != $ext) {
                        continue;
                    }
                }
                
                $file_path = $dir.DS.$file;
                if(in_array($file_path, $included)) {
                    continue;
                } else {
                    array_push(self::$includes, $file_path);
                    if(!is_file($file_path)){
                        throw new DoexNotExistsException(1001, $file_path);
                    }
                    require $file_path;
                }
            }

            @closedir($dir_handle);

        } else {
            $file_path = self::get_file($path, $ext);
            
            if(!in_array($file_path, $included)) {
                array_push(self::$includes, $file_path);
                if(!is_file($file_path)) {
                    throw new DoesNotExistsException(1001, $file_path);
                }
                require $file_path;
            }
        }
        
        

        return true;
    }


    static public function get_folder($path) {
        $path = self::get_contrib_real_path($path);
        $paths = explode(self::$split, $path);
        if($paths[0] == 'system') {
            array_shift($paths);
            $file_path = FM_DIR.DS.implode(DS, $paths);
        } else {
            $file_path = BASE_DIR.DS.implode(DS, $paths);
        }
        return $file_path;
    }

    static public function get_file($path, $ext='php') {
        if(is_file($path)) {
            return $path;
        }
        
        
        $path = self::get_contrib_real_path($path);
        
        $paths = explode(self::$split, $path);
        if($paths[0] == 'system') {
            array_shift($paths);
            $file_path = FM_DIR.DS.implode(DS, $paths).'.'.$ext;
        } else {
            $file_path = BASE_DIR.DS.implode(DS, $paths).'.'.$ext;
        }
        
        return $file_path;
    }
    
    static public function get_contrib_real_path($path) {
        $search = array(
        	sprintf('applications%ssystem%scontrib', self::$split, self::$split),
        	sprintf('project%ssystem%scontrib', self::$split, self::$split)
        );
        return str_replace($search, 
            sprintf('system%scontrib', self::$split), $path);
    }
    
}


?>
