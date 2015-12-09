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
    $this->endpoint = '/NetGate/CustomerLinkv2.asmx?WSDL';
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
    return $this->responseHandler($response, 'GetCustomerCodeDetailResult');
  }

  /**
   * Get Customer List By Creation Time CSV.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'customerCode' => 'A10396688' // The iATS Customer Code.
   *     'fromDate => '2014-07-23T00:00:00+00:00' // Customer creation start date
   *     'toDate' => '2024-07-23T23:59:59+00:00'  // Customer creation to date
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function getCustomerListByCreationTimeCSV($parameters) {
    $response = $this->apiCall('GetCustomerListByCreationTimeCSV', $parameters);
    return $this->responseHandler($response, 'GetCustomerListByCreationTimeCSVResult');
  }

  /**
   * Get Customer List By Creation Time XML.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'customerIPAddress' => '' // Optional. The client IP address.
   *     'customerCode' => 'A10396688' // The iATS Customer Code.
   *     'fromDate => '2014-07-23T00:00:00+00:00' // Customer creation start date
   *     'toDate' => '2024-07-23T23:59:59+00:00'  // Customer creation to date
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function getCustomerListByCreationTimeXML($parameters) {
    $response = $this->apiCall('GetCustomerListByCreationTimeXML', $parameters);
    return $this->responseHandler($response, 'GetCustomerListByCreationTimeXMLResult');
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
   *     'beginDate' => '2014-07-23T00:00:00+00:00' // The begin date of the recurring payment, if used.
   *     'endDate' => '2024-07-23T23:59:59+00:00' // The end date of the recurring payment, if used.
   *     'scheduleType' => 'Annually' // The recurring payment schedule.
   *      // Options: Weekly, Monthly, Quarterly, Annually.
   *     'scheduleDate' => '' // The recurring payment schedule date.
   *      // Options: Monthly: 1-28,29,30 or 31; Weekly: 1-7; Quarterly or Annually: empty string.
   *     'creditCardCustomerName' => 'Test Account' // The customer's name as appears on the credit card.
   *     'creditCardNum' => '4222222222222220' // The customer's credit card number.
   *     'creditCardExpiry' => '12/17' // The customer's credit card expiration date.
   *     'mop' => 'VISA' // Optional. The customer's method of payment.
   *     'title' => 'string'
   *     'country' => 'string'
   *     'item1' => 'string'
   *     'item2' => 'string'
   *     'item3' => 'string'
   *     'item4' => 'string'
   *     'item5' => 'string'
   *     'item6' => 'string'
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function createCreditCardCustomerCode($parameters) {
    $response = $this->apiCall('CreateCreditCardCustomerCode', $parameters);
    return $this->responseHandler($response, 'CreateCreditCardCustomerCodeResult');
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
   *     'beginDate' => '2014-07-23T00:00:00+00:00' // Optional. The begin date of the recurring payment, if used.
   *     'endDate' => '2024-07-23T23:59:59+00:00' // Optional. The end date of the recurring payment, if used.
   *     'scheduleType' => 'Annually' // Optional. The recurring payment schedule.
   *      // Options: Weekly, Monthly, Quarterly, Annually.
   *     'scheduleDate' => '' // Optional. The recurring payment schedule date.
   *      // Options: Monthly: 1-28,29,30 or 31; Weekly: 1-7; Quarterly or Annually: empty string.
   *     'creditCardCustomerName' => 'Test Account' // Optional. The customer's name as appears on the credit card.
   *     'creditCardNum' => '4222222222222220' // Optional. The customer's credit card number.
   *     'creditCardExpiry' => '12/17' // Optional. The customer's credit card expiration date.
   *     'mop' => 'VISA' // Optional. The customer's method of payment.
   *     'updateCreditCardNum' => FALSE // Optional. TRUE when the customer's credit card number should be updated.
   *     'title' => 'string'
   *     'country' => 'string'
   *     'item1' => 'string'
   *     'item2' => 'string'
   *     'item3' => 'string'
   *     'item4' => 'string'
   *     'item5' => 'string'
   *     'item6' => 'string'
   *
   * @return mixed
   *   Client response array or API error.
   */
  public function updateCreditCardCustomerCode($parameters) {
    $response = $this->apiCall('UpdateCreditCardCustomerCode', $parameters);
    return $this->responseHandler($response, 'UpdateCreditCardCustomerCodeResult');
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
   *     'beginDate' => '2014-07-23T00:00:00+00:00' // Optional. The begin date of the recurring payment, if used.
   *     'endDate' => '2024-07-23T23:59:59+00:00' // Optional. The end date of the recurring payment, if used.
   *     'scheduleType' => 'Annually' // Optional. The recurring payment schedule.
   *      // Options: Weekly, Monthly Quarterly, Annually.
   *     'scheduleDate' => '' // Optional. The recurring payment schedule date.
   *      // Options: Monthly: 1-28,29,30 or 31; Weekly: 1-7; Quarterly or Annually: empty string.
   *     'accountCustomerName' => 'Test Account' // Optional. The customer's name as appears on the bank account.
   *     'accountNum' => '999999999' // Optional. The customer's bank account number.
   *     'accountType' => 'CHECKING' // Optional. The customer's bank account type.
   *      // Options: CHECKING, SAVING (North America only.)
   *       'title' => 'string'
   *       'country' => 'string'
   *       'item1' => 'string'
   *       'item2' => 'string'
   *       'item3' => 'string'
   *       'item4' => 'string'
   *       'item5' => 'string'
   *       'item6' => 'string'
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
      return $this->responseHandler($response, 'CreateACHEFTCustomerCodeResult');
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
   *     'beginDate' => '2014-07-23T00:00:00+00:00' // Optional. The begin date of the recurring payment, if used.
   *     'endDate' => '2024-07-23T23:59:59+00:00' // Optional. The end date of the recurring payment, if used.
   *     'scheduleType' => 'Annually' // Optional. The recurring payment schedule.
   *      // Options: Weekly, Monthly Quarterly, Annually.
   *     'scheduleDate' => '' // Optional. The recurring payment schedule date.
   *      // Options: Monthly: 1-28,29,30 or 31; Weekly: 1-7; Quarterly or Annually: empty string.
   *     'accountCustomerName' => 'Test Account' // Optional. The customer's name as appears on the bank account.
   *     'accountNum' => '999999999' // Optional. The customer's bank account number.
   *     'accountType' => 'CHECKING' // Optional. The customer's bank account type.
   *      // Options: CHECKING, SAVING (North America only.)
   *     'updateAccountNum' => FALSE // Optional. True if the customer's account number should be updated.
   *     'title' => 'string'
   *     'country' => 'string'
   *     'item1' => 'string'
   *     'item2' => 'string'
   *     'item3' => 'string'
   *     'item4' => 'string'
   *     'item5' => 'string'
   *     'item6' => 'string'
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
      return $this->responseHandler($response, 'UpdateACHEFTCustomerCodeResult');
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
    return $this->responseHandler($response, 'DeleteCustomerCodeResult');
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
