<?php

namespace App\Service;

use Symfony\Component\Routing\RouterInterface;

class CustomShortUrlGenerator implements ShortUrlGeneratorInterface
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var string
     */
    private $chars;
    /**
     * @var string
     */
    private $length;

    public function __construct(
        RouterInterface $router,
        string $chars,
        string $length
    ) {
        $this->router = $router;
        $this->chars = $chars;
        $this->length = $length;
    }

    public function generate(int $id): string
    {
        $text = '';

        for ($i = 0; $i < $this->length; $i++) {
            $text = $this->chars[$id % strlen($this->chars)] . $text;
            $id = (int)($id / strlen($this->chars));
        }

        return $this->router->generate('url_view', ['id' => $text]);
    }
}
