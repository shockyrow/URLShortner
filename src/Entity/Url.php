<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UrlRepository")
 */
class Url implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $session_id;

    /**
     * @ORM\Column(type="text")
     */
    private $real_url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $short_url;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $hash;

    /**
     * @ORM\Column(type="bigint")
     */
    private $views;

    public function __construct()
    {
        $this->views = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionId(): ?string
    {
        return $this->session_id;
    }

    public function setSessionId(?string $session_id): self
    {
        $this->session_id = $session_id;

        return $this;
    }

    public function getRealUrl(): ?string
    {
        return $this->real_url;
    }

    public function setRealUrl(string $real_url): self
    {
        $this->real_url = $real_url;

        return $this;
    }

    public function getShortUrl(): ?string
    {
        return $this->short_url;
    }

    public function setShortUrl(?string $short_url): self
    {
        $this->short_url = $short_url;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'real_url' => $this->getRealUrl(),
            'short_url' => $this->getShortUrl(),
            'hash' => $this->getHash(),
            'session_id' => $this->getSessionId(),
            'views' => $this->getViews(),
        ];
    }
}
