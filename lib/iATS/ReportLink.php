<?php

namespace iATS;

/**
 * Class IATSReportLink
 *
 * @package IATSAPI
 */
class ReportLink extends Service {
  public $endpoint = '/NetGate/ReportLink.asmx?WSDL';

  /**
   * Sets properties for the GetCreditCardReject method.
   */
  public function getCCRej() {
    $this->method = 'GetCreditCardReject';
    $this->result = 'GetCreditCardRejectV1Result';
    $this->format = 'AR';
  }

  /**
   * Sets properties for the GetCreditCardRejectCSV method.
   */
  public function getCCRejCSV() {
    $this->method = 'GetCreditCardRejectCSV';
    $this->result = 'GetCreditCardRejectCSVV1Result';
    $this->format = 'CSV';
    $this->restricted_servers = array('UK');
  }

  /**
   * Response Handler for ReportLink calls.
   *
   * @param array $response
   *   Response
   * @param string $result
   *   Result string
   * @param string  $format
   *   Output format
   *
   * @return mixed
   *   Response
   */
  public function responseHandler($response, $result, $format) {
    $return = $response->$result->any;
    switch ($format) {
      case 'AR':
        $result = xmlstr_to_array($response->$result->any);
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
        $xml_element = new SimpleXMLElement($return);
        $file = base64_decode($xml_element->FILE);
        $file = 'test.csv';
        file_put_contents($file, $return);
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Length: " . filesize("$file") . ";");
        header("Content-Disposition: attachment; filename=$file");
        header("Content-Type: application/octet-stream; ");
        header("Content-Transfer-Encoding: binary");
        readfile($file);
    }
  }

}