<?php
/**
 * Interface CacheInterface
 *
 * Unify the diffrent cache backend interface
 * To get the instance, use CacheBackend::get_instance()
 *
 * @author Nemo.xiaolan
 * @created 2011-1-21 16:43:41
 */

interface CacheInterface {

    /*
     * Cache::get()
     *
     * @param $cache_id string
     * @return mixed
     *
     * Get the cached data by $cache_id
     * 
     * <code>
     *  $data = $cache->get('key');
     * </code>
     */
    public function get($cache_id);

    /*
     * Cache::set()
     *
     * @param $cache_id string
     * @param $value mixed
     * @param $life integer | seconds
     * @return boolean
     *
     * add/update the cache(d) data by $cache_id
     *
     * <code>
     *  $cache->set('key', $data, 3600);
     * </code>
     */
    public function set($cache_id, $value, $life = null);

    /*
     * Cache::is_cached()
     *
     * @param $cache_id string
     * @return boolean
     *
     * return is the $cache_id has been cached
     */
    public function is_cached($cache_id);

    /*
     * Cache::delete()
     *
     * @param $cache_id
     * @return boolean
     *
     * Unset the cached data by $cache_id
     */
    public function delete($cache_id);

    /*
     * Cache::flush()
     * @return boolean
     *
     * Flush all cached data.
     */
    public function flush();

}

?>
