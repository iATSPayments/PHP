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
   * Process an ACH / EFT transaction and return Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'firstName' => 'Test' // The customer's first name.
   *     'lastName' => 'Account' // The customer's last name.
   *     'address' => '1234 Any Street' // The customer's address.
   *     'city' => 'Schenectady' // The customer's city.
   *     'state' => 'NY' // The customer's state or province.
   *     'zipCode' => '12345' // The customer's ZIP code.
   *     'accountNum' => '02100002100000000000000001' // The customer's bank account number.
   *     'accountType' => 'CHECKING' // The customer's bank account type.
   *      // Options: CHECKING, SAVING (North America only.)
   *     'invoiceNum' => '00000001' // Optional. The invoice number for this transaction.
   *     'total' => '5' // The total payment amount.
   *     'comment' => 'Process ACH / EFT test.' // Optional. A comment describing this transaction.
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
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'invoiceNum' => '00000001' // Optional. The invoice number for this transaction.
   *     'ccNum' => '4222222222222220' // The customer's credit card number.
   *     'ccExp' => '12/17' // The customer's credit card expiration date.
   *     'firstName' => 'Test' // The customer's first name.
   *     'lastName' => 'Account' // The customer's last name.
   *     'address' => '1234 Any Street' // The customer's address.
   *     'city' => 'Schenectady' // The customer's city.
   *     'state' => 'NY' // The customer's state or province.
   *     'zipCode' => '12345' // The customer's ZIP code.
   *     'cvv2' => '000' // Optional. The customer's credit card CVV2 code.
   *     'total' => '5' // The total payment amount.
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
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'batchId' => '1' // The ID of the existing iATS batch process.
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function getBatchProcessResultFile($parameters) {
    $response = $this->apiCall('GetBatchProcessResultFile', $parameters);
    return $this->responseHandler($response, 'GetBatchProcessResultFileV1Result');
  }

  /**
   * Process a number of ACH / EFT transactions from a batch file.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'batchFile' => {base64Binary file} // CSV file encoded using base64_encode.
   *      // File format without Customer Codes:
   *      //  Invoice #, First Name, Last Name, Account Type, Account # (no spaces or dashes), Amount (no $), Comment
   *      // File format with Customer Codes:
   *      //  Invoice #, Customer Code, Amount, Comment
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processACHEFTChargeBatch($parameters) {
    $response = $this->apiCall('ProcessACHEFTChargeBatch', $parameters);
    return $this->responseHandler($response, 'ProcessACHEFTChargeBatchV1Result');
  }

  /**
   * Process a number of ACH / EFT refund transactions from a batch file.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'batchFile' => {base64Binary file} // CSV file encoded using base64_encode.
   *      // File format without Customer Codes:
   *      //  Invoice #, First Name, Last Name, Account Type, Account # (no spaces or dashes), Amount (no $), Comment
   *      // File format with Customer Codes:
   *      //  Invoice #, Customer Code, Amount, Comment
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processACHEFTRefundBatch($parameters) {
    $response = $this->apiCall('ProcessACHEFTRefundBatch', $parameters);
    return $this->responseHandler($response, 'ProcessACHEFTRefundBatchV1Result');
  }

  /**
   * Refund a specific ACH / EFT transaction.
   * Partial refunds are valid.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'transactionId' => '0000001' // The ID of the transaction to refund.
   *     'total' => '-10' // The amount to refund. Must be a negative number.
   *     'comment' => 'ACH / EFT refund test.' // Optional. A comment describing this transaction.
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processACHEFTRefundWithTransactionId($parameters) {
    $response = $this->apiCall('ProcessACHEFTRefundWithTransactionId', $parameters);
    return $this->responseHandler($response, 'ProcessACHEFTRefundWithTransactionIdV1Result');
  }

  /**
   * Process an ACH / EFT transaction using an existing account, without using a Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'invoiceNum' => '00000001' // Optional. The invoice number for this transaction.
   *     'accountNum' => '02100002100000000000000001' // The customer's bank account number.
   *     'accountType' => 'CHECKING' // The customer's bank account type.
   *      // Options: CHECKING, SAVING (North America only.)
   *     'firstName' => 'Test' // Optional. The customer's first name.
   *     'lastName' => 'Account' // Optional. The customer's last name.
   *     'address' => '1234 Any Street' // Optional. The customer's address.
   *     'city' => 'Schenectady' // Optional. The customer's city.
   *     'state' => 'NY' // Optional. The customer's state or province.
   *     'zipCode' => '12345' // Optional. The customer's ZIP code.
   *     'total' => '5' // The total payment amount.
   *     'comment' => 'Process ACH / EFT test.' // Optional. A comment describing this transaction.
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function processACHEFT($parameters) {
    $response = $this->apiCall('ProcessACHEFT', $parameters);
    return $this->responseHandler($response, 'ProcessACHEFTV1Result');
  }

  /**
   * Process an ACH / EFT transaction using an existing account using a Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *     'customerCode' => '' // The iATS Customer Code.
   *     'invoiceNum' => '00000001' // Optional. The invoice number for this transaction.
   *     'total' => '5' // The total payment amount.
   *     'comment' => 'Process ACH / EFT test.' // Optional. A comment describing this transaction.
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
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *     'batchFile' => {base64Binary file} // CSV file encoded using base64_encode.
   *      // File format without Customer Codes for US and UK clients:
   *      //  Date, Invoice #, First Name, Last Name, Street, City, State, Zip Code, Amount, MOP, Credit Card #, Expiry
   *      // File format without Customer Codes for Canadian clients:
   *      //  Date, Invoice #, Full Name, Amount, MOP, Credit Card #, Expiry
   *      // File format with Customer Codes:
   *      //  Invoice #, Customer Code, Amount, Comment
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
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *     'transactionId' => '0000001' // The ID of the transaction to refund.
   *     'total' => '-10' // The total amount to refund. Must be a negative number.
   *     'comment' => 'Credit card refund test.' // Optional. A comment describing this transaction.
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
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *     'invoiceNum' => '00000001' // Optional. The invoice number for this transaction.
   *     'creditCardNum' => '4222222222222220' // The customer's credit card number.
   *     'creditCardExpiry' => '12/17' // The customer's credit card expiration date. MM/YY.
   *     'cvv2' => '000' // The customer's credit card CVV2 code.
   *     'mop' => 'VISA' // The customer's method of payment.
   *      // North America options: VISA, MC, AMX, DSC
   *      // UK options: VISA, MC, AMX, MAESTR
   *     'firstName' => 'Test' // The customer's first name.
   *     'lastName' => 'Account' // The customer's last name.
   *     'address' => '1234 Any Street' // The customer's address.
   *     'city' => 'Schenectady' // The customer's city.
   *     'state' => 'NY' // The customer's state or province.
   *     'zipCode' => '12345' // The customer's ZIP code.
   *     'total' => '5' // The total payment amount.
   *     'comment' => 'Process credit card test.' // Optional. A comment describing this transaction.
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
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *     'customerCode' => '' // The iATS Customer Code.
   *     'invoiceNum' => '00000001' // Optional. The invoice number for this transaction.
   *     'cvv2' => '000' // Optional. The customer's credit card CVV2 code.
   *     'total' => '5' // The total payment amount.
   *     'comment' => 'Process credit card test with Customer Code.' // Optional. A comment describing this transaction.
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

    $parsedResult = FALSE;

    // Check for regular process result.
    if (isset($result['PROCESSRESULT'])) {
      $parsedResult = $result['PROCESSRESULT'];
    }
    // Check for batch process result.
    else if (isset($result['BATCHPROCESSRESULT']))
    {
      $parsedResult = $result['BATCHPROCESSRESULT'];
    }

    // Check auth result.
    if ($parsedResult && isset($parsedResult['AUTHORIZATIONRESULT']))
    {
      // Handle reject codes.
      if (strpos($parsedResult['AUTHORIZATIONRESULT'], 'REJECT') !== FALSE) {
        $reject_code = preg_replace("/[^0-9]/", "", $parsedResult['AUTHORIZATIONRESULT']);
        return $this->reject($reject_code);
      }
    }
    else
    {
      // If result hasn't been parsed, return exactly as returned by the API.
      $parsedResult = $result;
    }

    return $parsedResult;
  }
}
