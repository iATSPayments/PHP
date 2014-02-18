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
    $fromDate = strtotime(date('m/d/Y', time()) . '00:00:00');
    $toDate = strtotime(date('m/d/Y', time()) . '23:59:59');
    $request = array(
      'fromDate' => $fromDate,
      'toDate' => $toDate,
      'currency' => 'USD',
      'summaryOnly' => FALSE,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTBankReconciliationReportCSV($request);

    // Test server doesn't provide access to bank balance data, so
    // a successful request is made without returning report data.
    $this->assertEquals('', $response);
  }

  /**
   * Test getACHEFTJournalCSV.
   */
  public function testReportLinkgetACHEFTJournalCSV() {
    $date = strtotime(date('m/d/Y', time()) . '00:00:00');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTJournalCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTJournal.
   */
  public function testReportLinkgetACHEFTJournal() {
    $date = strtotime(date('m/d/Y', time()) . '00:00:00');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTJournal($request);

    // ACH / EFT transactions are never processed when using the
    // test server, so a successful request is made without returning report data.
    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getACHEFTPaymentBoxRejectCSV.
   */
  public function testReportLinkgetACHEFTPaymentBoxRejectCSV() {
    $fromDate = strtotime(date('m/d/Y', time()) . '00:00:00');
    $toDate = strtotime(date('m/d/Y', time()) . '23:59:59');
    $request = array(
      'fromDate' => $fromDate,
      'toDate' => $toDate,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTPaymentBoxRejectCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getACHEFTRejectCSV.
   */
  public function testReportLinkgetACHEFTRejectCSV() {
    $date = strtotime(date('m/d/Y', time()) . '00:00:00');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTRejectCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTReject.
   */
  public function testReportLinkgetACHEFTReject() {
    $date = strtotime(date('m/d/Y', time()) . '00:00:00');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTReject($request);

    $this->assertArrayHasKey('TNID', $response[0]);
  }

  /**
   * Test getACHEFTReturnCSV.
   */
  public function testReportLinkgetACHEFTReturnCSV() {
    $date = strtotime(date('m/d/Y', time()) . '00:00:00');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTReturnCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTReturn.
   */
  public function testReportLinkgetACHEFTReturn() {
    $date = strtotime(date('m/d/Y', time()) . '00:00:00');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTReturn($request);

    // ACH / EFT refunds are not processed when using the test server,
    // so a successful request is made without returning report data.
    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getCreditCardBankReconciliationReportCSV.
   */
  public function testReportLinkgetCreditCardBankReconciliationReportCSV() {
    $fromDate = strtotime(date('m/d/Y', time()) . '00:00:00');
    $toDate = strtotime(date('m/d/Y', time()) . '23:59:59');
    $request = array(
      'fromDate' => $fromDate,
      'toDate' => $toDate,
      'currency' => 'USD',
      'summaryOnly' => FALSE,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getCreditCardBankReconciliationReportCSV($request);

    // Test server does not provide real account balance information,
    // so a successful request is made without returning report data.
    $this->assertEquals('', $response);
  }

  /**
   * Test getCreditCardJournalCSV.
   */
  public function testReportLinkgetCreditCardJournalCSV() {
    $date = strtotime(date('m/d/Y', time()) . '00:00:00');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getCreditCardJournalCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getCreditCardJournal.
   */
  public function testReportLinkgetCreditCardJournal() {
    $date = strtotime(date('m/d/Y', time()) . '00:00:00');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getCreditCardJournal($request);

    $this->assertArrayHasKey('TNID', $response[0]);
  }

  /**
   * Test getCreditCardPaymentBoxJournalCSV.
   */
  public function testReportLinkgetCreditCardPaymentBoxJournalCSV() {
    $fromDate = strtotime(date('m/d/Y', time()) . '00:00:00');
    $toDate = strtotime(date('m/d/Y', time()) . '23:59:59');
    $request = array(
      'fromDate' => $fromDate,
      'toDate' => $toDate,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getCreditCardPaymentBoxJournalCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getCreditCardPaymentBoxRejectCSV.
   */
  public function testReportLinkgetCreditCardPaymentBoxRejectCSV() {
    $fromDate = strtotime(date('m/d/Y', time()) . '00:00:00');
    $toDate = strtotime(date('m/d/Y', time()) . '23:59:59');
    $request = array(
      'fromDate' => $fromDate,
      'toDate' => $toDate,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getCreditCardPaymentBoxRejectCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getCreditCardReject.
   */
  public function testReportLinkgetCreditCardReject() {
    $date = strtotime(date('m/d/Y', time()) . '00:00:00');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getCreditCardReject($request);

    $this->assertArrayHasKey('TNID', $response[0]);
  }

  /**
   * Test getCreditCardRejectCSV.
   */
  public function testReportLinkgetCreditCardRejectCSV() {
    $date = strtotime(date('m/d/Y', time()) . '00:00:00');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getCreditCardRejectCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getCreditCardReject using a date with no data.
   */
  public function testReportLinkgetCreditCardRejectNoData() {
    $date = strtotime('1/1/2025');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getCreditCardReject($request);

    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getCreditCardRejectCSV using a date with no data.
   */
  public function testReportLinkgetCreditCardRejectCSVNoData() {
    $date = strtotime('1/1/2025');
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
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
