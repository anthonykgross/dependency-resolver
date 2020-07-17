[![Build Status](https://travis-ci.org/anthonykgross/dependency-resolver.svg?branch=master)](https://travis-ci.org/anthonykgross/dependency-resolver)

## Installing anthonykgross/dependency-resolver

The recommended way to install anthonykgross/dependency-resolver is through
[Composer](http://getcomposer.org).
```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of dependency-resolver:

```bash
php composer.phar require anthonykgross/dependency-resolver "dev-master"
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update dependency-resolver using composer:

 ```bash
composer.phar update
 ```

### Usage
 ```php
$tree  = array(
    'A' => array(),
    'B' => array('A'),
    'C' => array('B'),
    'D' => array('C', 'A'),
    'E' => array('C', 'B'),
);
$resolution = \Algorithm\DependencyResolver::resolve($tree);
print($resolution);
// ['A','B','C','D','E']
```
OR 
```php
$tree  = array(
    'A' => array('B'),
    'B' => array('C'),
    'C' => array('A'),
);
$resolution = \Algorithm\DependencyResolver::resolve($tree);
// RuntimeException : Circular dependency: C -> A
```
**Documentation**
- <https://www.electricmonk.nl/log/2008/08/07/dependency-resolving-algorithm/>
- <http://mamchenkov.net/wordpress/2016/11/22/dependency-resolution-with-graphs-in-php/>

## Contributors
**Anthony K GROSS**
- <http://anthonykgross.fr>
- <https://twitter.com/anthonykgross>
- <https://github.com/anthonykgross>

**Joshua Behrens**
- <https://github.com/JoshuaBehrens>

## Copyright and license
Code and documentation copyright 2020. Code released under [the MIT license](https://github.com/anthonykgross/dependency-resolver/blob/master/LICENSE).

