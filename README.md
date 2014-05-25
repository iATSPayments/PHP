# iATS PHP API Wrapper

A PHP wrapper for the iATS SOAP API.

iATS Web Services provide the facility to securely process payments using credit cards, ACH, or direct debit through your website or software.

Full wrapper documentation: http://iatspayments.github.io/PHP/

iATS Web Services [overview](https://na10.salesforce.com/sfc/p/#A0000000ZyVz/a/F00000008Qfp/68aOuqxOzcey6QbODvM9qyHG9fVgDtuWrkCDr84._WY=)

## Requirements

* An account with [iATS Payments](http://www.iatspayments.com/)
    * [Request an account](http://home.iatspayments.com/iats-php-wrapper)
* NB! If you are already an iATS customer, please contact us to verify your Account settings
    * The PHP wrapper requires certain features to be set up to your existing account
    * Please [contact us](http://home.iatspayments.com/iats-php-wrapper) with your Client Code
* PHP 5.3.3 or greater
* SOAP enabled in your PHP installation

### Optional Requirements

Optional requirements can be installed using Composer.

* [PHPUnit](http://phpunit.de/) (for unit testing)
* [phpDocumentor](http://www.phpdoc.org/) (for generating documentation files)

## Installation

### Using Git

* Clone the Git repository

  `$ git clone git@github.com:iATSPayments/PHP.git iATSPaymentsPHP`

### Downloading Directly

* Download the latest [PHP wrapper release](https://github.com/iATSPayments/PHP/releases)
* Extract the archive to a local directory (e.g. iATSPaymentsPHP)

### Installing Optional Requirements

* Run the Composer installation to retrieve optional requirements for unit testing and documentation generation.

  `$ cd iATSPaymentsPHP`

  `$ composer install`

See the **Usage Examples** section for help integrating the wrapper in your application.

## Running PHPUnit Tests

Unit tests can be run using PHPUnit.

* Open `phpunit.xml` and set the values of **IATS_AGENT_CODE** and **IATS_PASSWORD** to your iATS API credentials.

* After installing PHPUnit via Composer, tests can be run using the following command in the wrapper root directory:

  `$ ./vendor/bin/phpunit`

## Wrapper Components

iATS Web Services and this wrapper are broken up into three components.

### Core

The core represents the base of all other services. It is responsible for connecting to the iATS API, making API calls,
and error handling. The core also handles API restrictions on location-specific services and currency, preventing
invalid calls being made to the API.

### CustomerLink

The CustomerLink service is used to create and update customer records. CustomerLink may be used with the
ProcessLink service to process single or recurring transactions for customers.

**iATS documentation**
* Request / response overview: https://www.iatspayments.com/NetGate/CustomerLink.asmx
* Detailed service [guide](https://na10.salesforce.com/sfc/p/#A0000000ZyVz/a/F00000008Qfp/68aOuqxOzcey6QbODvM9qyHG9fVgDtuWrkCDr84._WY=)

### ProcessLink

The ProcessLink service is used to process single, recurring and bulk transactions for customers. ProcessLink can
also be used to refund transactions.

**iATS documentation**
* Request / response overview: https://www.iatspayments.com/NetGate/ProcessLink.asmx
* Detailed service [guide](https://na10.salesforce.com/sfc/p/#A0000000ZyVz/a/F00000008Qfp/68aOuqxOzcey6QbODvM9qyHG9fVgDtuWrkCDr84._WY=)

### ReportLink

The ReportLink service is used to generate transaction reports for the other services. Available reports include
credit / debit card transactions, rejected transactions and returns.

**iATS documentation**
* Request / response overview: https://www.iatspayments.com/NetGate/ReportLink.asmx
* Detailed service [guide](https://na10.salesforce.com/sfc/p/#A0000000ZyVz/a/F00000008Qfp/68aOuqxOzcey6QbODvM9qyHG9fVgDtuWrkCDr84._WY=)

## Usage Examples

### Use Case 1 - CustomerLink - Creating a new Customer Code for credit card transactions

```php
include '/path/to/wrapper/lib/Core.php';
include '/path/to/wrapper/lib/CustomerLink.php';

// Create and populate the request object.
$request = array(
  'customerIPAddress' => '',
  'customerCode' => '',
  'firstName' => 'Test',
  'lastName' => 'Account',
  'companyName' => 'Test Co.',
  'address' => '1234 Any Street',
  'city' => 'City',
  'state' => 'NY',
  'zipCode' => '12345',
  'phone' => '555-555-1234',
  'fax' => '555-555-4321',
  'alternatePhone' => '555-555-5555',
  'email' => 'email@test.co',
  'comment' => 'Customer code creation test.',
  'recurring' => FALSE,
  'amount' => '5',
  'beginDate' => '2014-07-01T00:00:00+00:00',
  'endDate' => '2014-08-01T00:00:00+00:00',
  'scheduleType' => 'Annually',
  'scheduleDate' => '',
  'creditCardCustomerName' => 'Test Account',
  'creditCardNum' => '4222222222222220',
  'creditCardExpiry' => '12/17',
  'mop' => 'VISA',
  'currency' => 'USD',
);

// Make the API call using the CustomerLink service.
$iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
$response = $iats->createCreditCardCustomerCode($request);

// Verify successful call.
if (trim($response['AUTHORIZATIONRESULT']) == 'OK')
{
  // Assign the new Customer Code to a new variable.
  $creditCardCustomerCode = $response['CUSTOMERCODE'];

  // Perform successful call logic.
}
```

### Use Case 2 - CustomerLink - Processing a credit card transation with an existing Customer Code

```php
include '/path/to/wrapper/lib/Core.php';
include '/path/to/wrapper/lib/ProcessLink.php';

// Create and populate the request object.
$request = array(
  'customerIPAddress' => '',
  'customerCode' => self::$creditCardCustomerCode,
  'invoiceNum' => '00000001',
  'cvv2' => '000',
  'mop' => 'VISA',
  'total' => '5',
  'comment' => 'Process CC test with Customer Code.',
  'currency' => 'USD',
);

// Make the API call using the ProcessLink service.
$iats = new ProcessLink(self::$agentCode, self::$password);
$response = $iats->processCreditCardWithCustomerCode($request);

// Verify successful call.
if (trim($response['AUTHORIZATIONRESULT']) == 'OK')
{
  // Perform successful call logic.
}
```

### Use Case 3 - ReportLink - Get credit card transation history report as CSV

```php
include '/path/to/wrapper/lib/Core.php';
include '/path/to/wrapper/lib/ReportLink.php';

// Create and populate the request object.
$request = array(
  'fromDate' => '2014-07-01T00:00:00+00:00',
  'toDate' => '2014-08-01T00:00:00+00:00',
  'customerIPAddress' => '',
);

// Make the API call using the ReportLink service.
$iats = new ReportLink(self::$agentCode, self::$password);
$response = $iats->getCreditCardPaymentBoxJournalCSV($request);

// Response should be CSV data starting with "Transaction ID,Invoice Number,Date Time"
```
