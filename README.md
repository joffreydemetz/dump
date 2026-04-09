# Dump
Simple file dumper helper

## Installation

```bash
composer require jdz/dump
```

## Requirements
- PHP 8.2 or higher

## Usage

### Basic Example

```php
use JDZ\Utils\Dump;

$dump = new Dump('/path/to/logfile.txt');

// Write content (appends to file)
$dump->write('First line');
$dump->write('Second line');

// Read file contents
$content = $dump->read(); // "First line\nSecond line\n"

// Check if file exists
$dump->exists(); // true

// Delete file
$dump->delete();
$dump->exists(); // false
```

### Fluent Interface

`write()` and `delete()` return `$this` for chaining:

```php
$dump = new Dump('/tmp/debug.log');
$dump->write('Starting process')
     ->write('Step 1 complete')
     ->write('Step 2 complete');
```

### Reading a Non-Existent File

```php
$dump = new Dump('/path/to/missing.txt');
$dump->read(); // null
```

## Testing

```bash
composer test
# or
vendor/bin/phpunit
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
