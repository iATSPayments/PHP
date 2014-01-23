<?php
/**
 * @file
 * File description.
 */

namespace IATSAPI\Test;

use \IATSAPI\IATS;

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
