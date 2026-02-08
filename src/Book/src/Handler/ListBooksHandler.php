<?php

declare(strict_types=1);

namespace Light\Book\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Light\Book\Entity\Book;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_map;

class ListBooksHandler implements RequestHandlerInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $books = $this->entityManager
            ->getRepository(Book::class)
            ->findAll();

        $data = array_map(function (Book $book) {
            return [
                'id'     => $book->getUuid()->toString(),
                'title'  => $book->getTitle(),
                'author' => $book->getAuthor(),
            ];
        }, $books);

        return new JsonResponse($data);
    }
}
