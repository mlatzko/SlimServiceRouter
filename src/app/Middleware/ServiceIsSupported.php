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
 * Checking if the resource request is configured in the configuration. If not
 * it is a not supported resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class ServiceIsSupported extends Middleware
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $args = $this->getRouteArguments($request);

        if(FALSE === empty($args)){
            $entity = $this->config->get('services.' . $args['resource']);

            if(NULL !== $entity){
                $response = $next($request, $response);
                return $response;
            }
        }

        $responseData = array('status' => 'error', 'content' => 'For the provided resource no service is found!');
        return $response->withJson($responseData, 404);
    }
}
