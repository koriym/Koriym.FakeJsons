<?php

declare(strict_types=1);

namespace Koriym\FakeJsons;

use PHPUnit\Framework\TestCase;

class FakeJsonsTest extends TestCase
{
    /**
     * @var FakeJsons
     */
    protected $fakeJsons;

    protected function setUp() : void
    {
        $this->fakeJsons = new FakeJsons;
    }

    public function testIsInstanceOfFakeJsons() : void
    {
        $actual = $this->fakeJsons;
        $this->assertInstanceOf(FakeJsons::class, $actual);
    }
}
