<?php
/**
 * @file
 * File description.
 */

namespace iATS;

/**
 * Class CoreTest
 */
class CoreTest extends \PHPUnit_Framework_TestCase {

  /**
   * Bad credentials.
   */
  public function testBadCredentials() {
    $agentcode = 'TEST88';
    $password = 'TEST88aa';
    $date = time();
    $request = array(
      'customerIPAddress' => '',
      'customerCode' => '',
      'firstName' => 'Test',
      'lastName' => 'Account',
      'companyName' => '',
      'address' => '1234 Any Street',
      'city' => 'Schenectady',
      'state' => 'NY',
      'zipCode' => '12345',
      'phone' => '',
      'fax' => '',
      'alternatePhone' => '',
      'email' => '',
      'comment' => '',
      'creditCardCustomerName' => 'Test Account',
      'creditCardNum' => '4222222222222220',
      'cvv2' => '000',
      'invoiceNum' => '00000001',
      'creditCardExpiry' => '12/17',
      'mop' => 'VISA',
      'total' => '15',
      'date' => $date,
      'currency' => 'USD',
    );

    $iats = new ProcessLink($agentcode, $password, 'NA');
    $response = $iats->processCreditCard($request);
    $this->assertEquals($response,
      'Agent code has not been set up on the authorization system. Please call iATS at 1-888-955-5455.');

    $service = new CustomerLink($agentcode, $password, 'NA');
    $response = $iats->getCustomerCodeDetail($request);
    $this->assertEquals('Bad Credentials', $response);

    $service = new ReportLink($agentcode, $password);
    $response = $iats->getCreditCardReject($request);
    $this->assertEquals('Bad Credentials', $response);

  }
//
//  /**
//   * Bad params.
//   */
//  public function testBadParams() {
//    $agentcode = 'TEST88';
//    $password = 'TEST88';
//    $date = strtotime('12/17/2011') + 'a';
//    // Create and populate the request object.
//    $request = array(
//     'customerIPAddress'=>'',
//     'customerCode'=>'(*&(*%&#(*&#',
//     'firstName'=>'Test',
//     'lastName'=>'Account',
//     'companyName'=>'',
//     'address'=>'1234 Any Street',
//     'city'=>'Schenectady',
//     'state'=>'NY',
//     'zipCode'=>'12345',
//     'phone'=>'',
//     'fax'=>'',
//     'alternatePhone'=>'',
//     'email'=>'',
//     'comment'=>'',
// //    'recurring'=>FALSE,
// //    'amount'=>'10',
// //    'beginDate'=>$beginDate,
// //    'endDate'=>$endDate,
// //    'scheduleType'=>'',
// //    'scheduleDate'=>'',
//     'creditCardCustomerName'=>'Test Account',
//     'creditCardNum'=>'4111111111111111a',
//     'cvv2'=>'000',
//     'invoiceNum' => '00000001',
//     'creditCardExpiry'=>'12/17',
//     'mop'=>'VISA',
//     'total' => '2.00',
//    'date' => '',
//    );
//
//    $iats = new iATS($agentcode, $password);
//    $service = new ProcessLink();
//    $service->processCCwithCustCode();
//    $response = $iats->getSoapResponse('NA', $service, $request);
//    $this->assertEquals('Bad Credentials', $response);
//  }
//
//  /**
//   * Test that correct server used for currency.
//   */
//  public function testServerCurrency() {
//    $this->assertTrue(FALSE);
//  }
//
//  /**
//   * Bad request.
//   */
//  public function testBadRequest() {
//    $this->assertTrue(FALSE);
//  }

}
