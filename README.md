# Niirrty.Locale

The Locale class and some helpers

## Installation

inside the `composer.json`:

```json
{
   "require": {
      "php": ">=8.1",
      "niirrty/niirrty.locale": "^0.6"
   }
}
```

## Usage

If you want to use this package inside you're application include the depending
composer autoload.php

### The Locale

Create a new Locale instance

```php
use \Niirrty\Locale\Locale;

Locale::Create(
   // The fallback locale if no other was found
   new Locale( 'de', 'AT', 'UTF-8' ),
   // Check also the URL path for an locale or language part?
   true,
   // This are the names of the parameters, accepted from $_POST, $_GET and $_SESSION
   [ 'locale', 'language', 'lang' ]
)
   ->registerAsGlobalInstance();
```

This creates the new Locale by checking the following places to get the required information

* First The current URL part is checked, if it contains an valid locale string, it is used (you can disable it by 
  setting the 2nd Create parameter to FALSE.
* Next it checks if one of the defined request parameters (3rd parameter) is defined by $_POST, $_GET or $_SESSION
* After that, its checked if the browser sends some information about the preferred locale/language.
* Finally it is checked if the system gives usable locale information.

If all this methods fail, the declared fall back locale is returned. You can also call it main locale.

Last but not least the created locale is registered as global available Locale instance. It can be accessed from other
places by:

```php
if ( Locale::HasGlobalInstance() )
{
   $locale = Locale::GetGlobalInstance();
}
else
{
   // Create the locale
   //$locale = Locale::Create( … )->registerAsGlobalInstance();
}
```
