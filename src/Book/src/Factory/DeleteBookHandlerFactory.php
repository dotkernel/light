<?php

namespace Light\Book\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Light\Book\Handler\CreateBookHandler;
use Light\Book\Handler\DeleteBookHandler;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class DeleteBookHandlerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName): DeleteBookHandler
    {
        $template = $container->get(EntityManagerInterface::class);
        assert($template instanceof EntityManagerInterface);

        return new DeleteBookHandler($template);
    }
}