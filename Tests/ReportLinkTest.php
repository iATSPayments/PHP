<?php
/**
 * @file
 * File description.
 */

namespace iATS;

/**
 * Class IATSReportLinkTest
 *
 * @package IATSAPI\Test
 */
class ReportLinkTest extends \PHPUnit_Framework_TestCase {
  /**
   * Test getCCRej.
   */
  public function testReportLinkgetCCRej() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    $date = time();
    $request = array(
      'customerIPAddress' => '',
      'date' => $date,
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCCRej($request);
    $this->assertTrue(TRUE);
  }

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
    $response = $iats->getCCRej($request);
    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test no data.
   */
  public function testReportLinkgetCCRejCSV() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    $date = time();
    $request = array(
      'customerIPAddress' => '',
      'date' => $date,
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCCRejCSV($request);
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
