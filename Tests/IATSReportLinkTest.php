<?php
/**
 * @file
 * File description.
 */

/**
 * Class IATSReportLinkTest
 *
 * @package IATSAPI\Test
 */
class IATSReportLinkTest extends \PHPUnit_Framework_TestCase {
  /**
   * Test constructor.
   */
  public function testReportLink() {
    $this->assertTrue(TRUE);
  }

  /**
   * No File.
   */
  public function testNoFile() {
    $this->assertTrue(FALSE);
  }

  /**
   * Timeout response.
   */
  public function testTimeout() {
    $this->assertTrue(FALSE);
  }

  /**
   * No response to request.
   */
  public function testNoReponse() {
    $this->assertTrue(FALSE);
  }

  /**
   * Delayed response to request.
   */
  public function testDelay() {
    $this->assertTrue(FALSE);
  }

}
