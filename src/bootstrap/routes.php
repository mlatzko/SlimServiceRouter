<?php
/**
 * Routing of the application.
 *
 * @link      https://github.com/mlatzko/SlimRouter
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

$app->post('/{resource}', '\SlimRouter\Action\Create:dispatch');

$app->get('/{resource}', '\SlimRouter\Action\Discover:dispatch');
$app->get('/{resource}/{id}', '\SlimRouter\Action\Read:dispatch');

$app->patch('/{resource}/{id}', '\SlimRouter\Action\Update:dispatch');

$app->delete('/{resource}/{id}', '\SlimRouter\Action\Delete:dispatch');
