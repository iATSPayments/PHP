<?php
/**
 * @file
 * Unit tests for Report Link component of the iATS API.
 */

namespace iATS;

/**
 * Class ReportLinkTest
 *
 * @package IATSAPI\Test
 */
class ReportLinkTest extends \PHPUnit_Framework_TestCase {

  /** @var string $agentCode */
  private static $agentCode;

  /** @var string $password */
  private static $password;

  public function setUp()
  {
    self::$agentCode = IATS_AGENT_CODE;
    self::$password = IATS_PASSWORD;
  }

  /**
   * Test getACHEFTBankReconciliationReportCSV.
   */
  public function testReportLinkgetACHEFTBankReconciliationReportCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $fromTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $toTime = mktime(23, 59, 59, date('n'), date('j'), date('Y'));

    $request = array(
      'fromDate' => $iats->getFormattedDate($fromTime),
      'toDate' => $iats->getFormattedDate($toTime),
      'currency' => 'USD',
      'summaryOnly' => FALSE,
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTBankReconciliationReportCSV($request);

    // Test server doesn't provide access to bank balance data, so
    // a successful request is made without returning report data.
    $this->assertEquals('', $response);
  }

  /**
   * Test getACHEFTApprovedSpecificDateCSV.
   */
  public function testReportLinkgetACHEFTApprovedSpecificDateCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTApprovedSpecificDateCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTApprovedSpecificDateXML.
   */
  public function testReportLinkgetACHEFTApprovedSpecificDateXML() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTApprovedSpecificDateXML($request);

    // ACH / EFT transactions are never processed when using the
    // test server, so a successful request is made without returning report data.
    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getACHEFTApprovedDateRangeCSV.
   */
  public function testReportLinkgetACHEFTApprovedDateRangeCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $fromTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $toTime = mktime(23, 59, 59, date('n'), date('j'), date('Y'));

    $request = array(
      'fromDate' => $iats->getFormattedDate($fromTime),
      'toDate' => $iats->getFormattedDate($toTime),
      'customerIPAddress' => '',
      'startIndex' => '',
      'endIndex' => '',
    );

    $response = $iats->getACHEFTApprovedDateRangeCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getACHEFTRejectDateRangeCSV.
   */
  public function testReportLinkgetACHEFTRejectDateRangeCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $fromTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $toTime = mktime(23, 59, 59, date('n'), date('j'), date('Y'));

    $request = array(
      'fromDate' => $iats->getFormattedDate($fromTime),
      'toDate' => $iats->getFormattedDate($toTime),
      'customerIPAddress' => '',
      'startIndex' => '',
      'endIndex' => '',
    );

    $response = $iats->getACHEFTRejectDateRangeCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getACHEFTRejectSpecificDateCSV.
   */
  public function testReportLinkgetACHEFTRejectSpecificDateCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTRejectSpecificDateCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTRejectSpecificDateXML.
   */
  public function testReportLinkgetACHEFTRejectSpecificDateXML() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTRejectSpecificDateXML($request);

    $this->assertArrayHasKey('TNID', $response[0]);
  }

  /**
   * Test getACHEFTReturnSpecificDateCSV.
   */
  public function testReportLinkgetACHEFTReturnSpecificDateCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTReturnSpecificDateCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTReturnSpecificDateXML.
   */
  public function testReportLinkgetACHEFTReturnSpecificDateXML() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTReturnSpecificDateXML($request);

    // ACH / EFT refunds are not processed when using the test server,
    // so a successful request is made without returning report data.
    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getCreditCardBankReconciliationReportCSV.
   */
  public function testReportLinkgetCreditCardBankReconciliationReportCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $fromTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $toTime = mktime(23, 59, 59, date('n'), date('j'), date('Y'));

    $request = array(
      'fromDate' => $iats->getFormattedDate($fromTime),
      'toDate' => $iats->getFormattedDate($toTime),
      'currency' => 'USD',
      'summaryOnly' => FALSE,
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardBankReconciliationReportCSV($request);

    // Test server does not provide real account balance information,
    // so a successful request is made without returning report data.
    $this->assertEquals('', $response);
  }

  /**
   * Test getCreditCardApprovedSpecificDateCSV.
   */
  public function testReportLinkgetCreditCardApprovedSpecificDateCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardApprovedSpecificDateCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getCreditCardApprovedSpecificDateXML.
   */
  public function testReportLinkgetCreditCardApprovedSpecificDateXML() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardApprovedSpecificDateXML($request);

    $this->assertArrayHasKey('TNID', $response[0]);
  }

  /**
   * Test getCreditCardApprovedDateRangeCSV.
   */
  public function testReportLinkgetCreditCardApprovedDateRangeCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $fromTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $toTime = mktime(23, 59, 59, date('n'), date('j'), date('Y'));

    $request = array(
      'fromDate' => $iats->getFormattedDate($fromTime),
      'toDate' => $iats->getFormattedDate($toTime),
      'customerIPAddress' => '',
      'startIndex' => '',
      'endIndex' => '',
    );

    $response = $iats->getCreditCardApprovedDateRangeCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getCreditCardRejectDateRangeCSV.
   */
  public function testReportLinkgetCreditCardRejectDateRangeCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $fromTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $toTime = mktime(23, 59, 59, date('n'), date('j'), date('Y'));

    $request = array(
      'fromDate' => $iats->getFormattedDate($fromTime),
      'toDate' => $iats->getFormattedDate($toTime),
      'customerIPAddress' => '',
      'startIndex' => '',
      'endIndex' => '',
    );

    $response = $iats->getCreditCardRejectDateRangeCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getCreditCardRejectSpecificDateXML.
   */
  public function testReportLinkgetCreditCardRejectSpecificDateXML() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardRejectSpecificDateXML($request);

    $this->assertArrayHasKey('TNID', $response[0]);
  }

  /**
   * Test getCreditCardRejectSpecificDateCSV.
   */
  public function testReportLinkgetCreditCardRejectSpecificDateCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardRejectSpecificDateCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getCreditCardRejectSpecificDateXML using a date with no data.
   */
  public function testReportLinkgetCreditCardRejectSpecificDateXMLNoData() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    // Use a distant time in the future.
    $time = mktime(0, 0, 0, 1, 1, 2050);

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardRejectSpecificDateXML($request);

    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getCreditCardRejectSpecificDateCSV using a date with no data.
   */
  public function testReportLinkgetCreditCardRejectSpecificDateCSVNoData() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, 1, 1, 2050);

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardRejectSpecificDateCSV($request);

    $this->assertEquals('', $response);
  }

  /**
   * Test getCreditCardRejectSpecificDateXML with no response from the API.
   */
  public function testReportLinkgetCreditCardRejectSpecificDateXMLNoResponse() {

    // Simulate no response from server.
    $resultStr = '';

    $result = new \StdClass();
    $result->GetCreditCardRejectSpecificDateXMLResult = new \StdClass();
    $result->GetCreditCardRejectSpecificDateXMLResult->any = $resultStr;

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->responseHandler($result, 'GetCreditCardRejectSpecificDateXMLResult', 'AR');

    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getCreditCardRejectSpecificDateCSV with no response from the API.
   */
  public function testReportLinkgetCreditCardRejectSpecificDateCSVNoResponse() {

    // Simulate no response from server.
    $resultStr = '';

    $result = new \StdClass();
    $result->GetCreditCardRejectSpecificDateCSVResult = new \StdClass();
    $result->GetCreditCardRejectSpecificDateCSVResult->any = $resultStr;

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->responseHandler($result, 'GetCreditCardRejectSpecificDateCSVResult', 'CSV');

    $this->assertEquals('', $response);
  }
}
