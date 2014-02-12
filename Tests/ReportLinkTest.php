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
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
    $request = array(
      'fromDate' => $fromDate,
      'toDate' => $toDate,
      'currency' => 'USD',
      'summaryOnly' => FALSE,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTBankReconciliationReportCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getACHEFTJournalCSV.
   */
  public function testReportLinkgetACHEFTJournalCSV() {
    $date = time();
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
    $date = time();
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTJournal($request);

    // TODO: Get test data for this method.
    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getACHEFTPaymentBoxJournalCSV.
   */
  public function testReportLinkgetACHEFTPaymentBoxJournalCSV() {
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
    $request = array(
      'from' => $fromDate, // NOTE: Docs say 'fromDate', API says 'from'
      'to' => $toDate, // NOTE: Docs say 'toDate', API says 'to'
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTPaymentBoxJournalCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getACHEFTPaymentBoxRejectCSV.
   */
  public function testReportLinkgetACHEFTPaymentBoxRejectCSV() {
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
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
    $date = time();
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
    $date = time();
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
    $date = time();
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
    $date = time();
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHEFTReturn($request);

    // TODO: Get test data for this method.
    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getACHJournalCSV.
   */
  public function testReportLinkgetACHJournalCSV() {
    $date = time();
    $request = array(
      'date' => $date,
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getACHJournalCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getCCJournalCSV.
   */
  public function testReportLinkgetCCJournalCSV() {
    $date = time();
    $request = array(
      'date' => $date,
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getCCJournalCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getCCPaymentBoxJournalCSV.
   */
  public function testReportLinkgetCCPaymentBoxJournalCSV() {
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
    $request = array(
      'from' => $fromDate,
      'to' => $toDate,
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getCCPaymentBoxJournalCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getCreditCardBankReconciliationReportCSV.
   */
  public function testReportLinkgetCreditCardBankReconciliationReportCSV() {
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
    $request = array(
      'fromDate' => $fromDate,
      'toDate' => $toDate,
      'currency' => 'USD',
      'summaryOnly' => FALSE,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink(self::$agentCode, self::$password);
    $response = $iats->getCreditCardBankReconciliationReportCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getCreditCardJournalCSV.
   */
  public function testReportLinkgetCreditCardJournalCSV() {
    $date = time();
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
    $date = time();
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
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
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
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
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
    $date = time();
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
    $date = time();
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

  // TODO: Address timeout and non-response errors. May be better suited to CoreTest.php

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
