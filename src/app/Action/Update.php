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
 * Behavior of updating a resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class Update extends Action
{
    /**
     * Read resource.
     */
    public function dispatch($request, $response, $args)
    {
        $requestData = $request->getParsedBody();
        $attributes  = $request->getAttributes();
        $route       = $attributes['route']->getArguments();

        $serviceUrl = $this->config->get('services.' . $route['resource'] . '.url');
        $requestUrl = $serviceUrl . '/' . $route['id'];

        // remove entry from cache
        $this->cache->delete($requestUrl);

        try {
            $responseService = \Httpful\Request::patch($requestUrl)
                ->addHeader('Content-Type', 'application/json;charset=utf-8')
                ->body(json_encode($requestData))
                ->send();
        } catch (\Exception $e) {
            $responseData = array(
                'status'  => 'error', 
                'content' => 'The service is not available!'
            );

            return $response
                ->withJson($responseData, 500);
        }

        if(FALSE === empty($responseService->body)){
            return $response
                ->withJson((array)$responseService->body, $responseService->code);
        }

        return $response
            ->withStatus($responseService->code);
    }
}
