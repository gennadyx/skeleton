# skeleton

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]

[![Coverage Status][ico-coverage]][link-coverage]
[![Sensiolabs Medal][ico-code-quality-sensio]][link-code-quality-sensio]
[![Quality Score][ico-code-quality-scrutinizer]][link-code-quality-scrutinizer]

#Composer package skeleton.
This package provides the handler for the 'create-project' command, which automatically collects the necessary information, for example, vendor, package name, author name, author email, etc. It is also possible to set default values using environment variables.

###Available variables and their default values:
<pre>
<b>root</b>                Project root directory
<b>skeleton</b>            Skeleton directory
<b>vendor</b>              System username from environment variable
<b>name</b>                Package name, uses project root directory basename
<b>description</b>         Just "package_name composer package"
<b>homepage</b>            https://github.com/vendor/package_name
<b>author_name</b>         'user.name' from git config or vendor
<b>author_email</b>        'user.email' from git config
<b>author_homepage</b>     https://github.com/vendor
<b>namespace</b>           Vendor\\Package or Vendor\\Package\\Name
<b>tests_namespace</b>     Vendor\\Package\\Tests
</pre>

## Usage

``` bash
$ composer create-project gennadyx/skeleton package_name

#with env variable
$ COMPOSER_DEFAULT_VENDOR="my_vendor" composer create-project gennadyx/skeleton package_name
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email dev@gennadyx.tech instead of using the issue tracker.

## Credits

- [Gennady Knyazkin][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/gennadyx/skeleton.svg?style=flat
[ico-license]: https://img.shields.io/packagist/l/gennadyx/skeleton.svg?style=flat
[ico-travis]: https://img.shields.io/travis/gennadyx/skeleton/master.svg?style=flat
[ico-coverage]: https://img.shields.io/scrutinizer/coverage/g/gennadyx/skeleton.svg?style=flat
[ico-code-quality-scrutinizer]: https://img.shields.io/scrutinizer/g/gennadyx/skeleton.svg?style=flat
[ico-code-quality-sensio]: https://insight.sensiolabs.com/projects/8a05f05b-d1c9-40b1-8c87-5a251f712f4d/mini.png
[ico-downloads]: https://img.shields.io/packagist/dt/gennadyx/skeleton.svg?style=flat

[link-packagist]: https://packagist.org/packages/gennadyx/skeleton
[link-travis]: https://travis-ci.org/gennadyx/skeleton
[link-coverage]: https://scrutinizer-ci.com/g/gennadyx/skeleton/code-structure
[link-code-quality-scrutinizer]: https://scrutinizer-ci.com/g/gennadyx/skeleton
[link-code-quality-sensio]: https://insight.sensiolabs.com/projects/8a05f05b-d1c9-40b1-8c87-5a251f712f4d
[link-downloads]: https://packagist.org/packages/gennadyx/skeleton
[link-author]: http://gennadyx.tech
[link-contributors]: https://github.com/gennadyx/skeleton/contributors
