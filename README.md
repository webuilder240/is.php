# is.php 0.0.5

[[![Code Coverage](https://scrutinizer-ci.com/g/webuilder240/is.php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/webuilder240/is.php/?branch=master) ![Latest Stable Version](https://poser.pugx.org/webuilder240/is-php/version)](https://packagist.org/packages/webuilder240/is-php) [![Build Status](https://travis-ci.org/webuilder240/is.php.svg?branch=master)](https://travis-ci.org/webuilder240/is.php)

# Usage:

``` bash
composer require webuilder240/is-php
```

# Web Server Check:

## Is\Is::apache()

``` php

Is\Is::apache(); 
// true if current run server is apache

```

## Is\Is::build_in_server()

``` php

Is\Is::build_in_server(); 
// true if current run server is php build_in_server(cli-server)

```

# Server Check:

## Is\Is::ssl()

``` php

Is\Is::ssl(); 
// true if current run server protocol is 'ssl'

```

## Is\Is::localhost()

``` php

Is\Is::localhost(); 
// true if current run server ip is 'localhost' or 127.0.0.1

```

## Is\Is::host(value:string)

``` php

Is\Is::host('www.google.com'); 
// true if current run server host name is 'www.google.com'

```

## Is\Is::host_ip(value:string)

``` php

Is\Is::host_ip('192.168.56.101'); 
// true if current run server host ip address '192.168.56.101'

```

# UserAgent Check

## Is\Is::chrome()

``` php

Is\Is::chorme();
// true if current browser is chrome 

```

## Is\Is::firefox()

``` php

Is\Is::firefox();
// true if current browser is firefox 

```

## Is\Is::safari()

``` php

Is\Is::safari();
// true if current browser is safari

```

## Is\Is::opera()

``` php

Is\Is::opera();
// true if current browser is opera

```

## Is\Is::ie(version:int)

``` php

Is\Is::ie();
// true if current browser is ie

Is\Is::ie(8);
// true if current brower is ie version 8

```

## Is\Is::ios()

``` php

Is\Is::ios(); 
// true if current device has iOS

```

## Is\Is::android();

``` php

Is\Is::android(); 
// true if current device has Android OS

```

## Is\Is::mobile() [phone]

``` php

Is\Is::mobile(); 
// true if current device is mobile (phone)

```

## Is\Is::tablet()

``` php

Is\Is::tablet(); 
// true if current device is tablet

```

# HttpMethod Check

## Is\Is::request_get()

``` php

Is\Is::request_get(); 
// true if current request is GET request

```

## Is\Is::request_post()

``` php

Is\Is::request_post(); 
// true if current request is POST request

```

## Is\Is::request_put()

``` php

Is\Is::request_put(); 
// true if current request is PUT request

```

## Is\Is::request_patch()

``` php

Is\Is::request_patch(); 
// true if current request is PATCH request

```

## Is\Is::request_delete()

``` php

Is\Is::request_delete(); 
// true if current request is DELETE request

```

## Is\Is::http_status_code(uri:string,http_code:int)

``` php

Is\Is::http_status_code('http://google.com',302); 
// true if http://google.com is responsed http_status_code 302

```

# TypeCheck

## Is\Is::same_type(val:any,val:any)

``` php

Is\Is::same_type(1,2);
// true 

Is\Is::same_type('1',2);
// false

```

# String Check

## Is\Is::str_include(str:string,search_word:string)

``` php

Is\Is::str_include('nick','n');
// true 

Is\Is::str_include('test','text);
// false

```