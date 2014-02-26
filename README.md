# iATS PHP API Wrapper

A PHP wrapper for the iATS SOAP API.

iATS Web Services provide the facility to securely process payments using credit cards, ACH, or direct debit through your website or software.

Full wrapper documentation: http://iatspayments.github.io/PHP/

iATS Web Services overview: http://home.iatspayments.com/sites/default/files/iats_webservices_overview_version_4.0_0.pdf

## Requirements

* An account with iATS Payments http://www.iatspayments.com/
* To request an account http://home.iatspayments.com/iats-php-wrapper
* NB! If you are already an iATS customer, please contact us to verify your Account settings
    * The PHP wrapper requires certain features to be set up to your existing account
    * Please contact us http://home.iatspayments.com/iats-php-wrapper with your Client Code
* PHP 5.3.0 or greater
* SOAP enabled in your PHP installation

### Optional Requirements

* PHPUnit (for unit testing) http://phpunit.de/
* phpDocumentor (for generating documentation files) http://www.phpdoc.org/

## Installation

`$ git clone git@github.com:iATSPayments/PHP.git iATSPaymentsPHP`

`$ cd iATSPaymentsPHP`

`$ composer install`

Open phpunit.xml and set the values of **IATS_AGENT_CODE** and **IATS_PASSWORD** to your iATS API credentials.

## Tests

Unit tests can be run using PHPUnit.

`$ ./vendor/bin/phpunit`

## Components

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
* Detailed service guide: http://home.iatspayments.com/sites/default/files/iats_webservices_customerlink_version_4.0.pdf

### ProcessLink

The ProcessLink service is used to process single, recurring and bulk transactions for customers. ProcessLink can
also be used to refund transactions.

**iATS documentation**
* Request / response overview: https://www.iatspayments.com/NetGate/ProcessLink.asmx
* Detailed service guide: http://home.iatspayments.com/sites/default/files/iats_webservices_processlink_version_4.0.pdf

### ReportLink

The ReportLink service is used to generate transaction reports for the other services. Available reports include
credit / debit card transactions, rejected transactions and returns.

**iATS documentation**
* Request / response overview: https://www.iatspayments.com/NetGate/ReportLink.asmx
* Detailed service guide: http://home.iatspayments.com/sites/default/files/iats_webservices_reportlink_version_4.0.pdf

## Usage

### Use Case 1 - CustomerLink - Creating a new Customer Code for credit card transactions

```php
$beginDate = strtotime('01/01/2014');
$endDate = strtotime('01/31/2014');

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
  'beginDate' => $beginDate,
  'endDate' => $endDate,
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
$beginDate = strtotime('01/01/2014');
$endDate = strtotime('01/31/2014');

// Create and populate the request object.
$request = array(
  'fromDate' => $fromDate,
  'toDate' => $toDate,
  'customerIPAddress' => '',
);

// Make the API call using the ReportLink service.
$iats = new ReportLink(self::$agentCode, self::$password);
$response = $iats->getCreditCardPaymentBoxJournalCSV($request);

// Response should be CSV data starting with "Transaction ID,Invoice Number,Date Time"
```
