<?php
/**
 * @file
 * Unit tests for the core iATS API.
 */

namespace iATS;

/**
 * Class CoreTest
 */
class CoreTest extends \PHPUnit_Framework_TestCase {

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
   * Test bad credentials.
   *
   * This test is currently disabled as the iATS API will lock out
   * accounts after a number of access attempts made using an
   * incorrect password.
   */
  public function testBadCredentials() {
    /*
    $agentcode = self::$agentCode;
    $password = self::$password . 'aa'; // Make password incorrect.

    $date = time();
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => '',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'companyName' => '',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'phone' => '',
      'fax' => '',
      'alternatePhone' => '',
      'email' => '',
      'comment' => '',
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4222222222222220',
      'cvv2' => '000',
      'invoiceNum' => '00000001',
      'creditCardExpiry' => '12/17',
      'mop' => 'VISA',
      'total' => '15',
      'date' => $date,
      'currency' => 'USD',
    );

    $iats = new ProcessLink($agentcode, $password, 'NA');
    $response = $iats->processCreditCard($request);
    $this->assertEquals($response,
      'Agent code has not been set up on the authorization system. Please call iATS at 1-888-955-5455.', $response);

    $iats = new CustomerLink($agentcode, $password, 'NA');
    $response = $iats->getCustomerCodeDetail($request);
    $this->assertEquals('Error : Invalid Username or Password.', $response['AUTHORIZATIONRESULT']);

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCreditCardReject($request);
    $this->assertEquals('Bad Credentials', $response);
    */

    $this->assertTrue(TRUE);
  }

  /**
   * Test bad request parameters.
   */
  public function testBadParameters() {
    $request = array(
      'customerIPAddress' => '',
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCard($request);

    $this->assertEquals('Object reference not set to an instance of an object.', $response);
  }

  /**
   * Test invalid currency for current server.
   */
  public function testProcessLinkprocessCreditCardInvalidCurrency() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'creditCardNum' => '4111111111111111',
      'creditCardExpiry' => '12/17',
      'cvv2' => '000',
      'mop' => 'VISA',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'total' => '5',
      'comment' => 'Process CC test.',
      // Not required for request
      'currency' => 'GBP'
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCard($request);

    $this->assertEquals('Service cannot be used with this Method of Payment or Currency.', $response);
  }

  /**
   * Test bad request.
   */
  public function testBadRequest() {
    $resultStr = '<IATSRESPONSE xmlns=""><STATUS>Failure</STATUS><ERRORS>Bad request.</ERRORS><PROCESSRESULT><AUTHORIZATIONRESULT/></PROCESSRESULT></IATSRESPONSE>';

    $result = new \StdClass();
    $result->ProcessCreditCardV1Result = new \StdClass();
    $result->ProcessCreditCardV1Result->any = $resultStr;

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->responseHandler($result, 'ProcessCreditCardV1Result');

    $this->assertEquals('Bad request.', $response);
  }
}