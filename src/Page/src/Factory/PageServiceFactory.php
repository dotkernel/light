<?php

declare(strict_types=1);

namespace Light\Page\Factory;

use Light\Page\Service\PageService;
use Light\Page\Service\PageServiceInterface;
use Psr\Container\ContainerInterface;

class PageServiceFactory
{
    public function __invoke(ContainerInterface $container, string $requestedName): PageServiceInterface
    {
        return new PageService();
    }
}
