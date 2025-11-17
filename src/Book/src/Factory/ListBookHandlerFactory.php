<?php

namespace Light\Book\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Light\Book\Handler\CreateBookHandler;
use Light\Book\Handler\ListBooksHandler;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ListBookHandlerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName): ListBooksHandler
    {
        $template = $container->get(EntityManagerInterface::class);
        assert($template instanceof EntityManagerInterface);

        return new ListBooksHandler($template);
    }
}