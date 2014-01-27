<?php
/**
 * @file
 * File description.
 */

/**
 * Class IATSCustomerLinkTest
 *
 * @package IATSAPI\Test
 */
class IATSCustomerLinkTest extends \PHPUnit_Framework_TestCase {
  /**
   * Test constructor.
   */
  public function testCustomerLink() {
    $this->assertTrue(TRUE);
  }

  /**
   * Invalid customer code.
   */
  public function testCustCode() {
    $this->assertTrue(FALSE);
  }

  /**
   * Change recurring schedule date.
   */
  public function testRecurDate() {
    $this->assertTrue(FALSE);
  }

  /**
   * Change recurring schedule frequency.
   */
  public function testRecurFrequency() {
    $this->assertTrue(FALSE);
  }

  /**
   * Change recurring schedule card details.
   */
  public function testRecurDetails() {
    $this->assertTrue(FALSE);
  }

}
