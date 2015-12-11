<?php
/**
 * ReportLink class file.
 *
 * The ReportLink service is used to generate reports based on transactions
 * completed through the other iATS services.
 *
 * Reports include credit / debit card transactions, rejected transactions
 * and returns.
 *
 * Reports may be generated in either XML or CSV.
 *
 * Service guide: http://home.iatspayments.com/sites/default/files/iats_webservices_reportlink_version_4.0.pdf
 * API documentation: https://www.iatspayments.com/NetGate/ReportLink.asmx
 * Note: API methods with responses containing the string "x0020" are
 * depreciated and not supported by this class.
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
   *   @see setServer()
   */
  public function __construct($agentcode, $password, $serverid = 'NA') {
    parent::__construct($agentcode, $password, $serverid);
    $this->endpoint = '/NetGate/ReportLinkv2.asmx?WSDL';
  }

  /**
   * Get ACH / EFT Bank Reconciliation CSV report.
   * Provides a report of the bank balance of ACHEFT transactions.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'fromDate' => '2014-07-23T00:00:00+00:00' // The earliest date to gather report data for.
   *     'toDate' => '2024-07-23T23:59:59+00:00' // The latest date to gather report data for.
   *     'currency' => 'USD' // The currency to represent financial data as.
   *      // North America options: CAD, USD
   *      // UK options: USD, EUR, GBP, IEE, CHF, HKD, JPY, SGD, MXN
   *     'summaryOnly' => FALSE // True when a summarized report is required.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTBankReconciliationReportCSV($parameters) {
    $response = $this->apiCall('GetACHEFTBankReconciliationReportCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTBankReconciliationReportCSVResult', 'CSV');
  }

  /**
   * Get ACH / EFT approved transactions CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'date' => '2014-07-23T00:00:00+00:00' // The date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTApprovedSpecificDateCSV($parameters) {
    $response = $this->apiCall('GetACHEFTApprovedSpecificDateCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTApprovedSpecificDateCSVResult', 'CSV');
  }

  /**
   * Get ACH / EFT approved transactions report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'date' => '2014-07-23T00:00:00+00:00' // The date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report array or API error.
   */
  public function getACHEFTApprovedSpecificDateXML($parameters) {
    $response = $this->apiCall('GetACHEFTApprovedSpecificDateXML', $parameters);
    return $this->responseHandler($response, 'GetACHEFTApprovedSpecificDateXMLResult', 'AR');
  }

  /**
   * Get ACH/EFT Payment Box approved transactions CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'fromDate' => '2014-07-23T00:00:00+00:00' // The earliest date to gather report data for.
   *     'toDate' => '2024-07-23T23:59:59+00:00' // The latest date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *     'startIndex' => '0' // Optional.
   *     'endIndex' => '1' // Optional.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTApprovedDateRangeCSV($parameters) {
    $response = $this->apiCall('GetACHEFTApprovedDateRangeCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTApprovedDateRangeCSVResult', 'CSV');
  }

  /**
   * Get ACH / EFT Payment Box Reject CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'fromDate' => '2014-07-23T00:00:00+00:00' // The earliest date to gather report data for.
   *     'toDate' => '2024-07-23T23:59:59+00:00' // The latest date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *     'startIndex' => '0' // Optional.
   *     'endIndex' => '1' // Optional.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTRejectDateRangeCSV($parameters) {
    $response = $this->apiCall('GetACHEFTRejectDateRangeCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTRejectDateRangeCSVResult', 'CSV');
  }

  /**
   * Get ACH / EFT Reject CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'date' => '2014-07-23T00:00:00+00:00' // The date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTRejectSpecificDateCSV($parameters) {
    $response = $this->apiCall('GetACHEFTRejectSpecificDateCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTRejectSpecificDateCSVResult', 'CSV');
  }

  /**
   * Get ACH / EFT Reject report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'date' => '2014-07-23T00:00:00+00:00' // The date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   * @endcode
   *
   * @return mixed
   *   Report array or API error.
   */
  public function getACHEFTRejectSpecificDateXML($parameters) {
    $response = $this->apiCall('GetACHEFTRejectSpecificDateXML', $parameters);
    return $this->responseHandler($response, 'GetACHEFTRejectSpecificDateXMLResult', 'AR');
  }

  /**
   * Get ACH / EFT Payment Return Date Range CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'fromDate' => '2014-07-23T00:00:00+00:00' // The earliest date to gather report data for.
   *     'toDate' => '2024-07-23T23:59:59+00:00' // The latest date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTReturnDateRangeCSV($parameters) {
    $response = $this->apiCall('GetACHEFTReturnDateRangeCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTReturnDateRangeCSVResult', 'CSV');
  }

  /**
   * Get ACH / EFT Return CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'date' => '2014-07-23T00:00:00+00:00' // The date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getACHEFTReturnSpecificDateCSV($parameters) {
    $response = $this->apiCall('GetACHEFTReturnSpecificDateCSV', $parameters);
    return $this->responseHandler($response, 'GetACHEFTReturnSpecificDateCSVResult', 'CSV');
  }

  /**
   * Get ACH / EFT Return report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'date' => '2014-07-23T00:00:00+00:00' // The date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report array or API error.
   */
  public function getACHEFTReturnSpecificDateXML($parameters) {
    $response = $this->apiCall('GetACHEFTReturnSpecificDateXML', $parameters);
    return $this->responseHandler($response, 'GetACHEFTReturnSpecificDateXMLResult', 'AR');
  }

  /**
   * Get Credit Card Bank Reconciliation CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'fromDate' => '2014-07-23T00:00:00+00:00' // The earliest date to gather report data for.
   *     'toDate' => '2024-07-23T23:59:59+00:00' // The latest date to gather report data for.
   *     'currency' => 'USD' // The currency to represent financial data as.
   *      // North America options: CAD, USD
   *      // UK options: USD, EUR, GBP, IEE, CHF, HKD, JPY, SGD, MXN
   *     'summaryOnly' => FALSE // True when a summerized report is required.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCreditCardBankReconciliationReportCSV($parameters) {
    $response = $this->apiCall('GetCreditCardBankReconciliationReportCSV', $parameters);
    return $this->responseHandler($response, 'GetCreditCardBankReconciliationReportCSVResult', 'CSV');
  }

  /**
   * Get Credit Card approved transactions CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'date' => '2014-07-23T00:00:00+00:00' // The date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCreditCardApprovedSpecificDateCSV($parameters) {
    $response = $this->apiCall('GetCreditCardApprovedSpecificDateCSV', $parameters);
    return $this->responseHandler($response, 'GetCreditCardApprovedSpecificDateCSVResult', 'CSV');
  }

  /**
   * Get Credit Card approved transactions report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'date' => '2014-07-23T00:00:00+00:00' // The date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report array or API error.
   */
  public function getCreditCardApprovedSpecificDateXML($parameters) {
    $response = $this->apiCall('GetCreditCardApprovedSpecificDateXML', $parameters);
    return $this->responseHandler($response, 'GetCreditCardApprovedSpecificDateXMLResult', 'AR');
  }

  /**
   * Get Credit Card Payment Box approved transactions CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'fromDate' => '2014-07-23T00:00:00+00:00' // The earliest date to gather report data for.
   *     'toDate' => '2024-07-23T23:59:59+00:00' // The latest date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *     'startIndex' => '0' // Optional.
   *     'endIndex' => '1' // Optional.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCreditCardApprovedDateRangeCSV($parameters) {
    $response = $this->apiCall('GetCreditCardApprovedDateRangeCSV', $parameters);
    return $this->responseHandler($response, 'GetCreditCardApprovedDateRangeCSVResult', 'CSV');
  }

  /**
   * Get Credit Card Payment Box Reject CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'fromDate' => '2014-07-23T00:00:00+00:00' // The earliest date to gather report data for.
   *     'toDate' => '2024-07-23T23:59:59+00:00' // The latest date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *     'startIndex' => '0' // Optional.
   8     'endIndex' => '1' // Optional.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCreditCardRejectDateRangeCSV($parameters) {
    $response = $this->apiCall('GetCreditCardRejectDateRangeCSV', $parameters);
    return $this->responseHandler($response, 'GetCreditCardRejectDateRangeCSVResult', 'CSV');
  }

  /**
   * Get Credit Card Reject report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'date' => '2014-07-23T00:00:00+00:00' // The date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report array or API error.
   */
  public function getCreditCardRejectSpecificDateXML($parameters) {
    $response = $this->apiCall('GetCreditCardRejectSpecificDateXML', $parameters);
    return $this->responseHandler($response, 'GetCreditCardRejectSpecificDateXMLResult', 'AR');
  }

  /**
   * Get Credit Card Reject CSV report.
   *
   * @param array $parameters
   *   An associative array with the following possible values.
   *     'date' => '2014-07-23T00:00:00+00:00' // The date to gather report data for.
   *     'customerIPAddress' => '' // Optional. The client's IP address.
   *
   * @return mixed
   *   Report CSV (string) or API error.
   */
  public function getCreditCardRejectSpecificDateCSV($parameters) {
    $response = $this->apiCall('GetCreditCardRejectSpecificDateCSV', $parameters);
    return $this->responseHandler($response, 'GetCreditCardRejectSpecificDateCSVResult', 'CSV');
  }

  /**
   * Response Handler for ReportLink calls.
   *
   * @param object $response
   *   SOAP response
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
