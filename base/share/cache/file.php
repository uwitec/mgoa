<?php
/**
* Description of file
*
* @author Nemo.xiaolan
* @created 2011-1-21 16:43:41
*/
class File extends CacheBackend implements CacheInterface {

    public function check_available() {
        if(!$this->config['cache_dir']) {
            $this->error_message = $this->config['cache_dir'];
            return 1004;
        }
        $cache_dir = Package::get_folder($this->config['cache_dir']);
        if(!is_writable($cache_dir)) {
            $this->error_message = $this->config['cache_dir'];
            return 1005;
        }

        return true;
    }
    public function get($cache_id) {

    }

    public function set($cache_id, $value, $life = null) {

    }

    public function is_cached($cache_id) {

    }

    public function delete($cache_id) {

    }

    public function flush() {
        
    }

}
?>
