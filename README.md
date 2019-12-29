# Pipeliner
![codecov](https://img.shields.io/badge/coverage-100%25-brightgreen)
![](https://img.shields.io/packagist/l/pixaye/pipeliner)
![](https://img.shields.io/packagist/v/pixaye/pipeliner)
![](https://img.shields.io/badge/php->%3D7.1-blue)  

![Logo](https://i.imgur.com/DLn6NXJ.jpg)

Pipeliner is a simple pipeline implementation, which allows you to decompose any big action in your application into small and replacable parts, so you can change some behavior in this action in runtime. It makes your application simple to test, easy to find bugs/identify problematic areas and makes it really flexible.

To start using pipeliner, just run the composer command
```bash
composer require pixaye/pipeliner
```

# Usage
```php
$pipeline = new Pipeliner\Pipeline();

$pipeline->pipe(new ExampleMiddleware());
         ->pipe(new SecondExampleMiddleware());
         ->exec();
```

Let`s see what does middleware class contain

```php
<?php

use Pipeliner\Middleware\AbstractMiddleware;

/**
 * Class ExampleMiddleware
 */
class ExampleMiddleware extends AbstractMiddleware
{
    /**
     * Doing dome stuff and returns result or null, if it is making some action and don't returns something;
     */
    public function handle()
    {
        echo 'First middleware has done some stuff';
    }
}

```

You can specify the next() method and specify which class will be called next in chain. If it is not called - exception will be thrown

```php

public function next() : ?string
{
    return 'SecondExampleMiddleware';
}

```

You can create your types of middlewares. Just create new class which will extends AbstractMiddleware and that`s it! At the moment, pipeliner has one additional middleware class called ClosureMiddleware. It allows you to use closures in chain.

```php
$pipeline = new Pipeliner\Pipeline();

$pipeline->pipe(new ExampleMiddleware())
         ->pipe(new SecondExampleMiddleware())
         ->pipe(new ClosureMiddleware('SomeActionName', function(){
              return 'I am clousure';
         }, 'FourthMiddleware'))
         ->pipe(new FourthMiddleware())
         ->exec();

```

Every middleware class have private $bag variable, which contains instance of BagInterface (RuntimeBag at the time, but you can make your own, for example you can contain data in database or in file). 

It contains all results from previous middlewares and have four methods which allows you to get/set that data.

```php
$this->bag->put('NameOfMiddleware', $data);
$this->bag->get('NameOfMiddleware');
$this->bag->getLast();
$this->bag->getAll();
```

You can set your own bag, just create one which implements BagInterface and that`s it!

```php
$pipeliner = new Pipeliner\Pipeline();
$pipeliner->setPipelineBag(new YourOwnBagClass());
...
```
