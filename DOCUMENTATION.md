# Documentation (version 1.2)

## Table of Contents

1. [Invoices](#1)
    1. [Creating simple invoice](#1-1)
    2. [Using the constructor](#1-2)
    3. [Additional functions](#1-3)
        1. [FakturaXLInvoice to array](#1-3-1)
        2. [Create FakturaXLInvoice from JSON structure](#1-3-2)
2. [Positions](#2)
    1. [Creating a position](#2-1)
    2. [Specifying price - net or gross](#2-2)
    3. [Calculating net and gross price](#2-3)
    4. [Setting tax](#2-4)
    5. [Adding position to an invoice](#2-5)
    6. [Additional functions](#2-6)
        1. [FakturaXLPosition to array](#2-6-1)
        2. [Create FakturaXLPosition from JSON structure](#2-6-2)
3. [Invoice status](#3)
3. [Invoice kind](#4)
4. [Payment method](#5)
5. [FakturaXL](#6)
    1. [Retreiving an invoice from FakturaXL](#6-1)
    2. [Sending invoice to FakturaXL](#6-2)
    3. [Updating specific invoice in FakturaXL](#6-3)
    4. [Changing invoice status in FakturaXL](#6-4)
    5. [Deleting target invoice from FakturaXL database](#6-5)
    6. [Printing invoices](#6-6)
    7. [Creating raw print](#6-7)

---

## <a id="1"></a>Invoices

This topic will show how to create invoices and what you can modify using helper class `FakturaXLInvoice`.

Namespace:
```php
use blizni\FXL\FakturaXLInvoice;
```

<br/>

### <a id="1-1"></a>Creating simple invoice

Here's an example for basic usage of creating a simple VAT kind invoice, specifying seller and buyer name and adding a single product into it:

```php
$invoice = new FakturaXLInvoice();

$invoice->seller['name'] = "Seller name";
$invoice->buyer['name'] = "Buyer name";

$product = new FakturaXLPosition("Product ABC", 1, 10.00);
$invoice->addPosition($product);
```

If we want to specify that buyer is not company - instead of `$invoice->buyer['name']` use `$invoice->buyer['first_name']` and `$invoice->buyer['last_name']`:
```php
$invoice = new FakturaXLInvoice();

$invoice->isBuyerCompany = false;
$invoice->buyer['first_name'] = "First name";
$invoice->buyer['last_name'] = "Last name";

$product = new FakturaXLPosition("Product ABC", 1, 10.00);
$invoice->addPosition($product);
```

<br/>

### <a id="1-2"></a>Using the constructor

Normally FakturaXL API automatically generates a number for your new invoice, but if you wish to specify the number, kind of invoice and the language, you pass them as optional parameters in the invoice constructor:

```php
$invoice = new FakturaXLInvoice(FakturaXLInvoiceKind::PROFORMA, "FK 123/123/123", "en");
```

Or you can just set them by using invoice object variables:

```php
$invoice = new FakturaXLInvoice();
$invoice->kind = FakturaXLInvoiceKind::PROFORMA;
$invoice->number = "FK 123/123/123";
$invoice->language = "en";
```

<br/>

### <a id="1-3"></a>Additional functions

#### <a id="1-3-1"></a>FakturaXLInvoice to array

In order to convert object of class `FakturaXLInvoice` into an array, you have to call method `toArray()`:

```php
$invoice = new FakturaXLInvoice();

$invoiceAsArray = $invoice->toArray();
```

<br/>

#### <a id="1-3-2"></a>Create FakturaXLInvoice from JSON structure

You can create instance of `FakturaXLInvoice` class by using it's static function `createFromJson()` like showed in example below:

```php
$json = FakturaXL::getInvoice(1234567890);

$invoice = FakturaXLInvoice::createFromJson($json);
```

---

## <a id="2"></a>Positions

This section describes all functionality of `FakturaXLPosition` class, showing it's main methods for an easy management of the positions objects.

Namespace:
```php
use blizni\FXL\FakturaXLPosition;
```

<br/>

### <a id="2-1"></a>Creating a position

Every invoice requires minimum one position added to the invoice. You can create position using helper class called `FakturaXLPosition`. Here's an example of creating a simple product:

```php
$name = "Product ABC";
$quantity = 1;
$price = 10.00;

$product = new FakturaXLPosition($name, $quantity, $price);
```
or with all optional parameters:
```php
$name = "Product ABC";
$quantity = 1;
$price = 10.00;
$isNetto = false;
$tax = 23;
$gtu_code = 'GTU_02';

$product = new FakturaXLPosition($name, $quantity, $price, $isNetto, $tax, $gtu_code)
````

<br/>

### <a id="2-2"></a>Specifying price - net or gross

By default the price you specify for the position is set to gross price. If you wish to specify net price then you can use one of optional parameters of `FakturaXLPosition` constructor:

```php
// Creating a new position set with gross price
$product = new FakturaXLPosition("Product A", 1, 12.30);

// Creating a new position set with net price
$product = new FakturaXLPosition("Product B", 1, 10.00, true);
```

Or you can set variable `$isNetto` of the position object:

```php
$product = new FakturaXLPosition("Product ABC", 1, 10.00);
$product->isNetto = true;
```

<br/>

### <a id="2-3"></a>Calculating net and gross price

If you wish to convert in position object the net price to gross price and vice versa you can do that by using dedicated functions `getNetPrice()` and `getGrossPrice()`:

```php
// Creating a product with specified net price
$product = new FakturaXLPosition("Product A", 1, 10.00, true);

echo $product->getNetPrice() . '<br>'; // 10.00
echo $product->getGrossPrice() . '<br>'; // 12.30 - due to default tax of 23%
```

Notice that both of the functions only return specified prices - the `$price` variable inside of the object won't be changed!

<br/>

### <a id="2-4"></a>Setting tax

In order to set up or change tax percent you can do that by using one of `FakturaXLPosition` constructor optional parameters:

```php
// By default tax value is set to 23%
$product = new FakturaXLPosition("Product B", 1, 10.00, true);

// You can change tax value by specifying one of last parameters - remember to give the amount from range 1 - 100!
$anotherProduct = new FakturaXLPosition("Product B", 1, 10.00, true, 18);
```

You can also do that by using the `$tax` variable:

```php
$product = new FakturaXLPosition("Product A", 1, 12.00, true);
$product->tax = 18;
```

<br/>


### <a id="2-4"></a>Setting GTU Code

In order to set up or change gtu code you can do that by using one of `FakturaXLPosition` constructor optional parameters with default parameters:

```php
// By default netto and tax set at 23%
$product = new FakturaXLPosition("Product B", 1, 10.00, false, 23, 'GTU_02');
```

You can also do that by using the `$gtu_code` variable:

```php
$product = new FakturaXLPosition("Product A", 1, 12.00, true);
$product->gtu_code = "GTU_02";
```

<br/>

### <a id="2-5"></a>Adding position to an invoice

To add position object to the invoice object you can use command `addPosition()` on your invoice object:

```php
$invoice = new FakturaXLInvoice();
$product = new FakturaXLPosition("Product ABC", 1, 10.00);

$invoice->addPosition($product);
```

<br/>

### <a id="2-6"></a>Additional functions

#### <a id="2-6-1"></a>FakturaXLPosition to array

In order to convert object of class `FakturaXLPosition` into an array, you have to call method `toArray()`:

```php
$product = new FakturaXLPosition("Product ABC", 1, 10.00);

$positionAsArray = $product->toArray();
```

<br/>

#### <a id="2-6-2"></a>Create FakturaXLPosition from JSON structure

You can create instance of `FakturaXLPosition` class by using it's static function `createFromJson()` like showed in example below:

```php
$json = FakturaXL::getInvoice(1234567890);

$position = FakturaXLPosition::createFromJson($json['positions'][0]);
```

---

#### <a id="2-6-2"></a>FakturaXLPosition to array

In order to convert object of class `FakturaXLPosition` into an array, you have to call method `toArray()`:

```php
$product = new FakturaXLPosition("Product ABC", 1, 10.00);

$positionAsArray = $product->toArray();
```

---

## <a id="3"></a>Invoice status

`FakturaXLInvoiceStatus` is a static helper class that contains constants for changing invoices status:

```php
use blizni\FXL\Helpers\FakturaXLInvoiceStatus;

// Change specific invoice status to rejected
FakturaXL::changeInvoiceStatus(1234567890, FakturaXLInvoiceStatus::REJECTED);
```

---

## <a id="4"></a>Invoice kind

There's a `FakturaXLInvoiceKind` that contains constants for choosing one of existing kind of invoice for FakturaXL service.

```php
use blizni\FXL\Helpers\FakturaXLInvoiceKind;

// Set the invoice kind to proforma
$invoice->kind = FakturaXLInvoiceKind::PROFORMA;
```

---

## <a id="5"></a>Payment method

Class `FakturaXLPaymentMethod` has constants for choosing one of existing and acceptable payment methods for the FakturaXL invoices.

```php
use blizni\FXL\Helpers\FakturaXLPaymentMethod;

// Set the payment method to cash option
$invoice->paymentType = FakturaXLPaymentMethod::CASH;
```

---

## <a id="6"></a>FakturaXL

`FakturaXL` is a main helper class used to communicate with FakturaXL API servive. This class has been initialized in project using *singleton* command in Laravel.

Namespace:

```php
use blizni\FXL\FakturaXL;
```

<br/>

### <a id="6-1"></a>Retreiving an invoice from FakturaXL

To simply retrieve an existing invoice from FakturaXL service you can use static command `getInvoice()` specifying an ID of the invoice as a first parameter of the function - see an example below:

```php
$response = FakturaXL::getInvoice(123456789);

var_dump($response);
```

<br/>

### <a id="6-2"></a>Sending invoice to FakturaXL

To create the invoice in FakturaXL service you need to call static function `createInvoice()` using `FakturaXL` static helper class (remember to have at least one position in your invoice object!):

```php
$invoice = new FakturaXLInvoice();

// Filling up $invoice with data and positions...

FakturaXL::createInvoice($invoice);
```

<br/>

### <a id="6-3"></a>Updating specific invoice in FakturaXL

You can update an existing invoice in FakturaXL(InvoiceOcean) system by providing an ID and an array of elements that you would like to update, as parameters into a static function `updateInvoice()` of `FakturaXL` static helper class:

```php
FakturaXL::updateInvoice(1234566789, array(
    'kind' => FakturaXLInvoiceKind::PROFORMA,
    'buyer_name' => 'John Wick'
    'buyer_company' => '0'
));
```

<br/>

### <a id="6-4"></a>Changing invoice status in FakturaXL

Use `FakturaXL` helper class to change status of specific invoice by using static function `changeInvoiceStatus()`. You will have to provide of of the invoice and name of the status you want to set. We recommend using helper class `FakturaXLInvoiceStatus` to see available options for invoice status. An example below shows how to chance status of the invoice :

```php
use blizni\FXL\Helpers\FakturaXLInvoiceStatus;

// Changing invoice status to issued
FakturaXL::changeInvoiceStatus(1234567890, "issued");

// Changing invoice status to paid with helper class
FakturaXL::changeInvoiceStatus(1234567890, FakturaXLInvoiceStatus::PAID);
```

<br/>

### <a id="6-5"></a>Deleting target invoice from FakturaXL database

To simply delete an invoice from your system use `deleteInvoice()` static function of `FakturaXL` helper class. Remember to pass an ID of the invoice as a parameter of the function! Have a look at example shown below:

```php
FakturaXL::deleteInvoice(1234566789);
```

<br/>

### <a id="6-6"></a>Printing invoices in PDF format

To download a print of your invoice in a PDF format you can use a static method from `FakturaXL` helper called `printInvoice()`. This function requires to provide two elements as it's arguments - the invoice ID and name of the printed PDF file:

```php
return FakturaXL::printInvoice(123456789, "Print name");
```

This method returns a Laravel response object in a form of `streamDownload()` method.

<br/>

### <a id="6-7"></a>Creating raw print

You're also able to get the raw data for the print by calling static function `printInvoiceRaw()` from `FakturaXL` helper class. Just remember to specify the invoice ID as a first parameter of the function:

```php
$rawData = FakturaXL::printInvoiceRaw(123456789);
```

---
