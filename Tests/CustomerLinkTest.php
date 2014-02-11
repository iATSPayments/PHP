<?php
/**
 * @file
 * Unit tests for Customer Link element of the iATS API.
 */

namespace iATS;

/**
 * Class CustomerLinkTest
 *
 * @package IATSAPI\Test
 */
class CustomerLinkTest extends \PHPUnit_Framework_TestCase {
  const TEST_CREDIT_CARD_CUSTOMER_CODE = 'A99999990';
  const TEST_ACH_EFT_CUSTOMER_CODE = 'A99999991';
  const TEST_INVALID_CUSTOMER_CODE = 'A00000000';

  /**
   * Test createCreditCardCustomerCode.
   */
  public function testCustomerLinkcreateCreditCardCustomerCode() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    $beginDate = strtotime('10/23/2011');
    $endDate = strtotime('10/23/2014');
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_CREDIT_CARD_CUSTOMER_CODE,
      'firstName' => 'Test',
      'lastName' => 'Account',
      'companyName' => 'Test Co.',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'phone' => '555-555-1234',
      'fax' => '555-555-4321',
      'alternatePhone' => '555-555-5555',
      'email' => 'email@test.co',
      'comment' => 'Customer code creation test.',
      'recurring' => FALSE,
      'amount' => '5',
      'beginDate' => $beginDate,
      'endDate' => $endDate,
      'scheduleType' => 'Annually',
      'scheduleDate' => '',
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'mop' => 'VISA',
      // Not required.
      'currency' => 'USD',
    );

    $iats = new CustomerLink($agentcode, $password, 'NA');
    $response = $iats->createCreditCardCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test updateCreditCardCustomerCode.
   *
   * @depends testCustomerLinkcreateCreditCardCustomerCode
   */
  public function testCustomerLinkupdateCreditCardCustomerCode() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    $beginDate = strtotime('10/23/2011');
    $endDate = strtotime('10/23/2014');
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_CREDIT_CARD_CUSTOMER_CODE,
      'firstName' => 'Test',
      'lastName' => 'Account',
      'companyName' => 'Test Co.',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'phone' => '555-555-1234',
      'fax' => '555-555-4321',
      'alternatePhone' => '555-555-5555',
      'email' => 'email@test.co',
      'comment' => 'Customer code update test.',
      'recurring' => FALSE,
      'amount' => '5',
      'beginDate' => $beginDate,
      'endDate' => $endDate,
      'scheduleType' => 'Annually',
      'scheduleDate' => '',
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'mop' => 'VISA',
      'updateCreditCardNum' => FALSE,
    );

    $iats = new CustomerLink($agentcode, $password, 'NA');
    $response = $iats->updateCreditCardCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test getCustomerCodeDetail.
   *
   * @depends testCustomerLinkupdateCreditCardCustomerCode
   */
  public function testgetCustomerCodeDetail() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_CREDIT_CARD_CUSTOMER_CODE,
    );

    $iats = new CustomerLink($agentcode, $password, 'NA');
    $response = $iats->getCustomerCodeDetail($request);

    $this->assertArrayHasKey('CST', $response);
    $this->assertEquals(self::TEST_CREDIT_CARD_CUSTOMER_CODE, $response['CST']['CSTC']);
  }

  /**
   * Test createACHEFTCustomerCode.
   */
  public function testCustomerLinkcreateACHEFTCustomerCode() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    $beginDate = strtotime('10/23/2011');
    $endDate = strtotime('10/23/2014');
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_ACH_EFT_CUSTOMER_CODE,
      'firstName' => 'Test',
      'lastName' => 'Account',
      'companyName' => 'Test Co.',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'phone' => '555-555-1234',
      'fax' => '555-555-4321',
      'alternatePhone' => '555-555-5555',
      'email' => 'email@test.co',
      'comment' => 'Customer code update test.',
      'recurring' => FALSE,
      'amount' => '5',
      'beginDate' => $beginDate,
      'endDate' => $endDate,
      'scheduleType' => 'Annually',
      'scheduleDate' => '',
      'accountCustomerName' => 'Test Account',
      'accountNum' => '999999999',
      'accountType' => 'Checking',
    );

    $iats = new CustomerLink($agentcode, $password, 'NA');
    $response = $iats->createACHEFTCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test updateACHEFTCustomerCode.
   *
   * @depends testCustomerLinkcreateACHEFTCustomerCode
   */
  public function testCustomerLinkupdateACHEFTCustomerCode() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    $beginDate = strtotime('10/23/2011');
    $endDate = strtotime('10/23/2014');
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_ACH_EFT_CUSTOMER_CODE,
      'firstName' => 'Test',
      'lastName' => 'Account',
      'companyName' => 'Test Co.',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'phone' => '555-555-1234',
      'fax' => '555-555-4321',
      'alternatePhone' => '555-555-5555',
      'email' => 'email@test.co',
      'comment' => 'Customer code update test.',
      'recurring' => FALSE,
      'amount' => '5',
      'beginDate' => $beginDate,
      'endDate' => $endDate,
      'scheduleType' => 'Annually',
      'scheduleDate' => '',
      'accountCustomerName' => 'Test Account',
      'accountNum' => '999999999',
      'accountType' => 'Checking',
      'updateAccountNum' => FALSE,
    );

    $iats = new CustomerLink($agentcode, $password, 'NA');
    $response = $iats->updateACHEFTCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test deleteCustomerCode for credit card customers.
   *
   * @depends testgetCustomerCodeDetail
   */
  public function testCustomerLinkdeleteCreditCardCustomerCode() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_CREDIT_CARD_CUSTOMER_CODE,
    );

    $iats = new CustomerLink($agentcode, $password, 'NA');
    $response = $iats->deleteCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test deleteCustomerCode for ACH / EFT customers.
   *
   * @depends testCustomerLinkupdateACHEFTCustomerCode
   */
  public function testCustomerLinkdeleteACHEFTCustomerCode() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_ACH_EFT_CUSTOMER_CODE,
    );

    $iats = new CustomerLink($agentcode, $password, 'NA');
    $response = $iats->deleteCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test getCustomerCodeDetail with an invalid customer code.
   *
   * @depends testgetCustomerCodeDetail
   */
  public function testgetCustomerCodeDetailInvalidCode() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_INVALID_CUSTOMER_CODE,
    );

    $iats = new CustomerLink($agentcode, $password, 'NA');
    $response = $iats->getCustomerCodeDetail($request);

    $this->assertEquals('Error : The customer code doesn\'t exist!', $response);
  }

//  /**
//   * Change recurring schedule date.
//   */
//  public function testRecurDate() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Change recurring schedule frequency.
//   */
//  public function testRecurFrequency() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Change recurring schedule card details.
//   */
//  public function testRecurDetails() {
//    $this->assertTrue(FALSE);
//  }

}
