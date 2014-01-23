<?php
/**
 * @file
 * File description.
 */

namespace IATSAPI\Test;

use \IATSAPI\IATS;
use \IATSAPI\IATSReportLink;

/**
 * Class IATSSoapClientTest
 *
 * @package IATSAPI\Test
 */
class IATSSoapClientTest extends \PHPUnit_Framework_TestCase {
  /**
   * Test constructor.
   */
  public function testConstruct() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    $test = new IATS($agentcode, $password);
    $this->assertObjectHasAttribute('agentCode', $test);
    $this->assertObjectHasAttribute('password', $test);
  }

  /**
   * Bad credentials.
   */
  public function testBadCredentials() {
    $agentcode = 'TEST88';
    $password = 'TEST88';
    $iats = new IATS('TEST88', 'TEST88');
    $soapClient = $this->getMockBuilder('SoapClient')
                ->setMethods(array('methodOnService'))
                ->disableOriginalConstructor()
                ->getMock();
    $iats->soap = $soapClient;
    $service = new IATSReportLink();
    $service->getCCRejCSV();
    $request = array();
    $response = $iats->getSoapResponse('NA', $service, $request);
    $this->assertTrue(FALSE);
  }

  /**
   * Bad params.
   */
  public function testBadParams() {
    $this->assertTrue(FALSE);
  }

  /**
   * Test that correct server used for currency.
   */
  public function testServerCurrency() {
    $this->assertTrue(FALSE);
  }

  /**
   * Bad request.
   */
  public function testBadRequest() {
    $this->assertTrue(FALSE);
  }

}
