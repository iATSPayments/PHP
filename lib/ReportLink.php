<?php
/**
 * @file
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
   *   Agent code.
   * @param string $password
   *   Password.
   * @param string $server_id
   *   Server ID ('UK' or 'NA'. Defaults to 'NA')
   */
  public function __construct($agentcode, $password, $server_id = 'NA') {
    parent::__construct($agentcode, $password, $server_id);
    $this->endpoint = '/NetGate/ReportLink.asmx?WSDL';
  }

  /**
   * @param $parameters
   *
   * @return mixed
   */
  public function getCCRej($parameters) {
    $response = $this->apiCall('GetCreditCardReject', $parameters);
    return $this->responseHandler($response, 'GetCreditCardRejectV1Result', 'AR');
  }

  /**
   * @param $parameters
   *
   * @return mixed
   */
  public function getCCRejCSV($parameters) {
    // TODO: Handle restricted servers.
    $this->restricted_servers = array('UK');
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
        $xml_element = new \SimpleXMLElement($return);
        return base64_decode($xml_element->FILE);
    }
  }

}