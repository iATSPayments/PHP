<?php
/**
 * ReportLink class file.
 * Targeting iATS API version 1.0.
 */

namespace iATS;

/**
 * Class ReportLink
 *
 * @package iATS
 */
class ReportLink extends Core {

  /**
   * ReportLink constructor.
   *
   * @param string $agentcode
   *   iATS account agent code.
   * @param string $password
   *   iATS account password.
   * @param string $serverid
   *   Server identifier (Defaults to 'NA').
   *   \see setServer()
   */
  public function __construct($agentcode, $password, $serverid = 'NA') {
    parent::__construct($agentcode, $password, $serverid);
    $this->endpoint = '/NetGate/ReportLink.asmx?WSDL';
  }

  /**
   * Get ACH / EFT Bank Reconciliation CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'fromDate' => 946684800,
   *     'toDate' => 946771200,
   *     'currency' => 'USD',
   *     'summaryOnly' => FALSE,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTBankReconciliationReportCSV($parameters) {
    $response = $this->apiCall('GetACHEFTBankReconciliationReportCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTBankReconciliationReportCSVV1Result', 'CSV');
  }

  /**
   * Get ACH / EFT Journal CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'date' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTJournalCSV($parameters) {
    $response = $this->apiCall('GetACHEFTJournalCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTJournalCSVV1Result', 'CSV');
  }

  /**
   * Get ACH / EFT Journal report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'date' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report array or API error.
   */
  public function GetACHEFTJournal($parameters) {
    $response = $this->apiCall('GetACHEFTJournal', $parameters);
    return $this->responseHandler($response, 'GetACHEFTJournalV1Result', 'AR');
  }

  /**
   * Get ACH / EFT Payment Box Journal CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'fromDate' => 946684800, // NOTE: Docs say 'fromDate', API says 'from'
   *     'toDate' => 946771200, // NOTE: Docs say 'toDate', API says 'to'
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTPaymentBoxJournalCSV($parameters) {
    $response = $this->apiCall('GetACHEFTPaymentBoxJournalCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTPaymentBoxJournalCSVV1Result', 'CSV');
  }

  /**
   * Get ACH / EFT Payment Box Reject CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'fromDate' => 946684800,
   *     'toDate' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTPaymentBoxRejectCSV($parameters) {
    $response = $this->apiCall('GetACHEFTPaymentBoxRejectCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTPaymentBoxRejectCSVV1Result', 'CSV');
  }

  /**
   * Get ACH / EFT Reject CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'date' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTRejectCSV($parameters) {
    $response = $this->apiCall('GetACHEFTRejectCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTRejectCSVV1Result', 'CSV');
  }

  /**
   * Get ACH / EFT Reject report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'date' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report array or API error.
   */
  public function getACHEFTReject($parameters) {
    $response = $this->apiCall('GetACHEFTReject', $parameters);
    return $this->responseHandler($response, 'GetACHEFTRejectV1Result', 'AR');
  }

  /**
   * Get ACH / EFT Return CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'date' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTReturnCSV($parameters) {
    $response = $this->apiCall('GetACHEFTReturnCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTReturnCSVV1Result', 'CSV');
  }

  /**
   * Get ACH / EFT Return report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'date' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report array or API error.
   */
  public function getACHEFTReturn($parameters) {
    $response = $this->apiCall('GetACHEFTReturn', $parameters);
    return $this->responseHandler($response, 'GetACHEFTReturnV1Result', 'AR');
  }

  /**
   * Get ACH / EFT Journal CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'date' => 946771200,
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHJournalCSV($parameters)
  {
    $response = $this->apiCall('GetACHJournalCSV', $parameters);
    return $this->responseHandler($response, 'GetACHJournalCSV_x0020_V1Result', 'CSV');
  }

  /**
   * Get Credit Card Journal CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'date' => 946771200,
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCCJournalCSV($parameters) {
    $response = $this->apiCall('GetCCJournalCSV', $parameters);
    return $this->responseHandler($response, 'GetCCJournalCSV_x0020_V1Result', 'CSV');
  }

  /**
   * Get Credit Card Payment Box Journal CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'from' => 946684800,
   *     'to' => 946771200,
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCCPaymentBoxJournalCSV($parameters) {
    $response = $this->apiCall('GetCCPaymentBoxJournalCSV', $parameters);
    return $this->responseHandler($response, 'GetCCPaymentBoxJournalCSV_x0020_V1Result', 'CSV');
  }

  /**
   * Get Credit Card Bank Reconciliation CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'fromDate' => 946684800,
   *     'toDate' => 946771200,
   *     'currency' => 'USD',
   *     'summaryOnly' => FALSE,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCreditCardBankReconciliationReportCSV($parameters) {
    $response = $this->apiCall('GetCreditCardBankReconciliationReportCSV', $parameters);
    return $this->responseHandler($response, 'GetCreditCardBankReconciliationReportCSVV1Result', 'CSV');
  }

  /**
   * Get Credit Card Journal CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'date' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCreditCardJournalCSV($parameters) {
    $response = $this->apiCall('GetCreditCardJournalCSVV1', $parameters);
    return $this->responseHandler($response, 'GetCreditCardJournalCSVV1Result', 'CSV');
  }

  /**
   * Get Credit Card Journal report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'date' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report array or API error.
   */
  public function getCreditCardJournal($parameters) {
    $response = $this->apiCall('GetCreditCardJournalV1', $parameters);
    return $this->responseHandler($response, 'GetCreditCardJournalV1Result', 'AR');
  }

  /**
   * Get Credit Card Payment Box Journal CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'fromDate' => 946684800,
   *     'toDate' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCreditCardPaymentBoxJournalCSV($parameters) {
    $response = $this->apiCall('GetCreditCardPaymentBoxJournalCSVV1', $parameters);
    return $this->responseHandler($response, 'GetCreditCardPaymentBoxJournalCSVV1Result', 'CSV');
  }

  /**
   * Get Credit Card Payment Box Reject CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'fromDate' => 946684800,
   *     'toDate' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCreditCardPaymentBoxRejectCSV($parameters) {
    $response = $this->apiCall('GetCreditCardPaymentBoxRejectCSVV1', $parameters);
    return $this->responseHandler($response, 'GetCreditCardPaymentBoxRejectCSVV1Result', 'CSV');
  }

  /**
   * Get Credit Card Reject report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   array(
   *     'date' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report array or API error.
   */
  public function getCreditCardReject($parameters) {
    $response = $this->apiCall('GetCreditCardReject', $parameters);
    return $this->responseHandler($response, 'GetCreditCardRejectV1Result', 'AR');
  }

  /**
   * Get Credit Card Reject CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *
   * @code
   *   $request = array(
   *     'date' => 946771200,
   *     'customerIPAddress' => '',
   *   );
   * @endcode
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCreditCardRejectCSV($parameters) {
    $response = $this->apiCall('GetCreditCardRejectCSV', $parameters);
    return $this->responseHandler($response, 'GetCreditCardRejectCSVV1Result', 'CSV');
  }

  /**
   * Response Handler for ReportLink calls.
   *
   * @param array $response
   *   Response
   * @param string $result
   *   Result string
   * @param string  $format
   *   Output format.
   *   'AR' will return array(),
   *   'CSV' will return a comma delimited data string with headers.
   *
   * @return mixed
   *   Response
   */
  public function responseHandler($response, $result, $format) {
    $return = $response->$result->any;
    switch ($format) {
      case 'AR':
        $result = $this->xml2array($response->$result->any);
        if ($result['STATUS'] == 'Failure') {
          $resp = 'Bad Credentials';
        }
        else {
          if (isset($result['JOURNALREPORT']['TN'])) {
            $resp = $result['JOURNALREPORT']['TN'];
          }
          else {
            $resp = 'No data returned for this date';
          }

        }
        return $resp;

      case 'CSV':
        if ($return != null)
        {
          $xml_element = new \SimpleXMLElement($return);
          return base64_decode($xml_element->FILE);
        }
        // Account for null being returned in a CSV request.
        return '';
    }
  }

}