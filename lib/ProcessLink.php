<?php
/**
 * ProcessLink class file.
 * Targeting iATS API version 1.0.
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
   *   iATS account agent code.
   * @param string $password
   *   iATS account password.
   * @param string $serverid
   *   Server identifier (Defaults to 'NA').
   *   \see setServer()
   */
  public function __construct($agentcode, $password, $serverid = 'NA') {
    parent::__construct($agentcode, $password, $serverid);
    $this->endpoint = '/NetGate/ProcessLink.asmx?WSDL';
  }

  /**
   * Process a direct debit transaction and return Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'customerIPAddress' => '',
   *     'firstName' => 'Test',
   *     'lastName' => 'Account',
   *     'address' => '1234 Any Street',
   *     'city' => 'Schenectady',
   *     'state' => 'NY',
   *     'zipCode' => '12345',
   *     'accountNum' => '02100002100000000000000001',
   *     'accountType' => 'CHECKING',
   *     'invoiceNum' => '00000001',
   *     'total' => '5',
   *     'comment' => 'Process direct debit test.',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function createCustomerCodeAndProcessACHEFT($parameters) {
    $response = $this->apiCall('CreateCustomerCodeAndProcessACHEFT', $parameters);
    return $this->responseHandler($response, 'CreateCustomerCodeAndProcessACHEFTV1Result');
  }

  /**
   * Process a credit card transaction and return Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'customerIPAddress' => '',
   *     'invoiceNum' => '00000001',
   *     'ccNum' => '4222222222222220',
   *     'ccExp' => '12/17',
   *     'firstName' => 'Test',
   *     'lastName' => 'Account',
   *     'address' => '1234 Any Street',
   *     'city' => 'Schenectady',
   *     'state' => 'NY',
   *     'zipCode' => '12345',
   *     'cvv2' => '000',
   *     'total' => '5',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function createCustomerCodeAndProcessCreditCard($parameters) {
    $response = $this->apiCall('CreateCustomerCodeAndProcessCreditCard', $parameters);
    return $this->responseHandler($response, 'CreateCustomerCodeAndProcessCreditCardV1Result');
  }

  public function getBatchProcessResultFile($parameters) {

  }

  public function processACHEFTChargeBatch($parameters) {

  }

  public function processACHEFTRefundBatch($parameters) {

  }

  public function processACHEFTRefundWithTransactionId($parameters) {

  }

  public function processACHEFT($parameters) {

  }

  public function processACHEFTWithCustomerCode($parameters) {

  }

  public function processCreditCardBatch($parameters) {

  }

  public function processCreditCardRefundWithTransactionId($parameters) {

  }

  /**
   * Process a credit card transaction.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'customerIPAddress' => '',
   *     'invoiceNum' => '00000001',
   *     'creditCardNum' => '4222222222222220',
   *     'creditCardExpiry' => '12/17',
   *     'cvv2' => '000',
   *     'mop' => 'VISA',
   *     'firstName' => 'Test',
   *     'lastName' => 'Account',
   *     'address' => '1234 Any Street',
   *     'city' => 'Schenectady',
   *     'state' => 'NY',
   *     'zipCode' => '12345',
   *     'total' => '2',
   *     'comment' => 'Process CC test.',
   *     // Not needed for request.
   *     'currency' => 'USD',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processCreditCard($parameters) {
    $this->restrictedservers = array('UK');
    $restricted = $this->checkRestrictions($parameters);
    if ($restricted) {
      return $restricted;
    }
    else {
      $response = $this->apiCall('ProcessCreditCard', $parameters);
      return $this->responseHandler($response, 'ProcessCreditCardV1Result');
    }
  }

  /**
   * Process a credit card transaction with Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'customerIPAddress' => '',
   *     'invoiceNum' => '00000001',
   *     'creditCardNum' => '4222222222222220',
   *     'creditCardExpiry' => '12/17',
   *     'cvv2' => '000',
   *     'mop' => 'VISA',
   *     'firstName' => 'Test',
   *     'lastName' => 'Account',
   *     'address' => '1234 Any Street',
   *     'city' => 'Schenectady',
   *     'state' => 'NY',
   *     'zipCode' => '12345',
   *     'total' => '2',
   *     'comment' => 'Process CC test.',
   *     // Not needed for request.
   *     'currency' => 'USD',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processCreditCardWithCustomerCode($parameters) {
    $response = $this->apiCall('ProcessCreditCardWithCustomerCode', $parameters);
    return $this->responseHandler($response, 'ProcessCreditCardWithCustomerCodeV1Result');
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
   *   Restriction, error or API result.
   */
  public function responseHandler($response, $result_name) {
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
