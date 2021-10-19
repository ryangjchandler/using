# Enforced disposal of objects in PHP.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ryangjchandler/using.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/using)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/using/run-tests?label=tests)](https://github.com/ryangjchandler/using/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/using/Check%20&%20fix%20styling?label=code%20style)](https://github.com/ryangjchandler/using/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/ryangjchandler/using.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/using)

This package provides a `Disposable` interface and `using()` global function that can be used to enforce the disposal of objects.

## Installation

You can install the package via composer:

```bash
composer require ryangjchandler/using
```

## Usage

You should first implement the `RyanChandler\Using\Disposable` interface on your class. This contract requires an implementation of a `public function dispose(): void` method.

```php
class TextFile implements Disposable
{
    private $resource;

    public function dispose(): void
    {
        $this->resource = fclose($this->resource);
    }
}
```

You can then use the `using()` helper function with your `Disposable` object to enforce disposal.

```php
// This code might create a file pointer and store it on the class.
$file = new TextFile('hello.txt');

// We can then "use" the `$file` object inside of this callback. After the callback has been
// invoked, the `TextFile::dispose()` method will be called.
using($file, function (TextFile $file) {
    DB::create('messages', [
        'message' => $file->contents(),
    ]);
});

// The `$resource` property is no-longer a valid stream, since we closed
// the handle in the `dispose` method.
var_dump($file->resource);
```

### Handling Exceptions

The `using()` function will wrap the invokation of your callback in a `try..finally` statement.

This ensures that your object is disposed of regardless of any exceptions.

Any exceptions thrown inside of your callback will still propagate up to the top-level.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ryan Chandler](https://github.com/ryangjchandler)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
