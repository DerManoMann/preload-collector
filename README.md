# Helper library to collect a list of used classes for PHP 7.4 preloading #

This library consists of two parts:
* **The collector**

    Typically a middleware that, over time, builds a list of all used classes and, by default, saves this list into
    the file `preload.json` in the project root.
    
    Since the generated list of classes is static, it is recommended to do a fresh collection cycle after big code
    changes that involve a lot of new classes.

* **The preloader**

    A small script which can be used as PHP 7.4 preloading script. The default filename is `preload.php`, also in the 
    project root.
    Creation of this script is a separate step and the specific command depends on the framework used. 


## Supported frameworks ##
* Laravel


## Requirements ##
* [PHP 7.4 or higher](http://www.php.net/)


## Installation ##

You can use **Composer** or simply **Download the Release**

### Composer ###

The preferred method is via [composer](https://getcomposer.org). Follow the
[installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have
composer installed.

Once composer is installed, execute the following command in your project root to install this library:

```sh
composer require radebatz/preload-collector
```

## Framework integration ##

### Laravel ###

#### Collecting ####

Once installed via `composer` the included service provider will register a middleware to build the class list.
This is an automated step and no manual configuration is required for this.  

#### Preloading ####

Once the collection phase is over (the list doesn't change substantially any more), the preload script can be generated
using `artisan` 

```sh
php artisan vendor:publish "--provider=Radebatz\PreloadCollector\Laravel\ServiceProvider" --tag=preload
```

After this, both 'preload.php' and the generated 'preload.json' should be added to your projects repository.

#### Configuration ####

The only configuration option available is to enable/disable the collector mdidleware.

This can either be done by publishing the library config via

```sh
php artisan vendor:publish "--provider=Radebatz\PreloadCollector\Laravel\ServiceProvider" --tag=config
``` 

and editing the config in your projects `config` folder.

Alternatively, this may be controller via `env` variable like so:

```sh
export PRELOAD_COLLECTOR_ENABLED=true
```

## Testing ##
