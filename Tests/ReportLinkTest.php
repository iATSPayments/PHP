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
   * Test getACHEFTJournalCSV.
   */
  public function testReportLinkgetACHEFTJournalCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTJournalCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTJournal.
   */
  public function testReportLinkgetACHEFTJournal() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTJournal($request);

    // ACH / EFT transactions are never processed when using the
    // test server, so a successful request is made without returning report data.
    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getACHEFTPaymentBoxJournalCSV.
   */
  public function testReportLinkgetACHEFTPaymentBoxJournalCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $fromTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $toTime = mktime(23, 59, 59, date('n'), date('j'), date('Y'));

    $request = array(
      'fromDate' => $iats->getFormattedDate($fromTime),
      'toDate' => $iats->getFormattedDate($toTime),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTPaymentBoxJournalCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getACHEFTPaymentBoxRejectCSV.
   */
  public function testReportLinkgetACHEFTPaymentBoxRejectCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $fromTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $toTime = mktime(23, 59, 59, date('n'), date('j'), date('Y'));

    $request = array(
      'fromDate' => $iats->getFormattedDate($fromTime),
      'toDate' => $iats->getFormattedDate($toTime),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTPaymentBoxRejectCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getACHEFTRejectCSV.
   */
  public function testReportLinkgetACHEFTRejectCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTRejectCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTReject.
   */
  public function testReportLinkgetACHEFTReject() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTReject($request);

    $this->assertArrayHasKey('TNID', $response[0]);
  }

  /**
   * Test getACHEFTReturnCSV.
   */
  public function testReportLinkgetACHEFTReturnCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTReturnCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTReturn.
   */
  public function testReportLinkgetACHEFTReturn() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getACHEFTReturn($request);

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
   * Test getCreditCardJournalCSV.
   */
  public function testReportLinkgetCreditCardJournalCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardJournalCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getCreditCardJournal.
   */
  public function testReportLinkgetCreditCardJournal() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardJournal($request);

    $this->assertArrayHasKey('TNID', $response[0]);
  }

  /**
   * Test getCreditCardPaymentBoxJournalCSV.
   */
  public function testReportLinkgetCreditCardPaymentBoxJournalCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $fromTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $toTime = mktime(23, 59, 59, date('n'), date('j'), date('Y'));

    $request = array(
      'fromDate' => $iats->getFormattedDate($fromTime),
      'toDate' => $iats->getFormattedDate($toTime),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardPaymentBoxJournalCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getCreditCardPaymentBoxRejectCSV.
   */
  public function testReportLinkgetCreditCardPaymentBoxRejectCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $fromTime = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $toTime = mktime(23, 59, 59, date('n'), date('j'), date('Y'));

    $request = array(
      'fromDate' => $iats->getFormattedDate($fromTime),
      'toDate' => $iats->getFormattedDate($toTime),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardPaymentBoxRejectCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getCreditCardReject.
   */
  public function testReportLinkgetCreditCardReject() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardReject($request);

    $this->assertArrayHasKey('TNID', $response[0]);
  }

  /**
   * Test getCreditCardRejectCSV.
   */
  public function testReportLinkgetCreditCardRejectCSV() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardRejectCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getCreditCardReject using a date with no data.
   */
  public function testReportLinkgetCreditCardRejectNoData() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    // Use a distant time in the future.
    $time = mktime(0, 0, 0, 1, 1, 2050);

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardReject($request);

    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getCreditCardRejectCSV using a date with no data.
   */
  public function testReportLinkgetCreditCardRejectCSVNoData() {
    $iats = new ReportLink(self::$agentCode, self::$password);

    $time = mktime(0, 0, 0, 1, 1, 2050);

    $request = array(
      'date' => $iats->getFormattedDate($time),
      'customerIPAddress' => '',
    );

    $response = $iats->getCreditCardRejectCSV($request);

    $this->assertEquals('', $response);
  }

  /**
   * Test getCreditCardReject with no response from the API.
   */
  public function testReportLinkgetCreditCardRejectNoResponse() {
    // Simulate no response from server.
    $resultStr = '';

    $result = new \StdClass();
    $result->GetCreditCardRejectV1Result = new \StdClass();
    $result->GetCreditCardRejectV1Result->any = $resultStr;

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->responseHandler($result, 'GetCreditCardRejectV1Result', 'AR');

    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getCreditCardRejectCSV with no response from the API.
   */
  public function testReportLinkgetCreditCardRejectCSVNoResponse() {
    // Simulate no response from server.
    $resultStr = '';

    $result = new \StdClass();
    $result->GetCreditCardRejectCSVV1Result = new \StdClass();
    $result->GetCreditCardRejectCSVV1Result->any = $resultStr;

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->responseHandler($result, 'GetCreditCardRejectCSVV1Result', 'CSV');

    $this->assertEquals('', $response);
  }
}
