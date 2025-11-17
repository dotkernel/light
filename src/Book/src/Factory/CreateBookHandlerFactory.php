<?php

namespace Light\Book\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Light\Book\Handler\CreateBookHandler;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class CreateBookHandlerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName): CreateBookHandler
    {
        $template = $container->get(EntityManagerInterface::class);
        assert($template instanceof EntityManagerInterface);

        return new CreateBookHandler($template);
    }
}