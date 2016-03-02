<?php
/**
 * Here you can add middleware you require while the application
 * is executed.
 *
 * @link      https://github.com/mlatzko
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

$app->add(
    new SlimRouter\Middleware\ActionBuilder(
        $app->getContainer()->get('config'),
        $app->getContainer()->get('logger'),
        $app->getContainer()
    )
);

$app->add(
    new SlimRouter\Middleware\ServiceIsSupported(
        $app->getContainer()->get('config'),
        $app->getContainer()->get('logger'),
        $app->getContainer()
    )
);
