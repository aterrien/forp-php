forp-php
=============

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/aterrien/forp-php/badges/quality-score.png?s=f9924d4202521d69622cd5cbea0cb543bebb112a)](https://scrutinizer-ci.com/g/aterrien/forp-php/)

forp-php is a composer package that "simplifies" usage of forp PHP profiler on your application.

What it does :
* it starts forp PHP profiler.
* it registers the forp output callback on shutdown of the PHP script.
* it selects the most appropriate response to the client.


API
-------

``` php
Forp\Forp::start($opts)
```

with $opts :

``` php
array(
    'no_internals' => 1,                // enable/disable collect of PHP internals
    'ui_src' => '<your forp-ui cdn>',   // URL of forp-ui forp.min.js on your CDN @link https://github.com/aterrien/forp-ui/
    'flags' =>  self::FLAG_ALL,         // forp flags @link https://github.com/aterrien/forp-PHP-profiler/#forp_start-flags
)
```

Install
-------

Just add this package to the requires of your project (`composer.json`):

``` json
{
    "require":{
        "aterrien/forp": "dev-master"
    }
}
```

Don't forget to run the install command.

Start forp
-------

Can be done in an auto-prepend-file :

``` php
// if($theCurrentRequestCanProfileTheCurrentScript) {


$Forp = new Forp\Forp(array(
    'ui_src' => '<your forp-ui cdn>',
));
$Forp->start();


// }
```