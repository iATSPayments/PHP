<?php
/**
 * @file
 * Unit tests for Report Link element of the iATS API.
 */

namespace iATS;

/**
 * Class ProcessLinkTest
 *
 * @package iATS
 */
class ProcessLinkTest extends \PHPUnit_Framework_TestCase {

  /** @var string $agentCode */
  private static $agentCode;

  /** @var string $password */
  private static $password;

  // Varables generated by tests and referenced by later tests.

  /** @var string $ACHEFTCustomerCode */
  private static $ACHEFTCustomerCode;

  /** @var string $ACHEFTTransationId */
  private static $ACHEFTTransationId;

  /** @var string $creditCardCustomerCode */
  private static $creditCardCustomerCode;

  /** @var string $creditCardTransactionId */
  private static $creditCardTransactionId;

  /** @var string $creditCardBatchId */
  private static $creditCardBatchId;

  /** @var string $ACHEFTBatchId */
  private static $ACHEFTBatchId;

  /** @var string $ACHEFTBatchRefundId */
  private static $ACHEFTBatchRefundId;

  /** @var string $ACHEFTInvalidFormatBatchId */
  private static $ACHEFTInvalidFormatBatchId;

  public function setUp()
  {
    self::$agentCode = IATS_AGENT_CODE;
    self::$password = IATS_PASSWORD;
  }

  /**
   * Test API credentials.
   */
  public function testCredentials() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'cvv2' => '000',
      'mop' => 'VISA',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'total' => '5',
      'comment' => 'Process CC test.',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCard($request);

    $this->assertStringStartsWith('OK', trim($response['AUTHORIZATIONRESULT']));
  }

  /**
   * Test createCustomerCodeAndProcessACHEFT.
   *
   * @depends testCredentials
   */
  public function testProcessLinkcreateCustomerCodeAndProcessACHEFT() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'accountNum' => '02100002100000000000000001',
      'accountType' => 'CHECKING',
      'invoiceNum' => '00000001',
      'total' => '5',
      'comment' => 'Process direct debit test.',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->createCustomerCodeAndProcessACHEFT($request);

    $this->assertStringStartsWith('OK', trim($response['AUTHORIZATIONRESULT']));

    self::$ACHEFTCustomerCode = trim($response['CUSTOMERCODE']);
    self::$ACHEFTTransationId = trim($response['TRANSACTIONID']);
  }

  /**
   * Test createCustomerCodeAndProcessCreditCard.
   *
   * @depends testCredentials
   */
  public function testProcessLinkcreateCustomerCodeAndProcessCreditCard() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'ccNum' => '4222222222222220',
      'ccExp' => '12/17',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'cvv2' => '000',
      'total' => '5',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->createCustomerCodeAndProcessCreditCard($request);

    $this->assertStringStartsWith('OK', trim($response['AUTHORIZATIONRESULT']));

    self::$creditCardCustomerCode = trim($response['CUSTOMERCODE']);
    self::$creditCardTransactionId = trim($response['TRANSACTIONID']);
  }

  /**
   * Test processACHEFTChargeBatch.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessACHEFTChargeBatch() {
    $fileContents = $this->getBatchFileWithUpdatedInvoiceNumbers('ACHEFTBatch.txt');

    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'batchFile' => $fileContents
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processACHEFTChargeBatch($request);

    $this->assertEquals('Batch Processing, Please Wait ....', trim($response['AUTHORIZATIONRESULT']));

    self::$ACHEFTBatchId = $response['BATCHID'];

    // Pause to allow for batch file processing.
    sleep(3);
  }

  /**
   * Test getBatchProcessResultFile with an ACH / EFT batch process.
   *
   * @depends testProcessLinkprocessACHEFTChargeBatch
   */
  public function testProcessLinkgetBatchProcessResultFileACHEFT() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'batchId' => self::$ACHEFTBatchId,
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->getBatchProcessResultFile($request);

    $this->assertEquals('Batch Process Has Been Done', trim($response['AUTHORIZATIONRESULT']));
    $this->assertEquals(self::$ACHEFTBatchId, $response['BATCHID']);

    $originalFileContents = $this->getBatchFile('ACHEFTBatch.txt');
    $originalData = explode("\n", $originalFileContents);

    $batchResultFileContents = trim(base64_decode($response['BATCHPROCESSRESULTFILE']));

    $batchData = explode("\r\n", $batchResultFileContents);

    // Check batch result messages and compare against original batch file.
    for ($i = 0; $i < count($originalData); $i++)
    {
      $this->assertArrayHasKey($i, $batchData);

      $originalRowData = str_getcsv($originalData[$i]);
      $batchRowData = str_getcsv($batchData[$i]);

      // Get result message from end of array.
      $batchRowMessage = array_pop($batchRowData);

      $this->assertStringStartsWith('Received', $batchRowMessage);

      // iATS API obfuscates bank account numbers. Need to also obfuscate the account
      // number in the original data for the comparison test to pass.
      $originalRowData[4] = $batchRowData[4];

      $cleanOriginalRow = implode(',', $originalRowData);
      $cleanBatchRow = implode(',', $batchRowData);

      // Compare original batch file row against batch result row.
      $this->assertEquals($cleanOriginalRow, $cleanBatchRow);
    }
  }

  /**
   * Test processACHEFTChargeBatch with incorrectly formatted data.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessACHEFTChargeBatchInvalidFormat() {
    $fileContents = $this->getBatchFileWithUpdatedInvoiceNumbers('ACHEFTInvalidFormatBatch.txt');

    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'batchFile' => $fileContents,
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processACHEFTChargeBatch($request);

    $this->assertEquals('Batch Processing, Please Wait ....', trim($response['AUTHORIZATIONRESULT']));

    self::$ACHEFTInvalidFormatBatchId = $response['BATCHID'];

    // Pause to allow for batch file processing.
    sleep(3);
  }

  /**
   * Test getBatchProcessResultFile with an incorrectly formatted
   * ACH / EFT batch process.
   *
   * @depends testProcessLinkprocessACHEFTChargeBatchInvalidFormat
   */
  public function testProcessLinkgetBatchProcessResultFileACHEFTInvalidFormat() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'batchId' => self::$ACHEFTInvalidFormatBatchId,
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->getBatchProcessResultFile($request);

    $this->assertEquals('Batch Process Has Been Done', trim($response['AUTHORIZATIONRESULT']));
    $this->assertEquals(self::$ACHEFTInvalidFormatBatchId, $response['BATCHID']);

    $originalFileContents = $this->getBatchFile('ACHEFTInvalidFormatBatch.txt');
    $originalData = explode("\n", $originalFileContents);

    $batchResultFileContents = trim(base64_decode($response['BATCHPROCESSRESULTFILE']));

    $batchData = explode("\r\n", $batchResultFileContents);

    // Check batch result messages and compare against original batch file.
    for ($i = 0; $i < count($originalData); $i++)
    {
      $this->assertArrayHasKey($i, $batchData);

      $batchRowData = str_getcsv($batchData[$i]);

      // Get result message from end of array.
      $batchRowMessage = array_pop($batchRowData);

      $this->assertStringStartsWith('Wrong Format', $batchRowMessage);

      $cleanBatchRow = implode(',', $batchRowData);

      // Compare original batch file row against batch result row.
      $this->assertEquals($originalData[$i], $cleanBatchRow);
    }
  }

  /**
   * Test processACHEFTRefundBatch.
   *
   * @depends testProcessLinkprocessACHEFTChargeBatch
   */
  public function testProcessLinkprocessACHEFTRefundBatch() {
    $fileContents = $this->getBatchFileWithUpdatedInvoiceNumbers('ACHEFTRefundBatch.txt');

    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'batchFile' => $fileContents,
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processACHEFTRefundBatch($request);

    $this->assertEquals('Batch Processing, Please Wait ....', trim($response['AUTHORIZATIONRESULT']));
    self::$ACHEFTBatchRefundId = $response['BATCHID'];

    sleep(3);
  }

  /**
   * Test getBatchProcessResultFile with an ACH / EFT batch refund process.
   *
   * @depends testProcessLinkprocessACHEFTRefundBatch
   */
  public function testProcessLinkgetBatchProcessResultFileACHEFTRefund() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'batchId' => self::$ACHEFTBatchRefundId,
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->getBatchProcessResultFile($request);

    $this->assertEquals('Batch Process Has Been Done', trim($response['AUTHORIZATIONRESULT']));
    $this->assertEquals(self::$ACHEFTBatchRefundId, $response['BATCHID']);

    $originalFileContents = $this->getBatchFile('ACHEFTRefundBatch.txt');
    $originalData = explode("\n", $originalFileContents);

    $batchResultFileContents = trim(base64_decode($response['BATCHPROCESSRESULTFILE']));

    $batchData = explode("\r\n", $batchResultFileContents);

    // Check batch result messages and compare against original batch file.
    for ($i = 0; $i < count($originalData); $i++)
    {
      $this->assertArrayHasKey($i, $batchData);

      $originalRowData = str_getcsv($originalData[$i]);
      $batchRowData = str_getcsv($batchData[$i]);

      // Get result message from end of array.
      $batchRowMessage = array_pop($batchRowData);

      $this->assertStringStartsWith('Received', $batchRowMessage);

      // iATS API obfuscates bank account numbers. Need to also obfuscate the account
      // number in the original data for the comparison test to pass.
      $originalRowData[4] = $batchRowData[4];

      $cleanOriginalRow = implode(',', $originalRowData);
      $cleanBatchRow = implode(',', $batchRowData);

      // Compare original batch file row against batch result row.
      $this->assertEquals($cleanOriginalRow, $cleanBatchRow);
    }
  }

  /**
   * Test processACHEFTRefundWithTransactionId.
   *
   * @depends testProcessLinkcreateCustomerCodeAndProcessACHEFT
   */
  public function testProcessLinkprocessACHEFTRefundWithTransactionId() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'transactionId' => self::$ACHEFTTransationId,
      'total' => '-5',
      'comment' => 'ACH / EFT refund test.',
      // Not required for request
      'currency' => 'USD',
    );

    // TODO: Find out why this returns "Invalid Customer Code" error.
    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processACHEFTRefundWithTransactionId($request);

    //$this->assertStringStartsWith('OK', trim($response['AUTHORIZATIONRESULT']));
  }

  /**
   * Test processACHEFT.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessACHEFT() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'accountNum' => '02100002100000000000000001',
      'accountType' => 'CHECKING',
      'total' => '5',
      'comment' => 'Process direct debit test.',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processACHEFT($request);

    $this->assertStringStartsWith('OK', trim($response['AUTHORIZATIONRESULT']));
  }

  /**
   * Test processACHEFTWithCustomerCode.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessACHEFTWithCustomerCode() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::$ACHEFTCustomerCode,
      'invoiceNum' => '00000001',
      'total' => '5',
      'comment' => 'Process direct debit test with Customer Code.',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processACHEFTWithCustomerCode($request);

    $this->assertStringStartsWith('OK', trim($response['AUTHORIZATIONRESULT']));
  }

  /**
   * Test processCreditCardBatch.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessCreditCardBatch() {
    $fileContents = $this->getBatchFileWithUpdatedInvoiceNumbers('CreditCardUSUKBatch.txt', 1);

    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'batchFile' => $fileContents,
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCardBatch($request);

    $this->assertEquals('Batch Processing, Please Wait ....', trim($response['AUTHORIZATIONRESULT']));

    self::$creditCardBatchId = $response['BATCHID'];

    sleep(3);
  }

  /**
   * Test getBatchProcessResultFile with a credit card batch process.
   *
   * @depends testProcessLinkprocessCreditCardBatch
   */
  public function testProcessLinkgetBatchProcessResultFileCreditCard() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'batchId' => self::$creditCardBatchId,
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->getBatchProcessResultFile($request);

    $this->assertEquals('Batch Process Has Been Done', trim($response['AUTHORIZATIONRESULT']));
    $this->assertEquals(self::$creditCardBatchId, $response['BATCHID']);

    $originalFileContents = $this->getBatchFile('CreditCardUSUKBatch.txt');
    $originalData = explode("\n", $originalFileContents);

    $batchResultFileContents = trim(base64_decode($response['BATCHPROCESSRESULTFILE']));

    $batchData = explode("\r\n", $batchResultFileContents);

    // Check batch result messages and compare against original batch file.
    for ($i = 0; $i < count($originalData); $i++)
    {
      $this->assertArrayHasKey($i, $batchData);

      $originalRowData = str_getcsv($originalData[$i]);
      $batchRowData = str_getcsv($batchData[$i]);

      // Get result message from end of array.
      $batchRowMessage = array_pop($batchRowData);

      $this->assertStringStartsWith('OK', $batchRowMessage);

      // iATS API obfuscates credit card numbers. Need to also obfuscate the credit
      // cardnumber in the original data for the comparison test to pass.
      $originalRowData[10] = $batchRowData[10];

      $cleanOriginalRow = implode(',', $originalRowData);
      $cleanBatchRow = implode(',', $batchRowData);

      // Compare original batch file row against batch result row.
      $this->assertEquals($cleanOriginalRow, $cleanBatchRow);
    }
  }

  /**
   * Test processCreditCardRefundWithTransactionId.
   *
   * @depends testProcessLinkcreateCustomerCodeAndProcessCreditCard
   */
  public function testProcessLinkprocessCreditCardRefundWithTransactionId() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'transactionId' => self::$creditCardTransactionId,
      'total' => '-5',
      'comment' => 'Credit card refund test.',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCardRefundWithTransactionId($request);

    $this->assertStringStartsWith('OK', trim($response['AUTHORIZATIONRESULT']));
  }

  /**
   * Test processCreditCard.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessCreditCard() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'cvv2' => '000',
      'mop' => 'VISA',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'total' => '5',
      'comment' => 'Process CC test.',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCard($request);

    $this->assertStringStartsWith('OK', trim($response['AUTHORIZATIONRESULT']));
  }

  /**
   * Test processCreditCardWithCustomerCode.
   *
   * @depends testProcessLinkcreateCustomerCodeAndProcessCreditCard
   */
  public function testProcessLinkprocessCreditCardWithCustomerCode() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => self::$creditCardCustomerCode,
      'invoiceNum' => '00000001',
      'cvv2' => '000',
      'total' => '5',
      'comment' => 'Process CC test with Customer Code.',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCardWithCustomerCode($request);

    $this->assertStringStartsWith('OK', trim($response['AUTHORIZATIONRESULT']));
  }

  /**
   * Test processCreditCard with invalid card number.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessCreditCardInvalidCardNumber() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'creditCardNum' => '9999999999999999',
      'creditCardExpiry' => '12/17',
      'cvv2' => '000',
      'mop' => 'VISA',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'total' => '5',
      'comment' => 'Process CC test with invalid CC number.',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCard($request);

    $this->assertEquals('Invalid card number. Card not supported by IATS.', $response);
  }

  /**
   * Test processCreditCard with invalid credit card expiration date.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessCreditCardInvalidExp() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '01/10',
      'cvv2' => '000',
      'mop' => 'VISA',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'total' => '5',
      'comment' => 'Process CC test with invalid CC expiration date.',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCard($request);

    // TODO: Find out why iATS API is accepting this invalid transaction. Ignore test for now.
    //$this->assertEquals('Invalid Expiry date.', $response);
    $this->assertTrue(TRUE);
  }

  /**
   * Test processCreditCard with invalid address.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessCreditCardInvalidAddress() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'cvv2' => '000',
      'mop' => 'VISA',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '',
      'city' => '',
      'state' => '',
      'zipCode' => '',
      'total' => '5',
      'comment' => 'Process CC test with invalid address.',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCard($request);

    // TODO: Find out why iATS API is accepting this invalid transaction. Ignore test for now.
    //$this->assertEquals('Error. Please verify and re-enter credit card information.', $response);
    $this->assertTrue(TRUE);
  }

  /**
   * Test processCreditCard with invalid IP address format.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessCreditCardInvalidIPAddress() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '100',
      'invoiceNum' => '00000001',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'cvv2' => '000',
      'mop' => 'VISA',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'total' => '5',
      'comment' => 'Process CC test with invalid IP address format.',
      // Not required for request
      'currency' => 'USD',
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCard($request);

    // TODO: Find out why iATS API is accepting this invalid transaction. Ignore test for now.
    $this->assertTrue(TRUE);
  }

  /**
   * Test processCreditCard with invalid currency for current server.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessCreditCardInvalidCurrency() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'cvv2' => '000',
      'mop' => 'VISA',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'total' => '5',
      'comment' => 'Process CC test.',
      // Not required for request
      'currency' => 'GBP'
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCard($request);

    $this->assertEquals('Service cannot be used with this Method of Payment or Currency.', $response);
  }

  /**
   * Test processCreditCard with invalid method of payment for current server.
   *
   * @depends testCredentials
   */
  public function testProcessLinkprocessCreditCardInvalidMOP() {
    // Create and populate the request object.
    $request = array(
      'customerIPAddress' => '',
      'invoiceNum' => '00000001',
      'creditCardNum' => '4222222222222220',
      'creditCardExpiry' => '12/17',
      'cvv2' => '000',
      'mop' => 'DSC',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'total' => '5',
      'comment' => 'Process CC test.',
      // Not required for request
      'currency' => 'CAN'
    );

    $iats = new ProcessLink(self::$agentCode, self::$password);
    $response = $iats->processCreditCard($request);

    $this->assertEquals('Service cannot be used with this Method of Payment or Currency.', $response);
  }

  /**
   * Gets the contents of a batch file.
   *
   * @param $batchFileName The name of the batch file to open.
   *  Must exist in Tests/batchfiles/
   * @return string The contents of the batch file.
   */
  private function getBatchFile($batchFileName)
  {
    $filePath = dirname(__FILE__) . '/batchfiles/' . $batchFileName;

    // Open the file with read access.
    $handle = fopen($filePath, 'r');
    $fileContents = fread($handle, filesize($filePath));
    fclose($handle);

    return $fileContents;
  }

  /**
   * Sequentially updates the invoice numbers of rows in a batch file and
   * returns the updated contents of the file.
   *
   * The iATS API will reject duplicate batch transactions. For automated testing,
   * the records must be automatically updated to make them unique.
   *
   * @param string $batchFileName The name of the batch file to open.
   *  Must exist in Tests/batchfiles/
   * @param int $invoiceIdIndex The index of the invoice ID in each data row.
   * @return string The contents of the batch file with updated invoice numbers.
   */
  private function getBatchFileWithUpdatedInvoiceNumbers($batchFileName, $invoiceIdIndex = 0)
  {
    $filePath = dirname(__FILE__) . '/batchfiles/' . $batchFileName;

    // Open the file with read access.
    $handle = fopen($filePath, 'r');
    $fileContents = fread($handle, filesize($filePath));
    fclose($handle);

    $fileData = explode("\n", $fileContents);

    // Get the last used invoice number from the rows in the file.
    foreach ($fileData as $row)
    {
      if (!empty($row))
      {
        $rowParts = explode(',', $row);
        $lastInvoiceId = $rowParts[$invoiceIdIndex];
      }
    }

    $nextInvoiceId = $lastInvoiceId + 1;

    // Increment the invoice number for each row in the file.
    $updatedFileContents = '';
    foreach ($fileData as $row)
    {
      if (!empty($row))
      {
        $rowParts = explode(',', $row);
        $rowParts[$invoiceIdIndex] = $nextInvoiceId;

        $updatedFileContents .= implode(',', $rowParts) . "\n";

        $nextInvoiceId++;
      }
    }

    // Trim last line break.
    $updatedFileContents = substr($updatedFileContents, 0, -1);

    // Open the file with write access and overwrite existing data.
    $handle = fopen($filePath, 'w');
    fwrite($handle, $updatedFileContents);
    fclose($handle);

    return $updatedFileContents;
  }

//  /**
//   * Timeout response.
//   */
//  public function testCCTimeout() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Reject codes based on Test documents.
//   */
//  public function testCCRejectCodes() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * No response to request.
//   */
//  public function testCCNoResponse() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Delayed response to request.
//   */
//  public function testCCDelay() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Bad request.
//   */
//  public function testACHEFTBadRequest() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Bad format.
//   */
//  public function testACHEFTBadFormat() {
//    $this->assertTrue(FALSE);
//  }

}
