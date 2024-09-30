<?php

declare(strict_types=1);

namespace Light\Page\Factory;

use Light\Page\Controller\PageController;
use Light\Page\Service\PageServiceInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;

class PageControllerFactory
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName): PageController
    {
        $pageService = $container->get(PageServiceInterface::class);
        assert($pageService instanceof PageServiceInterface);

        $router = $container->get(RouterInterface::class);
        assert($router instanceof RouterInterface);

        $template = $container->get(TemplateRendererInterface::class);
        assert($template instanceof TemplateRendererInterface);

        return new PageController($pageService, $router, $template);
    }
}
