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

  /** @var string $agentCode */
  private static $agentCode;

  /** @var string $password */
  private static $password;

  public function setUp()
  {
    self::$agentCode = IATS_AGENT_CODE;
    self::$password = IATS_PASSWORD;
  }

  /**
   * Test createCreditCardCustomerCode.
   */
  public function testCustomerLinkcreateCreditCardCustomerCode() {
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

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->createCreditCardCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test updateCreditCardCustomerCode.
   *
   * @depends testCustomerLinkcreateCreditCardCustomerCode
   */
  public function testCustomerLinkupdateCreditCardCustomerCode() {
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

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->updateCreditCardCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test updateCreditCardCustomerCode by adding a recurring schedule.
   *
   * @depends testCustomerLinkcreateCreditCardCustomerCode
   */
  public function testCustomerLinkupdateCreditCardCustomerCodeNewRecurringSchedule() {
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
      'recurring' => TRUE,
      'amount' => '5',
      'beginDate' => $beginDate,
      'endDate' => $endDate,
      'scheduleType' => 'Monthly',
      'scheduleDate' => '1', // 1st of every month.
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'mop' => 'VISA',
      'updateCreditCardNum' => FALSE,
    );

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->updateCreditCardCustomerCode($request);
    $this->assertEquals('OK', $response);

    // Get customer details to confirm update.

    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_CREDIT_CARD_CUSTOMER_CODE,
    );

    $response = $iats->getCustomerCodeDetail($request);

    $this->assertArrayHasKey('CST', $response);

    $this->assertEquals('Monthly', $response['CST']['RCR']['SCHTYP']);
    $this->assertEquals(1, $response['CST']['RCR']['SCHD']);
  }

  /**
   * Test updateCreditCardCustomerCode by updating the recurring schedule date.
   *
   * @depends testCustomerLinkupdateCreditCardCustomerCodeNewRecurringSchedule
   */
  public function testCustomerLinkupdateCreditCardCustomerCodeNewRecurringScheduleDate() {
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
      'recurring' => TRUE,
      'amount' => '5',
      'beginDate' => $beginDate,
      'endDate' => $endDate,
      'scheduleType' => 'Weekly',
      'scheduleDate' => '7', // 7th day of the week.
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'mop' => 'VISA',
      'updateCreditCardNum' => FALSE,
    );

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->updateCreditCardCustomerCode($request);
    $this->assertEquals('OK', $response);

    // Get customer details to confirm update.

    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_CREDIT_CARD_CUSTOMER_CODE,
    );

    $response = $iats->getCustomerCodeDetail($request);

    $this->assertArrayHasKey('CST', $response);

    $this->assertEquals('Weekly', $response['CST']['RCR']['SCHTYP']);
    $this->assertEquals(7, $response['CST']['RCR']['SCHD']);
  }

  /**
   * Test updateCreditCardCustomerCode by updating the recurring schedule card details.
   *
   * @depends testCustomerLinkupdateCreditCardCustomerCodeNewRecurringScheduleDate
   */
  public function testCustomerLinkupdateCreditCardCustomerCodeNewRecurringScheduleCard() {
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
      'recurring' => TRUE,
      'amount' => '5',
      'beginDate' => $beginDate,
      'endDate' => $endDate,
      'scheduleType' => 'Weekly',
      'scheduleDate' => '7', // 7th day of the week.
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4444444444444448',
      'creditCardExpiry' => '12/20',
      'mop' => 'VISA',
      'updateCreditCardNum' => TRUE,
    );

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->updateCreditCardCustomerCode($request);
    $this->assertEquals('OK', $response);

    // Get customer details to confirm update.

    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_CREDIT_CARD_CUSTOMER_CODE,
    );

    $response = $iats->getCustomerCodeDetail($request);

    $this->assertArrayHasKey('CST', $response);

    $this->assertStringEndsWith('4448', $response['CST']['AC1']['CC']['CCN']);
    $this->assertEquals('12/20', $response['CST']['AC1']['CC']['EXP']);
  }

  /**
   * Test getCustomerCodeDetail.
   *
   * @depends testCustomerLinkupdateCreditCardCustomerCode
   */
  public function testgetCustomerCodeDetail() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_CREDIT_CARD_CUSTOMER_CODE,
    );

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->getCustomerCodeDetail($request);

    $this->assertArrayHasKey('CST', $response);
    $this->assertEquals(self::TEST_CREDIT_CARD_CUSTOMER_CODE, $response['CST']['CSTC']);
  }

  /**
   * Test createACHEFTCustomerCode.
   */
  public function testCustomerLinkcreateACHEFTCustomerCode() {
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

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->createACHEFTCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test updateACHEFTCustomerCode.
   *
   * @depends testCustomerLinkcreateACHEFTCustomerCode
   */
  public function testCustomerLinkupdateACHEFTCustomerCode() {
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

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->updateACHEFTCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test deleteCustomerCode for credit card customers.
   *
   * @depends testgetCustomerCodeDetail
   */
  public function testCustomerLinkdeleteCreditCardCustomerCode() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_CREDIT_CARD_CUSTOMER_CODE,
    );

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->deleteCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test deleteCustomerCode for ACH / EFT customers.
   *
   * @depends testCustomerLinkupdateACHEFTCustomerCode
   */
  public function testCustomerLinkdeleteACHEFTCustomerCode() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_ACH_EFT_CUSTOMER_CODE,
    );

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->deleteCustomerCode($request);
    $this->assertEquals('OK', $response);
  }

  /**
   * Test getCustomerCodeDetail with an invalid customer code.
   *
   * @depends testgetCustomerCodeDetail
   */
  public function testgetCustomerCodeDetailInvalidCode() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::TEST_INVALID_CUSTOMER_CODE,
    );

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->getCustomerCodeDetail($request);

    $this->assertEquals('Error : The customer code doesn\'t exist!', $response);
  }
}
