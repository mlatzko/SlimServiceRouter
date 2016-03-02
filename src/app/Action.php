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
 * A binding of behavior and route to interact with the service.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
abstract class Action
{
    /**
     * Contains an object of the lightweight Noodlehaus config class.
     *
     * @var \Noodlehaus\ConfigInterface $config
     *
     * @link https://github.com/hassankhan/config
     */
    protected $config;

    /**
     * Contains PSR-3 logger provided by Monolog.
     *
     * @var \Psr\Log\LoggerInterface $logger
     *
     * @link https://github.com/Seldaek/monolog
     */
    protected $logger;

    /**
     * Contains Memcache mapper..
     *
     * @var \SlimRouter\Cache\Memcache $cache
     */
    protected $cache;

    /**
     * Constructor
     *
     * @param mixed $config Either null of a instance of the config.
     * @param mixed $logger Either null of a instance of the logger.
     * @param mixed $adapter Either null of a instance of the adapter.
     */
    public function __construct($config = NULL, $logger = NULL, $cache = NULL)
    {
        if(NULL !== $config){
            $this->setConfig($config);
        }

        if(NULL !== $logger){
            $this->setLogger($logger);
        }

        if(NULL !== $cache){
            $this->setCache($cache);
        }
    }

    /**
     * Set config.
     *
     * @param \Noodlehaus\ConfigInterface $config Instance of \Noodlehaus\ConfigInterface class.
     */
    public function setConfig(\Noodlehaus\ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Set logger.
     *
     * @param \Noodlehaus\ConfigInterface $logger Instance of an class \Psr\Log\LoggerInterface.
     */
    public function setLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Set cache.
     *
     * @param \SlimRouter\Cache $cache Instance of an class \SlimRouter\Cache.
     */
    public function setCache(\SlimRouter\Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * This method needs to implemented by all action classes.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    abstract public function dispatch($request, $response, $args);
}
