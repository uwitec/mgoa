<?php
/**
 * Description of xcache
 *
 * @author Nemo.xiaolan
 * @created 2011-1-21 16:43:41
 */

class Xcache extends CacheBackend implements CacheInterface {

    public function get($cache_id) {
        return false;
        return xcache_get($cache_id);
    }

    public function set($cache_id, $value, $life = null) {
        return false;
        $life = $life ? (int)$life : self::$config['life'];
        return xcache_set($cache_id, $value, $life);
    }

    public function is_cached($cache_id) {
        return false;
        return xcache_isset($cache_id);
    }

    public function delete($cache_id) {
        return xcache_unset($cache_id);
    }

    public function flush() {
        return @xcache_clear_cache(XC_TYPE_VAR,0);
    }

}
?>
