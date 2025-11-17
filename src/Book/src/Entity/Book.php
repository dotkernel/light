<?php

declare(strict_types=1);

namespace Light\Book\Entity;

use Doctrine\ORM\Mapping as ORM;
use Light\App\Entity\AbstractEntity;
use Light\App\Entity\TimestampsTrait;

#[ORM\Entity]
#[ORM\Table(name: 'books')]
#[ORM\HasLifecycleCallbacks]
class Book extends AbstractEntity
{
    use TimestampsTrait;

    #[ORM\Column(name: 'title', type: 'string', length: 500, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(name: 'author', type: 'string', length: 500, nullable: true)]
    private ?string $author = null;

    public function __construct()
    {
        parent::__construct();

        $this->created();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }
}
