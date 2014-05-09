<?php
/**
 * CustomerLink class file.
 *
 * The CustomerLink service is used to create secure customer codes that may be
 * used with the ProcessLink service to process single or recurring credit card
 * or ACH / EFT transactions.
 *
 * Once created, customer codes may be reused, removing the need to store sensitive
 * credit card or ACH information on local servers.
 *
 * Service guide: http://home.iatspayments.com/sites/default/files/iats_webservices_customerlink_version_4.0.pdf
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
   *   @see setServer()
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
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'customerCode' => 'A10396688' // The iATS Customer Code.
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
   *     'customerIPAddress' => '' // The client IP address.
   *     'customerCode' => '' // Optional. The iATS Customer Code.
   *     'firstName' => 'Test' // The customer's first name.
   *     'lastName' => 'Account' // The customer's last name.
   *     'companyName' => 'Test Co.' // The customer's company name.
   *     'address' => '1234 Any Street' // The customer's address.
   *     'city' => 'Schenectady' // The customer's city.
   *     'state' => 'NY' // The customer's state or province.
   *     'zipCode' => '12345' // The customer's ZIP code.
   *     'phone' => '555-555-1234' // The customer's phone number.
   *     'fax' => '555-555-4321' // The customer's FAX number.
   *     'alternatePhone' => '555-555-5555' // The customer's alternate phone number.
   *     'email' => 'email@test.co' // The customer's email address.
   *     'comment' => 'Customer code creation test.' // A comment describing this transaction.
   *     'recurring' => FALSE // TRUE if a recurring payment should be created.
   *     'amount' => '5' // The payment amount.
   *     'beginDate' => 946684800 // The begin date of the recurring payment, if used.
   *     'endDate' => 946771200 // The end date of the recurring payment, if used.
   *     'scheduleType' => 'Annually' // The recurring payment schedule.
   *      // Options: Weekly, Monthly, Quarterly, Annually.
   *     'scheduleDate' => '' // The recurring payment schedule date.
   *      // Options: Monthly: 1-28,29,30 or 31; Weekly: 1-7; Quarterly or Annually: empty string.
   *     'creditCardCustomerName' => 'Test Account' // The customer's name as appears on the credit card.
   *     'creditCardNum' => '4222222222222220' // The customer's credit card number.
   *     'creditCardExpiry' => '12/17' // The customer's credit card expiration date.
   *     'mop' => 'VISA' // Optional. The customer's method of payment.
   *     'currency' => 'USD' // Optional. The customer's currency.
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
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'customerCode' => '' // The iATS Customer Code.
   *     'firstName' => 'Test' // Optional. The customer's first name.
   *     'lastName' => 'Account' // Optional. The customer's last name.
   *     'companyName' => 'Test Co.' // Optional. The customer's company name.
   *     'address' => '1234 Any Street' // Optional. The customer's address.
   *     'city' => 'Schenectady' // Optional. The customer's city.
   *     'state' => 'NY' // Optional. The customer's state or province.
   *     'zipCode' => '12345' // Optional. The customer's ZIP code.
   *     'phone' => '555-555-1234' // Optional. Optional. The customer's phone number.
   *     'fax' => '555-555-4321' // Optional. The customer's FAX number.
   *     'alternatePhone' => '555-555-5555' // Optional. The customer's alternate phone number.
   *     'email' => 'email@test.co' // Optional. The customer's email address.
   *     'comment' => 'Customer code creation test.' // Optional. A comment describing this transaction.
   *     'recurring' => FALSE // Optional. TRUE if a recurring payment should be created.
   *     'amount' => '5' // Optional. The payment amount.
   *     'beginDate' => 946684800 // Optional. The begin date of the recurring payment, if used.
   *     'endDate' => 946771200 // Optional. The end date of the recurring payment, if used.
   *     'scheduleType' => 'Annually' // Optional. The recurring payment schedule.
   *      // Options: Weekly, Monthly, Quarterly, Annually.
   *     'scheduleDate' => '' // Optional. The recurring payment schedule date.
   *      // Options: Monthly: 1-28,29,30 or 31; Weekly: 1-7; Quarterly or Annually: empty string.
   *     'creditCardCustomerName' => 'Test Account' // Optional. The customer's name as appears on the credit card.
   *     'creditCardNum' => '4222222222222220' // Optional. The customer's credit card number.
   *     'creditCardExpiry' => '12/17' // Optional. The customer's credit card expiration date.
   *     'mop' => 'VISA' // Optional. The customer's method of payment.
   *     'currency' => 'USD' // Optional. The customer's currency.
   *     'updateCreditCardNum' => FALSE // Optional. TRUE when the customer's credit card number should be updated.
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function updateCreditCardCustomerCode($parameters) {
    $response = $this->apiCall('UpdateCreditCardCustomerCode', $parameters);
    return $this->responseHandler($response, 'UpdateCreditCardCustomerCodeV1Result');
  }

  /**
   * Create ACH/EFT Customer Code. North America clients only.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'customerCode' => '' // Optional. The iATS Customer Code.
   *     'firstName' => 'Test' // The customer's first name.
   *     'lastName' => 'Account' // The customer's last name.
   *     'companyName' => 'Test Co.' // Optional. The customer's company name.
   *     'address' => '1234 Any Street' // The customer's address.
   *     'city' => 'Schenectady' // The customer's city.
   *     'state' => 'NY' // The customer's state or province.
   *     'zipCode' => '12345' // The customer's ZIP code.
   *     'phone' => '555-555-1234' // Optional. The customer's phone number.
   *     'fax' => '555-555-4321' // Optional. The customer's FAX number.
   *     'alternatePhone' => '555-555-5555' // Optional. The customer's alternate phone number.
   *     'email' => 'email@test.co' // Optional. The customer's email address.
   *     'comment' => 'Customer code creation test.' // Optional. A comment describing this transaction.
   *     'recurring' => FALSE // Optional. TRUE if a recurring payment should be created.
   *     'amount' => '5' // Optional. The payment amount.
   *     'beginDate' => 946684800 // Optional. The begin date of the recurring payment, if used.
   *     'endDate' => 946771200 // Optional. The end date of the recurring payment, if used.
   *     'scheduleType' => 'Annually' // Optional. The recurring payment schedule.
   *      // Options: Weekly, Monthly Quarterly, Annually.
   *     'scheduleDate' => '' // Optional. The recurring payment schedule date.
   *      // Options: Monthly: 1-28,29,30 or 31; Weekly: 1-7; Quarterly or Annually: empty string.
   *     'accountCustomerName' => 'Test Account' // Optional. The customer's name as appears on the bank account.
   *     'accountNum' => '999999999' // Optional. The customer's bank account number.
   *     'accountType' => 'CHECKING' // Optional. The customer's bank account type.
   *      // Options: CHECKING, SAVING (North America only.)
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
   * Update ACH/EFT Customer Code. North America clients only.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'customerCode' => '' // The iATS Customer Code.
   *     'firstName' => 'Test' // Optional. The customer's first name.
   *     'lastName' => 'Account' // Optional. The customer's last name.
   *     'companyName' => 'Test Co.' // Optional. The customer's company name.
   *     'address' => '1234 Any Street' // Optional. The customer's address.
   *     'city' => 'Schenectady' // Optional. The customer's city.
   *     'state' => 'NY' // Optional. The customer's state or province.
   *     'zipCode' => '12345' // Optional. The customer's ZIP code.
   *     'phone' => '555-555-1234' // Optional. The customer's phone number.
   *     'fax' => '555-555-4321' // Optional. The customer's FAX number.
   *     'alternatePhone' => '555-555-5555' // Optional. The customer's alternate phone number.
   *     'email' => 'email@test.co' // Optional. The customer's email address.
   *     'comment' => 'Customer code creation test.' // Optional. A comment describing this transaction.
   *     'recurring' => FALSE // Optional. TRUE if a recurring payment should be created.
   *     'amount' => '5' // Optional. The payment amount.
   *     'beginDate' => 946684800 // Optional. The begin date of the recurring payment, if used.
   *     'endDate' => 946771200 // Optional. The end date of the recurring payment, if used.
   *     'scheduleType' => 'Annually' // Optional. The recurring payment schedule.
   *      // Options: Weekly, Monthly Quarterly, Annually.
   *     'scheduleDate' => '' // Optional. The recurring payment schedule date.
   *      // Options: Monthly: 1-28,29,30 or 31; Weekly: 1-7; Quarterly or Annually: empty string.
   *     'accountCustomerName' => 'Test Account' // Optional. The customer's name as appears on the bank account.
   *     'accountNum' => '999999999' // Optional. The customer's bank account number.
   *     'accountType' => 'CHECKING' // Optional. The customer's bank account type.
   *      // Options: CHECKING, SAVING (North America only.)
   *     'updateAccountNum' => FALSE // Optional. True if the customer's account number should be updated.
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
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'customerCode' => '' // The iATS Customer Code.
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function deleteCustomerCode($parameters) {
    $response = $this->apiCall('DeleteCustomerCode', $parameters);
    return $this->responseHandler($response, 'DeleteCustomerCodeV1Result');
  }

  /**
   * Validate direct debit payer information. UK clients only.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'ACHEFTReferenceNum' => '' // Optional. The ACH / EFT reference number.
   *     'beginDate' => 946684800 // The begin date of the direct debit payment.
   *     'endDate' => 946771200 // The end date of the direct debit payment.
   *     'accountCustomerName' => 'Test Account' // The customer's name as appears on the bank account.
   *     'accountNum' => '999999999' // The customer's bank account number.
   *     'companyName' => 'Test Company' // Optional. The customer's company name.
   *     'firstName' => 'Test' // The customer's first name.
   *     'lastName' => 'Account' // The customer's last name.
   *     'address' => '1234 Any Street' // The customer's address.
   *     'city' => 'Schenectady' // The customer's city.
   *     'state' => 'NY' // Optional. The customer's state or province.
   *     'country' => 'USA' // Optional. The customer's country.
   *     'email' => 'email@test.co' // The customer's email address.
   *     'zipCode' => '12345' // The customer's ZIP code.
   *
   * @return mixed
   *   Client response array or API error.
   */
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
   * Create a customer code using only direct debit. UK clients only.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'customerCode' => '' // Optional. The iATS Customer Code.
   *     'ACHEFTReferenceNum' => '' // Optional. The ACH / EFT reference number.
   *     'firstName' => 'Test' // The customer's first name.
   *     'lastName' => 'Account' // The customer's last name.
   *     'companyName' => 'Test Co.' // Optional. The customer's company name.
   *     'address' => '1234 Any Street' // The customer's address.
   *     'city' => 'Schenectady' // The customer's city.
   *     'state' => 'NY' // The customer's state or province.
   *     'zipCode' => '12345' // The customer's ZIP code.
   *     'phone' => '555-555-1234' // Optional. The customer's phone number.
   *     'fax' => '555-555-4321' // Optional. The customer's FAX number.
   *     'alternatePhone' => '555-555-5555' // Optional. The customer's alternate phone number.
   *     'email' => 'email@test.co' // Optional. The customer's email address.
   *     'comment' => 'Customer code creation test.' // Optional. A comment describing this transaction.
   *     'recurring' => FALSE // Optional. TRUE if a recurring payment should be created.
   *     'amount' => '5' // Optional. The payment amount.
   *     'beginDate' => 946684800 // The begin date of the recurring payment, if used.
   *     'endDate' => 946771200 // The end date of the recurring payment, if used.
   *     'scheduleType' => 'Annually' // Optional. The recurring payment schedule.
   *      // Options: Weekly, Monthly Quarterly, Annually.
   *     'scheduleDate' => '' // Optional. The recurring payment schedule date.
   *      // Options: Monthly: 1-28,29,30 or 31; Weekly: 1-7; Quarterly or Annually: empty string.
   *     'accountCustomerName' => 'Test Account' // Optional. The customer's name as appears on the bank account.
   *     'accountNum' => '999999999' // Optional. The customer's bank account number.
   *     'accountType' => 'CHECKING' // Optional. The customer's bank account type.
   *      // Options: CHECKING, SAVING (North America only.)
   *
   * @return mixed
   *   Client response array or API error.
   */
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
   * Update a customer code using only direct debit. UK clients only.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'customerCode' => '' // The iATS Customer Code.
   *     'firstName' => 'Test' // Optional. The customer's first name.
   *     'lastName' => 'Account' // Optional. The customer's last name.
   *     'companyName' => 'Test Co.' // Optional. The customer's company name.
   *     'address' => '1234 Any Street' // Optional. The customer's address.
   *     'city' => 'Schenectady' // Optional. The customer's city.
   *     'state' => 'NY' // Optional. The customer's state or province.
   *     'zipCode' => '12345' // Optional. The customer's ZIP code.
   *     'phone' => '555-555-1234' // Optional. The customer's phone number.
   *     'fax' => '555-555-4321' // Optional. The customer's FAX number.
   *     'alternatePhone' => Optional. '555-555-5555' // Optional. The customer's alternate phone number.
   *     'email' => 'email@test.co' // Optional. The customer's email address.
   *     'comment' => 'Customer code creation test.' // Optional. A comment describing this transaction.
   *     'recurring' => FALSE // Optional. TRUE if a recurring payment should be created.
   *     'amount' => '5' // Optional. The payment amount.
   *     'beginDate' => 946684800 // Optional. The begin date of the recurring payment, if used.
   *     'endDate' => 946771200 // Optional. The end date of the recurring payment, if used.
   *     'scheduleType' => 'Annually' // Optional. The recurring payment schedule.
   *      // Options: Weekly, Monthly Quarterly, Annually.
   *     'scheduleDate' => '' // Optional. The recurring payment schedule date.
   *      // Options: Monthly: 1-28,29,30 or 31; Weekly: 1-7; Quarterly or Annually: empty string.
   *     'accountCustomerName' => 'Test Account' // Optional. The customer's name as appears on the bank account.
   *     'accountNum' => '999999999' // Optional. The customer's bank account number.
   *     'accountType' => 'CHECKING' // Optional. The customer's bank account type.
   *      // Options: CHECKING, SAVING (North America only.)
   *     'updateAccountNum' => FALSE // Optional. True is the customer's account number should be updated.
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function directDebitUpdateACHEFTCustomerCode($parameters) {
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
      $authresult = $result['PROCESSRESULT'];
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
