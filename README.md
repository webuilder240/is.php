# is.php

[[![Code Coverage](https://scrutinizer-ci.com/g/webuilder240/is.php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/webuilder240/is.php/?branch=master) ![Latest Stable Version](https://poser.pugx.org/webuilder240/is-php/version)](https://packagist.org/packages/webuilder240/is-php) [![Build Status](https://travis-ci.org/webuilder240/is.php.svg?branch=master)](https://travis-ci.org/webuilder240/is.php)

## Usage:

``` bash
composer require webuilder240/is-php
```

## About This Library

is.jsにインスパイアを受けてphpに持ち込んでみました。~~コードが汚い~~

# Server Side Check:

## is->apache()

``` php

$is = new Is\Is();

$is->apache(); 
// true if current run server is apache

$is->not()->apache();
// true if current run server is not apache

```

## is->build_in_server()

``` php

$is = new Is\Is();

$is->build_in_server(); 
// true if current run server is php build_in_server(cli-server)

$is->not()->build_in_server();
// true if current run server is not php build_in_server(cli-server)

```

# UserAgent Check

## is->chrome()

``` php

$is = new Is\Is();

$is->chorme();
// true if current browser is chrome 

$is->chorme();
// true if current browser is not chrome 

```

## is->firefox()

``` php

$is = new Is\Is();

$is->firefox();
// true if current browser is firefox 

$is->firefox();
// true if current browser is not firefox 

```

## is->safari()

``` php

$is = new Is\Is();

$is->safari();
// true if current browser is safari

$is->safari();
// true if current browser is not safari

```

## is->opera()

``` php

$is = new Is\Is();

$is->opera();
// true if current browser is opera

$is->opera();
// true if current browser is not opera

```

## is->ie()

``` php

$is = new Is\Is();

$is->ie();
// true if current browser is ie

$is->ie();
// true if current browser is not ie

```


## is->ios()

``` php

$is = new Is\Is();

$is->ios(); 
// true if current device has iOS

$is->not()->ios(); 
// true if current device has iOS

```

## is->android();

``` php

$is = new Is\Is();

$is->android(); 
// true if current device has Android OS

$is->not()->android(); 
// true if current device has not Android OS
```

## is->mobile() [phone]

``` php

$is = new Is\Is();

$is->mobile(); 
// true if current device is mobile (phone)

$is->not()->mobile(); 
// true if current device is not mobile (phone)

```

## is->tablet()

``` php

$is = new Is\Is();

$is->tablet(); 
// true if current device is tablet

$is->not()->tablet(); 
// true if current device is not tablet

```

# HttpMethod Check

## is->request_get()

``` php

$is = new Is\Is();

$is->request_get(); 
// true if current request is GET request

$is->not()->request_get(); 
// true if current request is not GET request

```

## is->request_post()

``` php

$is = new Is\Is();

$is->request_post(); 
// true if current request is POST request

$is->not()->request_post(); 
// true if current request is not POST request

```

## is->request_put()

``` php

$is = new Is\Is();

$is->request_put(); 
// true if current request is PUT request

$is->not()->request_put(); 
// true if current request is not PUT request

```

## is->request_patch()

``` php

$is = new Is\Is();

$is->request_patch(); 
// true if current request is PATCH request

$is->not()->request_patch(); 
// true if current request is not PATCH request

```

## is->request_delete()

``` php

$is = new Is\Is();

$is->request_delete(); 
// true if current request is DELETE request

$is->not()->request_patch(); 
// true if current request is not DELETE request

```
