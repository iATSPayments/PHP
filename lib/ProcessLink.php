<?php
/**
 * ProcessLink class file.
 * Targeting iATS API version 1.0.
 *
 * The ProcessLink service is used to process single, recurring, or batch transactions,
 * and to process refunds.
 *
 * The ProcessLink can process transactions using existing customer codes created via
 * the CustomerLink service, ProcessLink may also be used to create new customer codes
 * as part of an initial transaction.
 *
 * API documentation: https://www.iatspayments.com/NetGate/ProcessLink.asmx
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

  /**
   * Get the results of a preview batch request.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'customerIPAddress' => '',
   *     'batchId' => '1',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function getBatchProcessResultFile($parameters) {
    $response = $this->apiCall('GetBatchProcessResultFile', $parameters);
    return $this->responseHandler($response, 'GetBatchProcessResultFileV1Result');
  }

  /**
   * Process a number of direct debit transactions from a batch file.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'customerIPAddress' => '',
   *     'batchFile' => {base64Binary file},
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processACHEFTChargeBatch($parameters) {
    $response = $this->apiCall('ProcessACHEFTChargeBatch', $parameters);
    return $this->responseHandler($response, 'ProcessACHEFTChargeBatchV1Result');
  }

  /**
   * Process a number of direct debit refund transactions from a batch file.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'customerIPAddress' => '',
   *     'batchFile' => {base64Binary file},
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processACHEFTRefundBatch($parameters) {
    $response = $this->apiCall('ProcessACHEFTRefundBatch', $parameters);
    return $this->responseHandler($response, 'ProcessACHEFTRefundBatchV1Result');
  }

  /**
   * Refund a specific direct debit transaction.
   * Partial refunds are valid.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'customerIPAddress' => '',
   *     'transactionId' => '0000001',
   *     'total' => '-10', // Must be a negative number.
   *     'comment' => 'ACH / EFT refund test.',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processACHEFTRefundWithTransactionId($parameters) {
    $response = $this->apiCall('ProcessACHEFTRefundWithTransactionId', $parameters);
    return $this->responseHandler($response, 'ProcessACHEFTRefundWithTransactionIdV1Result');
  }

  /**
   * Process a direct debit transaction using an existing account,
   * without using a Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'customerIPAddress' => '',
   *     'invoiceNum' => '00000001',
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
  public function processACHEFT($parameters) {
    $response = $this->apiCall('ProcessACHEFT', $parameters);
    return $this->responseHandler($response, 'ProcessACHEFTV1Result');
  }

  /**
   * Process a direct debit transaction using an existing account using
   * a Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'customerIPAddress' => '',
   *     'customerCode' => '',
   *     'invoiceNum' => '00000001',
   *     'total' => '5',
   *     'comment' => 'Process direct debit test.',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processACHEFTWithCustomerCode($parameters) {
    $response = $this->apiCall('ProcessACHEFTWithCustomerCode', $parameters);
    return $this->responseHandler($response, 'ProcessACHEFTWithCustomerCodeV1Result');
  }

  /**
   * Process multiple credit card transactions from a batch file.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'customerIPAddress' => '',
   *     'batchFile' => {base64Binary file},
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processCreditCardBatch($parameters) {
    $response = $this->apiCall('ProcessCreditCardBatch', $parameters);
    return $this->responseHandler($response, 'ProcessCreditCardBatchV1Result');
  }

  /**
   * Refund a specific credit card transaction.
   * Partial refunds are valid.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'customerIPAddress' => '',
   *     'transactionId' => '0000001',
   *     'total' => '-10', // Must be a negative number.
   *     'comment' => 'Credit card refund test.',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processCreditCardRefundWithTransactionId($parameters) {
    $response = $this->apiCall('ProcessCreditCardRefundWithTransactionId', $parameters);
    return $this->responseHandler($response, 'ProcessCreditCardRefundWithTransactionIdV1Result');
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
   *     'total' => '5',
   *     'comment' => 'Process CC test.',
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
   *     'customerCode' => '',
   *     'invoiceNum' => '00000001',
   *     'cvv2' => '000',
   *     'total' => '5',
   *     'comment' => 'Process CC test with Customer Code.',
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
