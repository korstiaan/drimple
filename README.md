# Drimple for Drupal 7.x

Module which adds a Dependency Injection Container using Pimple (https://github.com/fabpot/Pimple) to Drupal. 

[![Build Status](https://secure.travis-ci.org/korstiaan/drimple.png?branch=tests)](http://travis-ci.org/korstiaan/drimple)
 
## Requirements

* Drupal 7.x
* PHP 5.3.3+
* [Pimple](https://github.com/fabpot/Pimple)

## Installation

The recommended way to install `Drimple` is with [Composer](http://getcomposer.org). 
Just add the following to your `composer.json`:

```json
   {
	   "require": {
	   	   ...
		   "korstiaan/drimple": "*"
	   }
   }
```

Now update composer and install the newly added requirement and its dependencies (including `Pimple`):

``` bash
$ php composer.phar update korstiaan/drimple
```

Next go to `site/all/modules` and enable it on `http://yourdomain.com/admin/modules/list`.

(If you're using [voiture](http://voiture.hoppinger.com) just add `drimple` to `cnf/shared/modules.php`)

### Using Composer

Using `Composer` means enabling its autoloader. This can be done in 2 days:

1. Require _autoload.php_ in _settings.php_ (recommended) 

Add the following to your Drupals settings.php:

```php
// /path/to/sites/default/settings.php

require '/path/to/vendor/autoload.php';
```

2. Use [composer_loader](https://github.com/korstiaan/composer_loader)

Just follow its readme.

## Usage

`Drimple`s container and its services can then be retrieved as singleton via `drimple()` or `\Drimple\Drimple::getInstance()`.

### Adding services
 
Recommended way of adding services is by implementing `hook_drimple_provide(\Drimple\Drimple $drimple)`:

```php
<?php
// sites/all/modules/foo/foo.module

function foo_drimple_provide(\Drimple\Drimple $drimple)	
{
	$drimple['database'] 			= $drimple->share(function($c) {
		$options = $c['database.options'] + array(
			'user'		=> null,
			'password' 	=> null,
		);
		if (!isset($options['dsn'])) {
			throw new \Exception('Please provide dsn');
		}
		
		return new \PDO($options['dsn'],$options['user'],$options['password']);
	});
	$drimple['database.options'] 	= array(
		'dsn'		=> 'mysql:dbname=drupal;host=localhost',
		'user'		=> 'root',
		'password' 	=> 'root',
	); 
}
```

## Service providers
  
Just like [Silex](http://silex.sensiolabs.org/doc/providers.html) you can also add services to `Drimple` by registering `Service Providers`. 

Example:

```php
<?php
// sites/all/modules/foo/foo.module

function foo_drimple_provide(\Drimple\Drimple $drimple)	
{
	$drimple->register(new \Foo\Provider\DBProvider(), array(
		'database.options' 	=> array(
			'dsn'		=> 'mysql:dbname=drupal;host=localhost',
			'user'		=> 'root',
			'password' 	=> 'root',
		),
	));
}

// sites/all/modules/foo/Foo/Provider/DBProvider.php
namespace Foo\Provider;

use Drimple\Drimple,
	Drimple\Provider\ServiceProviderInterface; 

class DBProvider implements ServiceProviderInterface
{
	public function register(Drimple $drimple)
	{
		$drimple['database'] = $drimple->share(function($c) {
			$options = $c['database.options'] + array(
				'user'		=> null,
				'password' 	=> null,
			);
			if (!isset($options['dsn'])) {
				throw new \Exception('Please provide dsn');
			}
			return new \PDO($options['dsn'],$options['user'],$options['password']);
		});
	
	}
}
```  

# License

Drimple is licensed under the MIT license.

