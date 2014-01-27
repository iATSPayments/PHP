<?php
/**
 * @file
 * File description.
 */

/**
 * Class IATSProcessLinkTest
 *
 * @package IATSAPI\Test
 */
class IATSProcessLinkTest extends \PHPUnit_Framework_TestCase {
  /**
   * Test constructor.
   */
  public function testProcessLink() {
    $date = strtotime('12/17/2011');
    $beginDate = strtotime('10/23/2011');
    $endDate = strtotime('10/23/2014');

    $agentcode = 'TEST88';
    $password = 'TEST88';
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'ccNum' => '4222222222222220',
      'ccExp' => '12/17',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'cvv2' => '000',
      'total' => '2',
      // Not needed for request.
      'mop' => 'VISA',
      'currency' => 'USD',
    );

    $iats = new IATS($agentcode, $password);
    $service = new IATSProcessLink();
    $service->createCustCodeProcessCC();
    $response = $iats->getSoapResponse('NA', $service, $request);
    $this->assertTrue(TRUE);
  }

  /**
   * Invalid CC.
   */
  public function testCCInvalidNum() {
    $this->assertTrue(FALSE);
  }

  /**
   * Invalid Exp.
   */
  public function testCCExp() {
    $this->assertTrue(FALSE);
  }

  /**
   * Invalid Address.
   */
  public function testCCAddress() {
    $this->assertTrue(FALSE);
  }

  /**
   * Invalid IP address format.
   */
  public function testCCAddressFormat() {
    $this->assertTrue(FALSE);
  }

  /**
   * Timeout response.
   */
  public function testCCTimeout() {
    $this->assertTrue(FALSE);
  }

  /**
   * Reject codes based on Test documents.
   */
  public function testCCRejectCodes() {
    $this->assertTrue(FALSE);
  }

  /**
   * No response to request.
   */
  public function testCCNoResponse() {
    $this->assertTrue(FALSE);
  }

  /**
   * Refunds.
   */
  public function testCCRefund() {
    $this->assertTrue(FALSE);
  }

  /**
   * Delayed response to request.
   */
  public function testCCDelay() {
    $this->assertTrue(FALSE);
  }

  /**
   * Bad request.
   */
  public function testACHEFTBadRequest() {
    $this->assertTrue(FALSE);
  }

  /**
   * Bad format.
   */
  public function testACHEFTBadFormat() {
    $this->assertTrue(FALSE);
  }


}
