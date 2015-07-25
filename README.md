# is.php

[![Latest Stable Version](https://poser.pugx.org/webuilder240/is-php/version)](https://packagist.org/packages/webuilder240/is-php) [![Build Status](https://travis-ci.org/webuilder240/is.php.svg?branch=master)](https://travis-ci.org/webuilder240/is.php)

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
