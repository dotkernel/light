<?php

namespace Light\Book\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Light\Book\Handler\CreateBookHandler;
use Light\Book\Handler\UpdateBookHandler;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class UpdateBookHandlerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName): UpdateBookHandler
    {
        $template = $container->get(EntityManagerInterface::class);
        assert($template instanceof EntityManagerInterface);

        return new UpdateBookHandler($template);
    }
}