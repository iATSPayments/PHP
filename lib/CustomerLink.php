<?php
/**
 * CustomerLink class file.
 * Targeting iATS API version 1.0.
 *
 * The CustomerLink service is used to create secure customer codes that may be
 * used with the ProcessLink service to process single or recurring credit card
 * or ACH / EFT transactions.
 *
 * Once created, customer codes may be reused, removing the need to store sensitive
 * credit card or ACH information on local servers.
 *
 * API documentation: https://www.iatspayments.com/NetGate/CustomerLink.asmx
 *                UK: https://www.uk.iatspayments.com/NetGate/CustomerLink.asmx
 * ACH documentation: http://en.wikipedia.org/wiki/Automated_Clearing_House
 * EFT documentation: http://en.wikipedia.org/wiki/Electronic_funds_transfer
 */

namespace iATS;

/**
 * Class CustomerLink
 *
 * @package iATS
 */
class CustomerLink extends Core {
  /**
   * CustomerLink constructor.
   *
   * @param string $agentcode
   *   iATS account agent code.
   * @param string $password
   *   iATS account password.
   * @param string $serverid
   *   Server identifier (Defaults to 'NA')
   *   \see serServer()
   */
  public function __construct($agentcode, $password, $serverid = 'NA') {
    parent::__construct($agentcode, $password, $serverid);
    $this->endpoint = '/NetGate/CustomerLink.asmx?WSDL';
  }

  /**
   * Get Customer Code Detail.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'customerIPAddress' => '',
   *     'customerCode' => 'A10396688',
   *     // Not needed for request.
   *     'mop' => 'VISA',
   *     'currency' => 'USD',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function getCustomerCodeDetail($parameters) {
    $response = $this->apiCall('GetCustomerCodeDetail', $parameters);
    return $this->responseHandler($response, 'GetCustomerCodeDetailV1Result');
  }

  /**
   * Create Credit Card Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'customerIPAddress' => '',
   *     'customerCode' => '',
   *     'firstName' => 'Test',
   *     'lastName' => 'Account',
   *     'companyName' => 'Test Co.',
   *     'address' => '1234 Any Street',
   *     'city' => 'Schenectady',
   *     'state' => 'NY',
   *     'zipCode' => '12345',
   *     'phone' => '555-555-1234',
   *     'fax' => '555-555-4321',
   *     'alternatePhone' => '555-555-5555',
   *     'email' => 'email@test.co',
   *     'comment' => 'Customer code creation test.',
   *     'recurring' => FALSE,
   *     'amount' => '5',
   *     'beginDate' => 946684800,
   *     'endDate' => 946771200,
   *     'scheduleType' => 'Annually',
   *     'scheduleDate' => '',
   *     'creditCardCustomerName' => 'Test Account',
   *     'creditCardNum' => '4222222222222220',
   *     'creditCardExpiry' => '12/17',
   *     'mop' => 'VISA',
   *     // Not required.
   *     'currency' => 'USD',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function createCreditCardCustomerCode($parameters) {
    $response = $this->apiCall('CreateCreditCardCustomerCode', $parameters);
    return $this->responseHandler($response, 'CreateCreditCardCustomerCodeV1Result');
  }

  /**
   * Update Credit Card Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'customerIPAddress' => '',
   *     'customerCode' => '',
   *     'firstName' => 'Test',
   *     'lastName' => 'Account',
   *     'companyName' => 'Test Co.',
   *     'address' => '1234 Any Street',
   *     'city' => 'Schenectady',
   *     'state' => 'NY',
   *     'zipCode' => '12345',
   *     'phone' => '555-555-1234',
   *     'fax' => '555-555-4321',
   *     'alternatePhone' => '555-555-5555',
   *     'email' => 'email@test.co',
   *     'comment' => 'Customer code update test.',
   *     'recurring' => FALSE,
   *     'amount' => '5',
   *     'beginDate' => 946684800,
   *     'endDate' => 946771200,
   *     'scheduleType' => 'Annually',
   *     'scheduleDate' => '',
   *     'creditCardCustomerName' => 'Test Account',
   *     'creditCardNum' => '4222222222222220',
   *     'creditCardExpiry' => '12/17',
   *     'mop' => 'VISA',
   *     'updateCreditCardNum' => FALSE,
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function updateCreditCardCustomerCode($parameters) {
    $response = $this->apiCall('UpdateCreditCardCustomerCode', $parameters);
    return $this->responseHandler($response, 'UpdateCreditCardCustomerCodeV1Result');
  }

  /**
   * Create ACH/EFT Customer Code.
   *
   * North America clients only.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'customerIPAddress' => '',
   *     'customerCode' => '',
   *     'firstName' => 'Test',
   *     'lastName' => 'Account',
   *     'companyName' => 'Test Co.',
   *     'address' => '1234 Any Street',
   *     'city' => 'Schenectady',
   *     'state' => 'NY',
   *     'zipCode' => '12345',
   *     'phone' => '555-555-1234',
   *     'fax' => '555-555-4321',
   *     'alternatePhone' => '555-555-5555',
   *     'email' => 'email@test.co',
   *     'comment' => 'Customer code update test.',
   *     'recurring' => FALSE,
   *     'amount' => '5',
   *     'beginDate' => 946684800,
   *     'endDate' => 946771200,
   *     'scheduleType' => 'Annually',
   *     'scheduleDate' => '',
   *     'accountCustomerName' => 'Test Account',
   *     'accountNum' => '999999999',
   *     'accountType' => 'Checking',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function createACHEFTCustomerCode($parameters) {
    $this->restrictedservers = array('UK');
    $restricted = $this->checkRestrictions($parameters);
    if ($restricted) {
      return $restricted;
    }
    else
    {
      $response = $this->apiCall('CreateACHEFTCustomerCode', $parameters);
      return $this->responseHandler($response, 'CreateACHEFTCustomerCodeV1Result');
    }
  }

  /**
   * Update ACH/EFT Customer Code.
   *
   * North America clients only.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'customerIPAddress' => '',
   *     'customerCode' => '',
   *     'firstName' => 'Test',
   *     'lastName' => 'Account',
   *     'companyName' => 'Test Co.',
   *     'address' => '1234 Any Street',
   *     'city' => 'Schenectady',
   *     'state' => 'NY',
   *     'zipCode' => '12345',
   *     'phone' => '555-555-1234',
   *     'fax' => '555-555-4321',
   *     'alternatePhone' => '555-555-5555',
   *     'email' => 'email@test.co',
   *     'comment' => 'Customer code update test.',
   *     'recurring' => FALSE,
   *     'amount' => '5',
   *     'beginDate' => 946684800,
   *     'endDate' => 946771200,
   *     'scheduleType' => 'Annually',
   *     'scheduleDate' => '',
   *     'accountCustomerName' => 'Test Account',
   *     'accountNum' => '999999999',
   *     'accountType' => 'Checking',
   *     'updateAccountNum' => FALSE,
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function updateACHEFTCustomerCode($parameters) {
    $this->restrictedservers = array('UK');
    $restricted = $this->checkRestrictions($parameters);
    if ($restricted) {
      return $restricted;
    }
    else
    {
      $response = $this->apiCall('UpdateACHEFTCustomerCode', $parameters);
      return $this->responseHandler($response, 'UpdateACHEFTCustomerCodeV1Result');
    }
  }

  /**
   * Delete Customer Code.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'customerIPAddress' => '',
   *     'customerCode' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function deleteCustomerCode($parameters) {
    $response = $this->apiCall('DeleteCustomerCode', $parameters);
    return $this->responseHandler($response, 'DeleteCustomerCodeV1Result');
  }

  /**
   * Validate direct debit payer information.
   *
   * UK clients only.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'customerIPAddress' => '',
   *     'ACHEFTReferenceNum' => '',
   *     'beginDate' => 946684800,
   *     'endDate' => 946771200,
   *     'accountCustomerName' => 'Test Account',
   *     'accountNum' => '999999999',
   *     'companyName' => 'Test Company',
   *     'firstName' => 'Test',
   *     'lastName' => 'Account',
   *     'address' => '1234 Any Street',
   *     'city' => 'Schenectady',
   *     'state' => 'NY',
   *     'country' => 'USA',
   *     'email' => 'email@test.co',
   *     'zipCode' => '12345',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  // TODO: Unit test.
  public function directDebitACHEFTPayerValidate($parameters) {
    $this->restrictedservers = array('NA');
    $restricted = $this->checkRestrictions($parameters);
    if ($restricted) {
      return $restricted;
    }
    else
    {
      $response = $this->apiCall('DirectDebitACHEFTPayerValidate', $parameters);
      return $this->responseHandler($response, 'DirectDebitACHEFTPayerValidateV1Result');
    }
  }

  /**
   * Create a customer code using only direct debit.
   *
   * UK clients only.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'customerIPAddress' => '',
   *     'customerCode' => '',
   *     'ACHEFTReferenceNum' => '',
   *     'firstName' => 'Test',
   *     'lastName' => 'Account',
   *     'companyName' => 'Test Co.',
   *     'address' => '1234 Any Street',
   *     'city' => 'Schenectady',
   *     'state' => 'NY',
   *     'zipCode' => '12345',
   *     'phone' => '555-555-1234',
   *     'fax' => '555-555-4321',
   *     'alternatePhone' => '555-555-5555',
   *     'email' => 'email@test.co',
   *     'comment' => 'Customer code update test.',
   *     'recurring' => FALSE,
   *     'amount' => '5',
   *     'beginDate' => 946684800,
   *     'endDate' => 946771200,
   *     'scheduleType' => 'Annually',
   *     'scheduleDate' => '',
   *     'accountCustomerName' => 'Test Account',
   *     'accountNum' => '999999999',
   *     'accountType' => 'Checking',
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  // TODO: Unit test.
  public function directDebitCreateACHEFTCustomerCode($parameters) {
    $this->restrictedservers = array('NA');
    $restricted = $this->checkRestrictions($parameters);
    if ($restricted) {
      return $restricted;
    }
    else
    {
      $response = $this->apiCall('DirectDebitCreateACHEFTCustomerCode', $parameters);
      return $this->responseHandler($response, 'DirectDebitCreateACHEFTCustomerCodeV1Result');
    }
  }

  /**
   * Update a customer code using only direct debit.
   *
   * UK clients only.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'customerIPAddress' => '',
   *     'customerCode' => '',
   *     'ACHEFTReferenceNum' => '',
   *     'firstName' => 'Test',
   *     'lastName' => 'Account',
   *     'companyName' => 'Test Co.',
   *     'address' => '1234 Any Street',
   *     'city' => 'Schenectady',
   *     'state' => 'NY',
   *     'zipCode' => '12345',
   *     'phone' => '555-555-1234',
   *     'fax' => '555-555-4321',
   *     'alternatePhone' => '555-555-5555',
   *     'email' => 'email@test.co',
   *     'comment' => 'Customer code update test.',
   *     'recurring' => FALSE,
   *     'amount' => '5',
   *     'beginDate' => 946684800,
   *     'endDate' => 946771200,
   *     'scheduleType' => 'Annually',
   *     'scheduleDate' => '',
   *     'accountCustomerName' => 'Test Account',
   *     'accountNum' => '999999999',
   *     'accountType' => 'Checking',
   *     'updateAccountNum' => FALSE,
   *   );
   * @endcode
   *
   * @return mixed
   *   Client response array or API error.
   */
  // TODO: Unit test.
  public function directDebitUpdateACHEFTCustomerCodeV1($parameters) {
    $this->restrictedservers = array('NA');
    $restricted = $this->checkRestrictions($parameters);
    if ($restricted) {
      return $restricted;
    }
    else
    {
      $response = $this->apiCall('DirectDebitUpdateACHEFTCustomerCode', $parameters);
      return $this->responseHandler($response, 'DirectDebitUpdateACHEFTCustomerCodeV1Result');
    }
  }

  /**
   * Response Handler for CustomerLink calls.
   *
   * @param object $response
   *   Restriction, error or API result.
   * @param string $result_name
   *   API result name.
   *
   * @return mixed
   *   Restriction, error or API result.
   */
  public function responseHandler($response, $result_name) {
    $result = $this->xml2array($response->$result_name->any);
    if ($result['STATUS'] == 'Failure') {
      return $result['ERRORS'];
    }

    $authresult = FALSE;

    // Handle reject codes.
    if (isset($result['PROCESSRESULT'])) {
      $authresult = $result['PROCESSRESULT']['AUTHORIZATIONRESULT'];
    }
    else if (isset($result['CUSTOMERS']))
    {
      $authresult = $result['CUSTOMERS'];
    }

    if (!$authresult)
    {
      $authresult = $result;
    }

    return $authresult;
  }

}
