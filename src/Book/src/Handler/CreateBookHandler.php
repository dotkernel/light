<?php

declare(strict_types=1);

namespace Light\Book\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Light\Book\Entity\Book;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreateBookHandler implements RequestHandlerInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $newBook = new Book();
        $newBook->setAuthor("PHP developer");
        $newBook->setTitle("Doctrine is very cool");

        $this->entityManager->persist($newBook);
        $this->entityManager->flush();

        return new JsonResponse(
            "Book created!",
        );
    }
}
