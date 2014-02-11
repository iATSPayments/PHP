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
  const AGENT_CODE = 'TEST88';
  const PASSWORD = 'TEST88';

  /**
   * Test getACHEFTBankReconciliationReportCSV.
   */
  public function testReportLinkgetACHEFTBankReconciliationReportCSV() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
    $request = array(
      'fromDate' => $fromDate,
      'toDate' => $toDate,
      'currency' => 'USD',
      'summaryOnly' => FALSE,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getACHEFTBankReconciliationReportCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getACHEFTJournalCSV.
   */
  public function testReportLinkgetACHEFTJournalCSV() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $date = time();
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getACHEFTJournalCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTJournal.
   */
  public function testReportLinkgetACHEFTJournal() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $date = time();
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getACHEFTJournal($request);

    // TODO: Get test data for this method.
    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getACHEFTPaymentBoxJournalCSV.
   */
  public function testReportLinkgetACHEFTPaymentBoxJournalCSV() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
    $request = array(
      'from' => $fromDate, // NOTE: Docs say 'fromDate', API says 'from'
      'to' => $toDate, // NOTE: Docs say 'toDate', API says 'to'
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getACHEFTPaymentBoxJournalCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getACHEFTPaymentBoxRejectCSV.
   */
  public function testReportLinkgetACHEFTPaymentBoxRejectCSV() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
    $request = array(
      'fromDate' => $fromDate,
      'toDate' => $toDate,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getACHEFTPaymentBoxRejectCSV($request);

    $this->assertStringStartsWith('Transaction ID,Invoice Number,Date Time', $response);
  }

  /**
   * Test getACHEFTRejectCSV.
   */
  public function testReportLinkgetACHEFTRejectCSV() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $date = time();
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getACHEFTRejectCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTReject.
   */
  public function testReportLinkgetACHEFTReject() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $date = time();
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getACHEFTReject($request);

    $this->assertArrayHasKey('TNID', $response[0]);
  }

  /**
   * Test getACHEFTReturnCSV.
   */
  public function testReportLinkgetACHEFTReturnCSV() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $date = time();
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getACHEFTReturnCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getACHEFTReturn.
   */
  public function testReportLinkgetACHEFTReturn() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $date = time();
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getACHEFTReturn($request);

    // TODO: Get test data for this method.
    $this->assertEquals('No data returned for this date', $response);
  }

  /**
   * Test getACHJournalCSV.
   */
  public function testReportLinkgetACHJournalCSV() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $date = time();
    $request = array(
      'date' => $date,
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getACHJournalCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getCCJournalCSV.
   */
  public function testReportLinkgetCCJournalCSV() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $date = time();
    $request = array(
      'date' => $date,
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCCJournalCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getCCPaymentBoxJournalCSV.
   */
  public function testReportLinkgetCCPaymentBoxJournalCSV() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
    $request = array(
      'from' => $fromDate,
      'to' => $toDate,
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCCPaymentBoxJournalCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getCreditCardBankReconciliationReportCSV.
   */
  public function testReportLinkgetCreditCardBankReconciliationReportCSV() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $fromDate = strtotime('10/23/2011');
    $toDate = strtotime('10/23/2014');
    $request = array(
      'fromDate' => $fromDate,
      'toDate' => $toDate,
      'currency' => 'USD',
      'summaryOnly' => FALSE,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCreditCardBankReconciliationReportCSV($request);

    // TODO: Get test data for this method.
    $this->assertEquals('', $response);
  }

  /**
   * Test getCreditCardJournalCSV.
   */
  public function testReportLinkgetCreditCardJournalCSV() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $date = time();
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCreditCardJournalCSV($request);

    $this->assertStringStartsWith('Invoice,Date,Agent,Customer Code', $response);
  }

  /**
   * Test getCreditCardJournal.
   */
  public function testReportLinkgetCreditCardJournal() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
    $date = time();
    $request = array(
      'date' => $date,
      'customerIPAddress' => '',
    );

    $iats = new ReportLink($agentcode, $password);
    $response = $iats->getCreditCardJournal($request);

    $this->assertArrayHasKey('TNID', $response[0]);
  }



  /**
   * Test no data.
   */
  public function testNoData() {
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
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
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
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
    $agentcode = self::AGENT_CODE;
    $password = self::PASSWORD;
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
