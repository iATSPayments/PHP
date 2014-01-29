<?php

namespace iATS;

/**
 * Class IATSProcessLink
 */
class ProcessLink extends Core {

  public function __construct($agentcode, $password, $server_id = 'NA') {
    parent::__construct($agentcode, $password, $server_id);
    $this->$endpoint = '/NetGate/ProcessLink.asmx?WSDL';
  }

  /**
   * Process a credit card transation.
   *
   * @param $parameters
   *   An associative array with the following possible values.
   * @code
   *     $request = array(
   *       'customerIPAddress' => '',
   *       'invoiceNum' => '00000001',
   *       'creditCardNum' => '4222222222222220',
   *       'creditCardExpiry' => '12/17',
   *       'cvv2' => '000',
   *       'mop' => 'VISA',
   *       'firstName' => 'Test',
   *       'lastName' => 'Account',
   *       'address' => '1234 Any Street',
   *       'city' => 'Schenectady',
   *       'state' => 'NY',
   *       'zipCode' => '12345',
   *       'total' => '2',
   *       'comment' => 'Process CC test.',
   *       // Not needed for request.
   *       'currency' => 'USD',
   *     );
   * @endcode
   *
   * @return mixed
   */
  public function processCreditCard($parameters) {
    $response = $this->apiCall('ProcessCreditCard', $parameters);
    return $this->responseHandler($response, 'ProcessCreditCardV1Result');
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
   *
   * @return mixed
   *   Response
   */
  public function responseHandler($response, $result_name) {
    $result = xmlstr_to_array($response->$result->any);
    return $result;
  }
}