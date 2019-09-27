<?php

namespace App\Tests\Service;

use App\Service\CustomShortUrlGenerator;
use App\Service\ShortUrlGeneratorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\RouterInterface;

class CustomShortUrlGeneratorTest extends TestCase
{
    const SHORT_URL_CHARS = '01';
    const SHORT_URL_LENGTH = 8;
    const EXAMPLE_URL = 'example_url';

    /**
     * @var ShortUrlGeneratorInterface
     */
    private $shortUrlGenerator;
    /**
     * @var MockObject|RouterInterface
     */
    private $mockedRouter;

    public function setUp()
    {
        $this->mockedRouter = $this->createMock(RouterInterface::class);

        $this->shortUrlGenerator = new CustomShortUrlGenerator(
            $this->mockedRouter,
            self::SHORT_URL_CHARS,
            self::SHORT_URL_LENGTH
        );

        $this->mockedRouter
            ->method('generate')
            ->with($this->anything(), $this->anything())
            ->willReturn(self::EXAMPLE_URL)
        ;
    }

    /**
     * @dataProvider provideTestGenerateRunsCorrectly
     *
     * @param int $id
     */
    public function testGenerateRunsCorrectly(int $id)
    {
        $this->mockedRouter
            ->expects($this->exactly(1))
            ->method('generate')
            ->withAnyParameters()
        ;

        $this->shortUrlGenerator->generate($id);
    }

    public function provideTestGenerateRunsCorrectly()
    {
        $data = [];

        foreach (range(1, 10) as $value) {
            $data[] = [ rand(0,100) ];
        }

        return $data;
    }
}
