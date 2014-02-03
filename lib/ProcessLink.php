<?php
/**
 * @file
 * ProcessLink class file.
 */

namespace iATS;

/**
 * Class ProcessLink
 *
 * @package iATS
 */
class ProcessLink extends Core {
  /**
   * ProcessLink constructor.
   *
   * @param string $agentcode
   *   Agent code.
   * @param string $password
   *   Password.
   * @param string $server_id
   *   Server ID ('UK' or 'NA'. Defaults to 'NA')
   */
  public function __construct($agentcode, $password, $server_id = 'NA') {
    parent::__construct($agentcode, $password, $server_id);
    $this->endpoint = '/NetGate/ProcessLink.asmx?WSDL';
  }

  /**
   * Process a credit card transaction.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
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
   *   Response.
   */
  public function processCreditCard($parameters) {
    $response = $this->apiCall('ProcessCreditCard', $parameters);
    return $this->responseHandler($response, 'ProcessCreditCardV1Result');
  }

  /**
   * Process a credit card transaction with Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
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
   *   Response.
   */
  public function processCreditCardWithCustomerCode($parameters) {
    $response = $this->apiCall('ProcessCreditCardWithCustomerCode', $parameters);
    return $this->responseHandler($response, 'ProcessCreditCardWithCustomerCodeV1Result');
  }

  /**
   * Process a credit card transaction and return Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
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
   *   Response.
   */
  public function createCustomerCodeAndProcessCreditCard($parameters) {
    $response = $this->apiCall('CreateCustomerCodeAndProcessCreditCard', $parameters);
    return $this->responseHandler($response, 'CreateCustomerCodeAndProcessCreditCardV1Result');
  }

  /**
   * Response Handler for ProcessLink calls.
   *
   * @param array|bool $response
   *   SOAP response.
   * @param string $result_name
   *   API result name.
   *
   * @return mixed
   *   Results.
   */
  public function responseHandler($response, $result_name) {
    // Check restrictions.
    if ($this->checkServerRestrictions($this->server_id, $this->restrictedservers)) {
      return 'Service cannot be used on this server.';
    }

    $currency = isset($this->params['currency']) ? $this->params['currency'] : NULL;
    $mop = isset($this->params['mop']) ? $this->params['mop'] : NULL;
    if ($this->checkMOPCurrencyRestrictions($this->server_id, $currency, $mop)) {
      return 'Service cannot be used with this Method of Payment or Currency.';
    }

    $result = $this->xml2array($response->$result_name->any);
    // Handle auth failure.
    if ($result['STATUS'] == 'Failure') {
      return $result['ERRORS'];
    }
    // Handle reject codes.
    else {
      $authresult = $result['PROCESSRESULT']['AUTHORIZATIONRESULT'];
      // Process reject codes.
      if (strpos($authresult, 'REJECT') !== FALSE) {
        $reject_code = preg_replace("/[^0-9]/", "", $authresult);
        return $this->reject($reject_code);
      }
    }

    return $result;
  }
}
