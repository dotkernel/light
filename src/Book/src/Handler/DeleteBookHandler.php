<?php

namespace Light\Book\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Light\Book\Entity\Book;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteBookHandler implements RequestHandlerInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $uuid = $request->getAttribute('uuid');

        if (!$uuid) {
            return new JsonResponse([
                'error' => 'UUID is required'
            ], 400);
        }

        // Find the book by UUID
        $book = $this->entityManager
            ->getRepository(Book::class)
            ->find($uuid);

        if (!$book) {
            return new JsonResponse([
                'error' => 'Book not found'
            ], 404);
        }

        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => "Book $uuid deleted successfully"
        ]);
    }
}