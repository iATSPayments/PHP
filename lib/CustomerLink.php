<?php

namespace iATS;

/**
 * Class IATSCustomerLink
 */
class CustomerLink extends Service {
  public $endpoint = '/NetGate/CustomerLink.asmx?WSDL';

  /**
   * Sets properties for the GetCustomerCodeDetailV1 method.
   */
  public function getCustCode() {
    $this->method = 'GetCustomerCodeDetail';
    $this->result = 'GetCustomerCodeDetailV1Result';
    $this->format = 'AR';
  }

  /**
   * Sets properties for the CreateCreditCardCustomerCodeV1 method.
   */
  public function createCustCodeCC() {
    $this->method = 'CreateCreditCardCustomerCode';
    $this->result = 'CreateCreditCardCustomerCodeV1Result';
    $this->format = 'AR';
  }

  /**
   * Response Handler for CustomerLink calls.
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
    return $result;
  }
}

