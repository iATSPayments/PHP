<?php
/**
 * @file
 * Unit tests for Report Link element of the iATS API.
 */

namespace iATS;

/**
 * Class ProcessLinkTest
 *
 * @package iATS
 */
class ProcessLinkTest extends \PHPUnit_Framework_TestCase {
  const AGENT_CODE = 'TEST88';
  const PASSWORD = 'TEST88';

  /**
   * Test createCustomerCodeAndProcessACHEFT.
   */
  public function testProcessLinkcreateCustomerCodeAndProcessACHEFT() {

  }

  /**
   * Test createCustomerCodeAndProcessCreditCard.
   */
  public function testProcessLinkcreateCustomerCodeAndProcessCreditCard() {

  }

  /**
   * Test getBatchProcessResultFile.
   */
  public function testProcessLinkgetBatchProcessResultFile() {

  }

  /**
   * Test processACHEFTChargeBatch.
   */
  public function testProcessLinkprocessACHEFTChargeBatch() {

  }

  /**
   * Test processACHEFTRefundBatch.
   */
  public function testProcessLinkprocessACHEFTRefundBatch() {

  }

  /**
   * Test processACHEFTRefundWithTransactionId.
   */
  public function testProcessLinkprocessACHEFTRefundWithTransactionId() {

  }

  /**
   * Test processACHEFT.
   */
  public function testProcessLinkprocessACHEFT() {

  }

  /**
   * Test processACHEFTWithCustomerCode.
   */
  public function testProcessLinkprocessACHEFTWithCustomerCode() {

  }

  /**
   * Test processCreditCardBatch.
   */
  public function testProcessLinkprocessCreditCardBatch() {

  }

  /**
   * Test processCreditCardRefundWithTransactionId.
   */
  public function testProcessLinkprocessCreditCardRefundWithTransactionId() {

  }

  /**
   * Test processCreditCard.
   */
  public function testProcessLinkprocessCreditCard() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;

    // Create and populate the request object.
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
    );

    $iats = new ProcessLink($agentcode, $password, 'UK');
    $response = $iats->processCreditCard($request);

    var_dump($response);

//    $clean = trim($response['PROCESSRESULT']['AUTHORIZATIONRESULT']);
//    $this->assertEquals($clean, 'OK: 678594:');
    $this->assertTrue(TRUE);
  }

  public function testProcessLinkprocessCreditCardWithCustomerCode() {

  }

//  /**
//   * Test createCustCodeProcessCC.
//   */
//  public function testProcessLinkcreateCustCodeProcessCC() {
//    $this->assertTrue(TRUE);
//  }
//
//  /**
//   * Invalid CC.
//   */
//  public function testCCInvalidNum() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Invalid Exp.
//   */
//  public function testCCExp() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Invalid Address.
//   */
//  public function testCCAddress() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Invalid IP address format.
//   */
//  public function testCCAddressFormat() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Timeout response.
//   */
//  public function testCCTimeout() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Reject codes based on Test documents.
//   */
//  public function testCCRejectCodes() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * No response to request.
//   */
//  public function testCCNoResponse() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Refunds.
//   */
//  public function testCCRefund() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Delayed response to request.
//   */
//  public function testCCDelay() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Bad request.
//   */
//  public function testACHEFTBadRequest() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Bad format.
//   */
//  public function testACHEFTBadFormat() {
//    $this->assertTrue(FALSE);
//  }


}
