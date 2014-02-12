# iATS PHP API Wrapper

A PHP wrapper for the iATS SOAP API.

iATS Web Services provide the facility to securely process payments using credit cards, ACH, or direct debit through your website or software.

## Requirements

* PHP 5.3.0 or greater
* PHPUnit (for unit testing) http://phpunit.de/
* SOAP enabled in your PHP installation
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

### CustomerLink

The CustomerLink service is used to create and update customer records. CustomerLink may be used with the
ProcessLink service to process single or recurring transactions for customers.

### ProcessLink

The ProcessLink service is used to process single, recurring and bulk transactions for customers. ProcessLink can
also be used to refund transactions.

### ReportLink

The ReportLink service is used to generate transaction reports for the other services. Available reports include
credit / debit card transactions, rejected transactions and returns.

## Usage

