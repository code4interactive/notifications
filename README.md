# Notifications Package

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


## Install

Via Composer

``` bash
composer require code4interactive/notifications
```

## Usage

``` php

//Adding new storage methods
Notifications::addStore('storeName', Code4\Notifications\Storage\StorageInterface);

//Adding new notification bags
Notifications::make($storeName, $bag = 'default', $autoCleanOnGet = null);

//Config
'defaultStore' => 'session'  //Sets default store for default bag or dynamicly created bags
'autoCleanOnGet' => true     //Sets default behaviour of bag - when true - every get() clears from store recived data
'engine' => ...              //Define engine class for handling notifications. Must implement EngineInterface
                             //Can extend BasicNotifications engine


//Usage
Notifications::error('Message');     //$type = 'error', $message = 'Message', $bag = 'default'
Notifications::success('Message');
Notifications::info('Message');
Notifications::notice('Message');
Notifications::custom('Message');

Notifications::error('Message', 'customBag'); //Puts message to custom bag. If bag does not exist - creates it with defaults

//In view
Notifications::bag()->get('error'); //gets all errors from default bag of error type
Notifications::bag()->get();        //gets all errors from default bag of every types

Notifications::all()                //Shortcut method for default bag
Notifications::get('error')         //Shortcut method for default bag

//Callback
Notifications::bag()->callback('error', function($message){}); //Callback for every put


```

## Testing

``` bash
composer test
```

## Credits

- [:author_name][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/code4interactive/notifications.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/code4interactive/notifications/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/g/code4interactive/notifications.svg?style=flat-square
[ico-circle]: https://circleci.com/gh/code4interactive/notifications/tree/master.svg?style=svg
[ico-downloads]: https://img.shields.io/packagist/dt/code4interactive/notifications.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/code4interactive/notifications

[link-travis]: https://travis-ci.org/code4interactive/notifications
[link-scrutinizer]: https://scrutinizer-ci.com/g/code4interactive/notifications/code-structure
[link-downloads]: https://packagist.org/packages/code4interactive/notifications
[link-author]: https://github.com/code4interactive
[link-contributors]: ../../contributors

