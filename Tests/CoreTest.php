<?php

namespace iATS;

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the core iATS API.
 */
class CoreTest extends TestCase {

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
   * Test bad request parameters.
   */
  public function testBadParameters() {
    $request = array(
      'customerIPAddress' => '',
      'mop' => 'VISA',
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