# is.php

[![Build Status](https://travis-ci.org/webuilder240/is.php.svg?branch=master)](https://travis-ci.org/webuilder240/is.php) [![Code Coverage](https://scrutinizer-ci.com/g/webuilder240/is.php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/webuilder240/is.php/?branch=master)

## Install

``` bash
composer require webuilder240/is-php
```

## About This Library

is.jsにインスパイアを受けてphpに持ち込んでみました。~~コードが汚い~~

## Usage

``` php

<?php

require 'vendor/autoload.php'

$is = new Is\Is();

$is->apache(); //true
$is->not()->localhost(); //false
$is->email('littlecub240@gmail.com); //true

```
