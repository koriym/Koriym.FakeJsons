# FakeJsons

Generates fake JSONs from JSON schema in the directory using `leko/json-schema-faker`.

## Usage

```php
$sourceDir = __DIR__ . '/schema/semantic';
$distDir = __DIR__ . '/fake';
$schemaUri = 'https://raw.githubusercontent.com/koriym/project-awesome/master/schema';

(new FakeJsons)($sourceDir, $distDir, $schemaUri);
```
