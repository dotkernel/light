<?php

declare(strict_types=1);

namespace Light\Book;

use Light\Book\Handler\CreateBookHandler;
use Light\Book\Handler\DeleteBookHandler;
use Light\Book\Handler\ListBooksHandler;
use Light\Book\Handler\UpdateBookHandler;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

use function assert;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        $app = $callback();
        assert($app instanceof Application);

        $app->get('/books/create', [CreateBookHandler::class], 'books::create');
        $app->get('/books/list', [ListBooksHandler::class], 'books::list');

        $app->get('/books/update/{uuid}', [UpdateBookHandler::class], 'books::update');
        $app->get('/books/delete/{uuid}', [DeleteBookHandler::class], 'books::delete');

        return $app;
    }
}
