# is.php

[[![Code Coverage](https://scrutinizer-ci.com/g/webuilder240/is.php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/webuilder240/is.php/?branch=master) ![Latest Stable Version](https://poser.pugx.org/webuilder240/is-php/version)](https://packagist.org/packages/webuilder240/is-php) [![Build Status](https://travis-ci.org/webuilder240/is.php.svg?branch=master)](https://travis-ci.org/webuilder240/is.php)

## Usage:

``` bash
composer require webuilder240/is-php
```

## About This Library

is.jsにインスパイアを受けてphpに持ち込んでみました。~~コードが汚い~~

# Web Server Check:

## is->apache()

``` php

$is = new Is\Is();

$is->apache(); 
// true if current run server is apache

$is->not->apache();
// true if current run server is not apache

```

## is->build_in_server()

``` php

$is = new Is\Is();

$is->build_in_server(); 
// true if current run server is php build_in_server(cli-server)

$is->not->build_in_server();
// true if current run server is not php build_in_server(cli-server)

```

# Server Check:

## is->ssl()

``` php

$is = new Is\Is();

$is->ssl(); 
// true if current run server protocol is 'ssl'

$is->not->ssl();
// true if current run server protocol is not 'ssl'

```

## is->localhost()

``` php

$is = new Is\Is();

$is->localhost(); 
// true if current run server ip is 'localhost' or 127.0.0.1

$is->not->localhost();
// true if current run server ip is not 'localhost' or 127.0.0.1

```

## is->host(value:string)

``` php

$is = new Is\Is();

$is->host('www.google.com'); 
// true if current run server host name is 'www.google.com'

$is->not->host('www.google.com');
// true if current run server host name is not 'www.google.com'

```

## is->host_ip(value:string)

``` php

$is = new Is\Is();

$is->host_ip('192.168.56.101'); 
// true if current run server host ip address '192.168.56.101'

$is->not->host('192.168.56.101');
// true if current run server host ip address is not '192.168.56.101'

```

# UserAgent Check

## is->chrome()

``` php

$is = new Is\Is();

$is->chorme();
// true if current browser is chrome 

$is->not->chorme();
// true if current browser is not chrome 

```

## is->firefox()

``` php

$is = new Is\Is();

$is->firefox();
// true if current browser is firefox 

$is->not->firefox();
// true if current browser is not firefox 

```

## is->safari()

``` php

$is = new Is\Is();

$is->safari();
// true if current browser is safari

$is->not->safari();
// true if current browser is not safari

```

## is->opera()

``` php

$is = new Is\Is();

$is->opera();
// true if current browser is opera

$is->not->opera();
// true if current browser is not opera

```

## is->ie(version:int)

``` php

$is = new Is\Is();

$is->ie();
// true if current browser is ie

$is->ie(8);
// true if current brower is ie version 8

$is->not->ie();
// true if current browser is not ie

```


## is->ios()

``` php

$is = new Is\Is();

$is->ios(); 
// true if current device has iOS

$is->not->ios(); 
// true if current device has iOS

```

## is->android();

``` php

$is = new Is\Is();

$is->android(); 
// true if current device has Android OS

$is->not->android(); 
// true if current device has not Android OS
```

## is->mobile() [phone]

``` php

$is = new Is\Is();

$is->mobile(); 
// true if current device is mobile (phone)

$is->not->mobile(); 
// true if current device is not mobile (phone)

```

## is->tablet()

``` php

$is = new Is\Is();

$is->tablet(); 
// true if current device is tablet

$is->not->tablet(); 
// true if current device is not tablet

```

# HttpMethod Check

## is->request_get()

``` php

$is = new Is\Is();

$is->request_get(); 
// true if current request is GET request

$is->not->request_get(); 
// true if current request is not GET request

```

## is->request_post()

``` php

$is = new Is\Is();

$is->request_post(); 
// true if current request is POST request

$is->not->request_post(); 
// true if current request is not POST request

```

## is->request_put()

``` php

$is = new Is\Is();

$is->request_put(); 
// true if current request is PUT request

$is->not->request_put(); 
// true if current request is not PUT request

```

## is->request_patch()

``` php

$is = new Is\Is();

$is->request_patch(); 
// true if current request is PATCH request

$is->not->request_patch(); 
// true if current request is not PATCH request

```

## is->request_delete()

``` php

$is = new Is\Is();

$is->request_delete(); 
// true if current request is DELETE request

$is->not->request_delete(); 
// true if current request is not DELETE request

```

## is->http_status_code(uri:string,http_code:int)

``` php

$is = new Is\Is();

$is->http_status_code('http://google.com',302); 
// true if http://google.com is responsed http_status_code 302

$is->not->http_status_code('http://google.com',500); 
// true if http://google.com is not responsed http_status_code 500

```

# TypeCheck

## is->same_type(val:any,val:any)

``` php

$is = new Is\Is();

$is->same_type(1,2);
// true 

$is->same_type('1',2);
// false

$is->not->same_type(1,2);

```

# String Check

## is->str_include(str:string,search_word:string)

``` php

$is = new Is\Is();

$is->str_include('nick','n');
// true 

$is->str_include('test','text);
// false

$is->not->str_include('test','text');
// true

```