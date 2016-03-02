<?php
/**
 * Slim Router
 *
 * @link      https://github.com/mlatzko/SlimRouter
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimRouter;

/**
 * Memcache wrapper.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @link http://php.net/manual/de/book.memcache.php
 */
class Cache
{
    /**
     * Contains an instance of Memcache.
     * @var \Memcache $cache
     */
    private $cache = NULL;

    public function __construct($cache = NULL)
    {
        if(NULL !== $cache){
            $this->setAdapter($cache);
        }
    }

    /**
     * Set cache adapter.
     *
     * @param \Memcache $cache
     */
    public function setAdapter(\Memcache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Add a Memcache server.
     *
     * @param string $host
     * @param integer $port
     * @param boolean $persistent
     * @param integer $weight
     *
     * @link http://php.net/manual/de/memcache.addserver.php
     */
    public function addServer($host, $port, $persitent = TRUE, $weight = 40)
    {
        $this->cache->addServer($host, $port, $persitent, $weight);
    }

    /**
     * Stores a key/value pair in the cache.
     *
     * @param string $key
     * @param mixed $value
     * @param integer $ttl Time to live in seconds.
     *
     * @link http://php.net/manual/de/memcache.set.php
     */
    public function set($key, $value, $ttl)
    {
        $result = $this->cache->set($key, $value, MEMCACHE_COMPRESSED, $ttl);

        return $result;
    }

    /**
     * Retrieve value for an given key from the cache.
     *
     * @param string $key
     *
     * @link http://php.net/manual/de/memcache.get.php
     */
    public function get($key)
    {
        $value = $this->cache->get($key);

        return $value;
    }

    /**
     * Delete an entry from the cache.
     *
     * @param string $key Id of the cache
     *
     * @link http://php.net/manual/de/memcache.delete.php
     */
    public function delete($key)
    {
        $result = $this->cache->delete($key);

        return $result;
    }
}

