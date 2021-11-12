<?php

namespace Tests\Entity;

class Quotes
{
    private $id;
    private $quote;
    private $author;
    private $route;

    public function getId(): ?int {
        return $this->id;
    }
    public function getQuote(): ?string {
        return $this->quote;
    }
    public function setQuote(string $quote): self {
        $this->quote = $quote;
        return $this;
    }
    public function getAuthor(): ?string {
        return $this->author;
    }
    public function setAuthor(string $author): self {
        $this->author = $author;
        return $this;
    }
    public function getRoute(): ?string {
        return $this->route;
    }
    public function setRoute(string $route): self {
        $this->route = $route;
        return $this;
    }
}
