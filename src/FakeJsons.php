<?php

declare(strict_types=1);

namespace Koriym\FakeJsons;

use JSONSchemaFaker\Faker;

final class FakeJsons
{
    public function __invoke(string $schemaDir, string $distDir, string $schemaUri) : void
    {
        $faker = new Faker($schemaDir);
        foreach ($this->files($schemaDir, 'json') as $fileInfo) {
            /** @var \SplFileInfo $fileInfo */
            $schemaPath = $fileInfo->getPathname();
            $schemaJson = file_get_contents($schemaPath);
            if (! is_string($schemaJson) || $schemaJson === '') {
                continue;
            }
            $schema = json_decode($schemaJson);
            try {
                $fake = $faker->generate($schema);
                if (! $fake instanceof \stdClass) {
                    throw new \RuntimeException('Faker return no JSON');
                }
                $schemaFilname = $fileInfo->getFilename();
                $fake->{'$schema'} = sprintf('%s/%s', $schemaUri, $schemaFilname);
                $distName = sprintf('%s/%s', $distDir, $schemaFilname);
                $fakeJson = json_encode($fake, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
                file_put_contents($distName, $fakeJson);
            } catch (\Exception $e) {
                printf("%s: %s %s on line %d\n", $fileInfo->getFilename(), $e->getMessage(), $e->getFile(), $e->getLine());

                continue;
            }
        }
    }

    private function files(string $dir, string $ext) : \Iterator
    {
        return
            new \RegexIterator(
                new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator(
                        $dir,
                        \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::SKIP_DOTS
                    ),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                ),
                "/^.+\\.{$ext}/",
                \RecursiveRegexIterator::MATCH
            );
    }
}
