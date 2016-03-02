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
 * Behavior of reading a resources.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class Discover extends Action
{
    /**
     * Discover resources.
     */
    public function dispatch($request, $response, $args)
    {
        $attributes = $request->getAttributes();
        $route      = $attributes['route']->getArguments();
        $params     = $request->getQueryParams();

        $serviceUrl = $this->config->get('services.' . $route['resource'] . '.url');
        $requestUrl = (FALSE === empty($params)) ? $serviceUrl . '?' . http_build_query($params, 0, '&', PHP_QUERY_RFC3986) : $serviceUrl ;

        try {
            $responseService = \Httpful\Request::get($requestUrl)->sendIt();
        } catch (\Exception $e) {
            $responseData = array(
                'status'  => 'error', 
                'content' => 'The service is not available!'
            );

            return $response
                ->withJson($responseData, 500);
        }

        return $response
            ->withJson((array)$responseService->body, $responseService->code);
    }
}
