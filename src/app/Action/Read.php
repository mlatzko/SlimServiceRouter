<?php
/**
 * Slim Router
 *
 * @link      https://github.com/mlatzko/SlimRouter
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimRouter\Action;

use \SlimRouter\Action;

/**
 * Behavior of reading a resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class Read extends Action
{
    /**
     * Read resource.
     */
    public function dispatch($request, $response, $args)
    {
        $attributes = $request->getAttributes();
        $route      = $attributes['route']->getArguments();

        $serviceUrl = $this->config->get('services.' . $route['resource'] . '.url');
        $requestUrl = $serviceUrl . '/' . $route['id'];

        // get response from cache
        $responseService = $this->cache->get($requestUrl);

        if(FALSE === $responseService instanceof \Httpful\Response){
            try {
                $responseService = \Httpful\Request::get($requestUrl)->sendIt();

                // store response in cache
                $this->cache->set(
                    $requestUrl, 
                    $responseService, 
                    $this->config->get('cache.request.timeToLive')
                );
            } catch (\Exception $e) {
                $responseData = array(
                    'status'  => 'error', 
                    'content' => 'The service is not available!'
                );

                return $response
                    ->withJson($responseData, 500);
            }
        }

        return $response
            ->withJson((array)$responseService->body, $responseService->code);
    }
}
