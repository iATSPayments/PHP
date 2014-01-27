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

    $iats = new IATS($agentcode, $password);
    $service = new IATSReportLink();
    $service->getCCRej();
    $response = $iats->getSoapResponse('NA', $service, $request);
    $this->assertTrue(FALSE);
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

    $iats = new IATS($agentcode, $password);
    $service = new IATSReportLink();
    $service->getCCRej();
    $response = $iats->getSoapResponse('NA', $service, $request);
    $this->assertEquals('No data returned for this date', $response);
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
