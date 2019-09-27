<?php

namespace App\Service;

class CustomHashGenerator implements HashGeneratorInterface
{
    public function generate($text): string
    {
        return sha1($text) . md5($text);
    }
}
