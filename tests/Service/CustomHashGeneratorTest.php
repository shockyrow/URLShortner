<?php

namespace App\Tests\Service;

use App\Service\CustomHashGenerator;
use App\Service\HashGeneratorInterface;
use PHPUnit\Framework\TestCase;

class CustomHashGeneratorTest extends TestCase
{
    /**
     * @var HashGeneratorInterface
     */
    private $hashGenerator;

    public function setUp()
    {
        parent::setUp();

        $this->hashGenerator = new CustomHashGenerator();
    }

    /**
     * @dataProvider provideTestGenerateReturnsCorrectHash
     *
     * @param string $expected
     * @param string $text
     */
    public function testGenerateReturnsCorrectHash(string $expected, string $text)
    {
        $this->assertEquals($expected, $this->hashGenerator->generate($text));
    }

    public function provideTestGenerateReturnsCorrectHash()
    {
        $texts = [
            'test1',
            'test2',
            'test3',
        ];

        $data = [];

        foreach ($texts as $text) {
            $data[] = [
                sha1($text) . md5($text),
                $text
            ];
        }

        return $data;
    }
}
