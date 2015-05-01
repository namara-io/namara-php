Namara
======

The official php client for the Namara Open Data service. [namara.io](http://namara.io)

## Installation

```bash
git clone git@github.com:namara-io/namara-php.git
```

### On Mac
Download and install MacPorts: http://www.macports.org/install.php

```bash
sudo port install php53-curl 
```

### On Ubuntu

```bash
sudo apt-get install php53-curl
sudo service apache2 restart
```

Install PHPUnit: composer global require "phpunit/phpunit=4.6.*"

## Usage

### Instantiation

You need a valid API key in order to access Namara (you can find it in your My Account details on namara.io).
Update config.py with your API_KEY

```php
include 'namara'

$namara = new Namara({YOUR_API_KEY});
```

You can also optionally enable debug mode:

```php
$namara = new Namara({YOUR_API_KEY}, true);
```

### Getting Data

To make a basic request to the Namara API you can call `get` on your instantiated object and pass it the ID of the dataset you want and the ID of the version of the data set:

```php
$response = namara->get('18b854e3-66bd-4a00-afba-8eabfc54f524', 'en-2');
```

Without a third options argument passed, this will return data with the Namara default offset (0) and limit (10) applied. To specify options, you can pass an options argument:

```php
$options = (Object) array('offset' => 0, 'limit' => 150);

$namara->get('18b854e3-66bd-4a00-afba-8eabfc54f524', 'en-2', options);
```

### Options

All [Namara data options](http://namara.io/#/api) are supported.

**Basic options**

```php
$options = (Object) array(
  'select'=> 'p0,p1',
  'where' => 'p0 = 100 AND nearby(p3, 43.25, -123.1, 10km)',
  'offset' => 0,
  'limit' => 10
);
```

**Aggregation options**
Only one aggregation option can be specified in a request, in the case of this example, all options are illustrated, but passing more than one in the options object will throw an error.

```php
$options = (Object) array(
  'operation' => 'sum(p0)',
  'operation' => 'avg(p0)',
  'operation' => 'min(p0)',
  'operation' => 'max(p0)',
  'operation' => 'count(*)',
  'operation' => 'geocluster(p3, 10)',
  'operation' => 'geobounds(p3)'
);
```

### Running Tests

From command line:

```
phpunit --verbose test_namara.php
```