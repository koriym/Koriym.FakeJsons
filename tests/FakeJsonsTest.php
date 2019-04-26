<?php

declare(strict_types=1);

namespace Koriym\FakeJsons;

use JsonSchema\Validator;
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

    public function testInvoke() : void
    {
        ($this->fakeJsons)(__DIR__ . '/Fake/src', __DIR__ . '/Fake/dist', 'http://example.com/schema');
        $validator = new Validator;
        $data = json_decode((string) file_get_contents(__DIR__ . '/Fake/dist/signup.json'));
        $validator->validate($data, (object) ['$ref' => 'file://' . __DIR__ . '/Fake/src/signup.json']);
        foreach ($validator->getErrors() as $error) {
            echo sprintf("[%s] %s\n", $error['property'], $error['message']);
        }
        $this->assertTrue($validator->isValid());
    }
}
