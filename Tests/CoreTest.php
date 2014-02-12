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
  const AGENT_CODE = 'TEST88';
  const PASSWORD = 'TEST88';

  /**
   * Test bad credentials.
   */
  public function testBadCredentials() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD . 'aa'; // Make password incorrect.

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
      'Agent code has not been set up on the authorization system. Please call iATS at 1-888-955-5455.');

    $iats = new CustomerLink($agentcode, $password, 'NA');
    $response = $iats->getCustomerCodeDetail($request);
    $this->assertEquals('Error : Invalid Username or Password.', $response);

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCreditCardReject($request);
    $this->assertEquals('Bad Credentials', $response);
  }

  /**
   * Test bad request parameters.
   */
  public function testBadParameters() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;

    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'creditCardNum' => '4222222222222220',
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
      'currency' => 'USD',
    );

    try {
      $iats = new ProcessLink(self::AGENT_CODE, self::PASSWORD);
      $response = $iats->processCreditCard($request);
    }
    catch (\SoapFault $exception)
    {
      // TODO: Test against exception error message.
    }
  }

//
//  /**
//   * Test that correct server used for currency.
//   */
//  public function testServerCurrency() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Bad request.
//   */
//  public function testBadRequest() {
//    $this->assertTrue(FALSE);
//  }

}
