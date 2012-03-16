<?php
/**
 * Description of memcache
 *
 * @author Nemo.xiaolan
 * @created 2011-1-21 16:43:41
 */
class Memcache extends CacheBackend implements CacheInterface {

    public $config = array();
    public $instance;

    public function __construct(array $config = null) {
        parent::__construct($config);
        $this->instance = new Memcached();

        if($config['nodes'] && is_array($config['nodes'])) {
            foreach($config['nodes'] as $node) {
                $this->instance->addServer($node['host'], $node['port']);
            }
        }

        if(!($this->instance instanceof Memcached)) {
            throw new CacheException(1006, 'memcache');
        }
    }

    public function get($cache_id) {
        return $this->instance->get($cache_id);
    }

    public function set($cache_id, $value, $life = null) {
        $life = $life ? (int)$life : self::$config['life'];
        return $this->instance->set($cache_id, $value, $life);
    }

    public function is_cached($cache_id) {
        return $this->instance->get($cache_id) ? true : false;
    }

    public function delete($cache_id) {
        return $this->instance->delete($cache_id);
    }

    public function flush() {
        return $this->instance->flush();
    }

}
?>
