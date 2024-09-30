<?php

declare(strict_types=1);

namespace Light\Page;

use Light\Page\Controller\PageController;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

use function assert;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        $app = $callback();
        assert($app instanceof Application);

        $app->get('/', [PageController::class], 'home');

        $app->get('/page[/{action}]', [PageController::class], 'page');

        return $app;
    }
}
