# PlatbaMobilom.sk PHP SDK
This library provides simple interface for making payments through
[PlatbaMobilom.sk](http://platbamobilom.sk/). In general PlatbaMobilom.sk
supports online and offline payments. This library currently supports only
online payment.

## Requirements
* PHP >= 7.0

## Installation
The easiest way to install the SDK is to use dependency manager called
[Composer](https://getcomposer.org/).
```
$ composer require martinvondrak/platba-mobilom-php-sdk
```

## Basic usage
### Setting up client
```php
use MartinVondrak\PlatbaMobilom\PlatbaMobilomClient;

$pid = 1; // merchant ID
$url = 'https//www.shop.com/callback'; // URL of callback where user will be redirected from PlatbaMobilom.sk
$pwd = 'SecretPass'; // passphrase used for signing requests
$email = 'sales@shop.com'; // merchant email (optional)
$debug = true; // flag whether production or test environment is used
$platbaMobilomClient = new PlatbaMobilomClient($pid, $url, $pwd, $email, $debug);
```

### Creating payment
```php
use MartinVondrak\PlatbaMobilom\Http\Request;

$id = 'aef4622'; // unique ID of payment
$description = 'Payment in www.shop.com'; // description of payment
$price = 6.5; // amount to pay in EUR
$request = new Request($id, $description, $price);
// client from previous step
$redirectUrl = $platbaMobilomClient->getGatewayUrl($request);
// now redirect user to $redirectUrl
```

### Verifying payment
```php
use MartinVondrak\PlatbaMobilom\Exception\InvalidSignatureException;
use MartinVondrak\PlatbaMobilom\Http\Response;

// following attributes are in query string in request on callback url from first step
$id = $_GET['ID']; // unique ID of payment
$result = $_GET['RES']; // status of payment
$responseSignature = $_GET['SIGN']; // signature of received parameters
$phone = $_GET['PHONE']; // phone number used for payment (optional)
$response = new Response($id, $result, $responseSignature, $phone);

try {
    // client from first step
    if ($platbaMobilomClient->checkResponse($response)) {
        // paid
    } else {
        // not paid or error
    }
} catch (InvalidSignatureException $ex) {
    // signature is not valid for received data
}
```
## PlatbaMobilom.sk documentation
For further information there is the official documentation of PlatbaMobilom.sk.
Unfortunately the documentation is only in Slovak language.

* [Online payment technical documentation](https://platbamobilom.sk/doc/PlatbaMobilom_technicka_prirucka_online.pdf)
