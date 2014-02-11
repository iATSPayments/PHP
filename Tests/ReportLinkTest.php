<?php
/**
 * @file
 * Unit tests for Report Link element of the iATS API.
 */

namespace iATS;

/**
 * Class ReportLinkTest
 *
 * @package IATSAPI\Test
 */
class ReportLinkTest extends \PHPUnit_Framework_TestCase {
  /**
   * Test no data.
   */
  public function testNoData() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    $date = strtotime('1/1/2025');
    $request = array(
      'customerIPAddress' => '',
      'date' => $date,
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCreditCardReject($request);
    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getCCRej.
   */
  public function testReportLinkgetCreditCardReject() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    $date = time();
    $request = array(
      'customerIPAddress' => '',
      'date' => $date,
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCreditCardReject($request);
    $this->assertTrue(TRUE);
  }

  /**
   * Test no data.
   */
  public function testReportLinkgetCreditCardRejectCSV() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    $date = time();
    $request = array(
      'customerIPAddress' => '',
      'date' => $date,
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCreditCardRejectCSV($request);
    $this->assertTrue(TRUE);
  }
//
//  /**
//   * No File.
//   */
//  public function testNoFile() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Timeout response.
//   */
//  public function testTimeout() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * No response to request.
//   */
//  public function testNoReponse() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Delayed response to request.
//   */
//  public function testDelay() {
//    $this->assertTrue(FALSE);
//  }

}
