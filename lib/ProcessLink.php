<?php

namespace iATS;

/**
 * Class IATSProcessLink
 */
class ProcessLink extends Service {
  public $endpoint = '/NetGate/ProcessLink.asmx?WSDL';

  /**
   * Sets properties for the ProcessCreditCardV1 method.
   */
  public function processCC() {
    $this->method = 'ProcessCreditCard';
    $this->result = 'ProcessCreditCardV1Result';
    $this->format = 'AR';
  }

  /**
   * Sets properties for the ProcessCreditCardWithCustomerCodeV1 method.
   */
  public function processCCwithCustCode() {
    $this->method = 'ProcessCreditCardWithCustomerCode';
    $this->result = 'ProcessCreditCardWithCustomerCodeV1Result';
    $this->format = 'AR';
  }

  /**
   * Sets properties for the CreateCustomerCodeAndProcessCreditCardV1 method.
   */
  public function createCustCodeProcessCC() {
    $this->method = 'CreateCustomerCodeAndProcessCreditCard';
    $this->result = 'CreateCustomerCodeAndProcessCreditCardV1Result';
    $this->format = 'AR';
  }

  /**
   * Response Handler for ProcessLink calls.
   *
   * @param array $response
   *   Response
   * @param string $result
   *   Result string
   * @param string  $format
   *   Output format
   *
   * @return mixed
   *   Response
   */
  public function responseHandler($response, $result, $format) {
    $result = xmlstr_to_array($response->$result->any);
//    if ($result['PROCESSRESULT']['AUTHORIZATIONRESULT'] == 'REJECT: 1') {
//      $resp = 'Bad Credentials';
//    }
//    else {
//      $resp = $result;
//    }
    return $result;
  }
}