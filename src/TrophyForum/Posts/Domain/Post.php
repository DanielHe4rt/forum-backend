<?php

declare(strict_types = 1);

namespace TrophyForum\Posts\Domain;

use DateTime;
use Doctrine\ORM\PersistentCollection;
use Shared\Domain\ValueObject\Content;
use Shared\Domain\ValueObject\CreatedAt;
use Shared\Domain\ValueObject\Slug;
use Shared\Domain\ValueObject\Title;
use Shared\Domain\ValueObject\UpdatedAt;
use TrophyForum\Authors\Domain\Author;
use TrophyForum\SubForums\Domain\SubForum;

class Post
{
    private $id;
    private $subForum;
    private $author;
    private $title;
    private $content;
    private $isOpen;
    private $responses;
    private $slug;
    private $createdAt;
    private $updatedAt;

    public function __construct(
        PostId $id,
        SubForum $subForum,
        Author $author,
        Title $title,
        Content $content,
        PostIsOpen $isOpen,
        PersistentCollection $responses = null,
        Slug $slug,
        CreatedAt $createdAt,
        UpdatedAt $updatedAt
    ) {
        $this->id        = $id;
        $this->subForum  = $subForum;
        $this->author    = $author;
        $this->title     = $title;
        $this->content   = $content;
        $this->isOpen    = $isOpen;
        $this->responses = $responses;
        $this->slug      = $slug;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function create(
        PostId $id,
        SubForum $subForum,
        Author $author,
        Title $title,
        Content $content
    ): Post {
        $isOpen    = new PostIsOpen(true);
        $slug      = new Slug($title->value());
        $createdAt = new CreatedAt(new DateTime());
        $updatedAt = new UpdatedAt(new DateTime());

        return new self($id, $subForum, $author, $title, $content, $isOpen, null, $slug, $createdAt, $updatedAt);
    }

    public function id(): PostId
    {
        return $this->id;
    }

    public function subForum(): SubForum
    {
        return $this->subForum;
    }

    public function author(): Author
    {
        return $this->author;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function content(): Content
    {
        return $this->content;
    }

    public function isOpen(): PostIsOpen
    {
        return $this->isOpen;
    }

    public function responses(): ?PersistentCollection
    {
        return $this->responses;
    }

    public function slug(): Slug
    {
        return $this->slug;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    public function updateTitle(Title $title): void
    {
        $this->title     = $title;
        $this->updatedAt = new UpdatedAt(new DateTime());
    }

    public function updateContent(Content $content): void
    {
        $this->content   = $content;
        $this->updatedAt = new UpdatedAt(new DateTime());
    }
}
