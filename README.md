Drimple for Drupal 7.x
========================
Module which adds a Dependency Injection Container using Pimple (https://github.com/fabpot/Pimple) to Drupal. 
 
Requirements
--------------------------------

* Drupal 7.x
* PHP 5.3.2+
* Pimple (https://github.com/fabpot/Pimple)

Pimple availability can be achieved using Composer Loader by adding the following line to your composer.json:

``` json
{
	"require": {
	    "pimple/pimple": "dev-master",
	}
}
```

Autoloading
--------------------------------

Suggested is using nsautoload (https://github.com/korstiaan/nsautoload) for autoloading your custom service / provider classes.

Usage
--------------------------------

Install it as a normal Drupal module. This means downloading (or git clone'ing) it to site/all/modules and enabling it on "admin/modules/list".
(If you're using voiture (http://voiture.hoppinger.com) just add "drimple" to cnf/shared/modules.php)

Drimple's container can then be retrieved as singleton via \Drimple\Drimple::getInstance().

Adding services
--------------------------------
 
Recommended way of adding services is by adding them in hook_drimple_provide(\Drimple\Drimple $drimple)

Example:

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

Service providers
--------------------------------  

Just like Silex (http://silex.sensiolabs.org/doc/providers.html) you can also add services to Drimple using Service Providers. 

Example:

```php
<?php
// sites/all/modules/foo/foo.module

function foo_drimple_provide(\Drimple\Drimple $drimple)	
{
	$drimple->register(new \Foo\Provider\DBProvider(), array(
		'database.options' 	=> array(
			'dsn'		=> 'mysql:dbname=drupal;host=127.0.0.1',
			'user'		=> 'root',
			'password' 	=> 'root',
		),
	));
}
```

```php
<?php
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