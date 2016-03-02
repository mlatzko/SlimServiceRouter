<?php
/**
 * Slim Router
 *
 * @link      https://github.com/mlatzko/SlimRouter
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimRouter\Middleware;

use \SlimRouter\Middleware;

/**
 * Configure action classes.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class ActionBuilder extends Middleware
{
    /**
     * Register actions.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $this->registerActions();

        $response = $next($request, $response);

        return $response;
    }

    /**
     * Register all actions classes supported into the Slim\Container for
     * later usage.
     */
    private function registerActions()
    {
        $actions = array('create', 'read', 'discover', 'update', 'delete');

        foreach ($actions as $action) {
            $className = '\SlimRouter\Action\\' . ucfirst($action);

            $class = new $className();

            $class->setConfig($this->container->get('config'));
            $class->setLogger($this->container->get('logger'));
            $class->setCache($this->container->get('cache'));

            $this->container[$className] = $class;
        }
    }
}
