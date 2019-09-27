<?php

namespace App\Service;

interface HashGeneratorInterface
{
    public function generate($text): string;
}
