<?php

namespace App\Service;

interface ShortUrlGeneratorInterface
{
    public function generate(int $id): string;
}
