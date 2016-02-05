<?php
/**
 * @file
 * Unit tests for Customer Link component of the iATS API.
 */

namespace iATS;

/**
 * Class CustomerLinkTest
 *
 * @package IATSAPI\Test
 */
class CustomerLinkTest extends \PHPUnit_Framework_TestCase {

  const TEST_INVALID_CUSTOMER_CODE = 'A00000000';

  /** @var string $agentCode */
  private static $agentCode;

  /** @var string $password */
  private static $password;

  /** @var string $creditCardCustomerCode */
  private static $creditCardCustomerCode;

  /** @var string $ACHEFTCustomerCode */
  private static $ACHEFTCustomerCode;

  /** @var string $directDebitACHEFTCustomerCode */
  private static $directDebitACHEFTCustomerCode;

  /** @var string $directDebitACHEFTReferenceNum */
  private static $directDebitACHEFTReferenceNum;

  public function setUp()
  {
    self::$agentCode = IATS_AGENT_CODE;
    self::$password = IATS_PASSWORD;
  }

  /**
   * Test createCreditCardCustomerCode.
   */
  public function testCustomerLinkcreateCreditCardCustomerCode() {
    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');

    $beginTime = strtotime('+1 day');
    $endTime = mktime(0, 0, 0, date('n'), date('j'), date('Y') + 10);

    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => '',
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
      'beginDate' => $iats->getFormattedDate($beginTime),
      'endDate' => $iats->getFormattedDate($endTime),
      'scheduleType' => 'Annually',
      'scheduleDate' => '',
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'mop' => 'VISA',
      // Not required.
      'currency' => 'USD',
    );

    $response = $iats->createCreditCardCustomerCode($request);

    $this->assertEquals('OK', $response['AUTHORIZATIONRESULT']);

    self::$creditCardCustomerCode = $response['CUSTOMERCODE'];
  }

  /**
   * Test updateCreditCardCustomerCode.
   *
   * @depends testCustomerLinkcreateCreditCardCustomerCode
   */
  public function testCustomerLinkupdateCreditCardCustomerCode() {
    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');

    $beginTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $endTime = mktime(0, 0, 0, date('n'), date('j'), date('Y') + 10);

    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::$creditCardCustomerCode,
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
      'beginDate' => $iats->getFormattedDate($beginTime),
      'endDate' => $iats->getFormattedDate($endTime),
      'scheduleType' => 'Annually',
      'scheduleDate' => '',
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'mop' => 'VISA',
      'updateCreditCardNum' => FALSE,
    );

    $response = $iats->updateCreditCardCustomerCode($request);

    $this->assertEquals('OK', $response['AUTHORIZATIONRESULT']);
  }

  /**
   * Test updateCreditCardCustomerCode by adding a recurring schedule.
   *
   * @depends testCustomerLinkcreateCreditCardCustomerCode
   */
  public function testCustomerLinkupdateCreditCardCustomerCodeNewRecurringSchedule() {
    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');

    $beginTime = strtotime('+1 day');
    $endTime = mktime(0, 0, 0, date('n'), date('j'), date('Y') + 10);

    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::$creditCardCustomerCode,
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
      'beginDate' => $iats->getFormattedDate($beginTime),
      'endDate' => $iats->getFormattedDate($endTime),
      'scheduleType' => 'Monthly',
      'scheduleDate' => '1', // 1st of every month.
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'mop' => 'VISA',
      'updateCreditCardNum' => FALSE,
    );

    $response = $iats->updateCreditCardCustomerCode($request);

    $this->assertEquals('OK', $response['AUTHORIZATIONRESULT']);

    // Get customer details to confirm update.

    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::$creditCardCustomerCode,
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
    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');

    $beginTime = strtotime('+1 day');
    $endTime   = mktime(0, 0, 0, date('n'), date('j'), date('Y') + 10);

    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::$creditCardCustomerCode,
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
      'beginDate' => $iats->getFormattedDate($beginTime),
      'endDate' => $iats->getFormattedDate($endTime),
      'scheduleType' => 'Weekly',
      'scheduleDate' => '7', // 7th day of the week.
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'mop' => 'VISA',
      'updateCreditCardNum' => FALSE,
    );

    $response = $iats->updateCreditCardCustomerCode($request);

    $this->assertEquals('OK', $response['AUTHORIZATIONRESULT']);

    // Get customer details to confirm update.

    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::$creditCardCustomerCode,
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
    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');

    $beginTime = strtotime('+1 day');
    $endTime   = mktime(0, 0, 0, date('n'), date('j'), date('Y') + 10);

    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::$creditCardCustomerCode,
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
      'beginDate' => $iats->getFormattedDate($beginTime),
      'endDate' => $iats->getFormattedDate($endTime),
      'scheduleType' => 'Weekly',
      'scheduleDate' => '7', // 7th day of the week.
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4444444444444448',
      'creditCardExpiry' => '12/20',
      'mop' => 'VISA',
      'updateCreditCardNum' => TRUE,
    );

    $response = $iats->updateCreditCardCustomerCode($request);

    $this->assertEquals('OK', $response['AUTHORIZATIONRESULT']);

    // Get customer details to confirm update.

    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::$creditCardCustomerCode,
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
      'customerCode' => self::$creditCardCustomerCode,
    );

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->getCustomerCodeDetail($request);

    $this->assertArrayHasKey('CST', $response);
    $this->assertEquals(self::$creditCardCustomerCode, $response['CST']['CSTC']);
  }

  /**
   * Test createACHEFTCustomerCode.
   */
  public function testCustomerLinkcreateACHEFTCustomerCode() {
    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');

    $beginTime = strtotime('+1 day');
    $endTime   = mktime(0, 0, 0, date('n'), date('j'), date('Y') + 10);

    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => '',
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
      'beginDate' => $iats->getFormattedDate($beginTime),
      'endDate' => $iats->getFormattedDate($endTime),
      'scheduleType' => 'Annually',
      'scheduleDate' => '',
      'accountCustomerName' => 'Test Account',
      'accountNum' => '999999999',
      'accountType' => 'Checking',
    );

    $response = $iats->createACHEFTCustomerCode($request);

    $this->assertEquals('OK', $response['AUTHORIZATIONRESULT']);

    self::$ACHEFTCustomerCode = $response['CUSTOMERCODE'];
  }

  /**
   * Test updateACHEFTCustomerCode.
   *
   * @depends testCustomerLinkcreateACHEFTCustomerCode
   */
  public function testCustomerLinkupdateACHEFTCustomerCode() {
    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');

    $beginTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $endTime = mktime(0, 0, 0, date('n'), date('j'), date('Y') + 10);

    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::$ACHEFTCustomerCode,
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
      'beginDate' => $iats->getFormattedDate($beginTime),
      'endDate' => $iats->getFormattedDate($endTime),
      'scheduleType' => 'Annually',
      'scheduleDate' => '',
      'accountCustomerName' => 'Test Account',
      'accountNum' => '999999999',
      'accountType' => 'Checking',
      'updateAccountNum' => FALSE,
    );

    $response = $iats->updateACHEFTCustomerCode($request);

    $this->assertEquals('OK', $response['AUTHORIZATIONRESULT']);
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
      'customerCode' => self::$creditCardCustomerCode,
    );

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->deleteCustomerCode($request);

    $this->assertEquals('OK', $response['AUTHORIZATIONRESULT']);
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
      'customerCode' => self::$ACHEFTCustomerCode,
    );

    $iats = new CustomerLink(self::$agentCode, self::$password, 'NA');
    $response = $iats->deleteCustomerCode($request);

    $this->assertEquals('OK', $response['AUTHORIZATIONRESULT']);
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

    $this->assertEquals('Error : The customer code doesn\'t exist!', $response['AUTHORIZATIONRESULT']);
  }
}
