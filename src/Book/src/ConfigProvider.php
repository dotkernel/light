<?php

namespace Light\Book;

use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Light\Book\Factory\CreateBookHandlerFactory;
use Light\Book\Factory\DeleteBookHandlerFactory;
use Light\Book\Factory\ListBookHandlerFactory;
use Light\Book\Factory\UpdateBookHandlerFactory;
use Light\Book\Handler\CreateBookHandler;
use Light\Book\Handler\DeleteBookHandler;
use Light\Book\Handler\ListBooksHandler;
use Light\Book\Handler\UpdateBookHandler;
use Mezzio\Application;

class ConfigProvider
{

    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine'     => $this->getDoctrineConfig(),
        ];
    }

    private function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
                ],
            ],
            'factories'  => [
                CreateBookHandler::class => CreateBookHandlerFactory::class,
                ListBooksHandler::class  => ListBookHandlerFactory::class,
                UpdateBookHandler::class => UpdateBookHandlerFactory::class,
                DeleteBookHandler::class => DeleteBookHandlerFactory::class,
            ]
        ];
    }

    private function getDoctrineConfig(): array
    {
        return [
            'driver' => [
                'orm_default'   => [
                    'drivers' => [
                        'Light\Book\Entity' => 'BookEntities',
                    ],
                ],
                'BookEntities' => [
                    'class' => AttributeDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
        ];
    }
}