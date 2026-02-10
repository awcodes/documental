> [!CAUTION]
> This package is in early development and is not yet ready for production use. Use at your own risk. If you would like to contribute or provide feedback, please open an issue or submit a pull request.

# Documental

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awcodes/documental.svg?style=flat-square)](https://packagist.org/packages/awcodes/documental)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/awcodes/documental/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/awcodes/documental/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/awcodes/documental/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/awcodes/documental/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/documental.svg?style=flat-square)](https://packagist.org/packages/awcodes/documental)

A plugin for Filament panels that adds document management capabilities to your application.

## Installation

You can install the package via composer:

```bash
composer require awcodes/documental
```

Next run the install command:

```bash
php artisan documental:install
```

Lastly, add the plugin to your Filament panel provider:

```php
$panel->plugins([
    DocumentalPlugin::make()
])
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="documental-config"
```

This is the contents of the published config file:

```php
return [
    'resources' => [
        'package' => \Awcodes\Documental\Filament\Resources\PackageResource::class,
        'version' => \Awcodes\Documental\Filament\Resources\VersionResource::class,
        'page' => \Awcodes\Documental\Filament\Resources\PageResource::class,
    ],
];
```

## Usage

```php
$documental = new Awcodes\Documental();
echo $documental->echoPhrase('Hello, Awcodes!');
```

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

- [Adam Weston](https://github.com/awcodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
