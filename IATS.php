<?php
/**
 * @file
 * File description.
 */

namespace IATSAPI;

/**
 * Class IATS
 *
 * @package IATSAPI
 */
class IATS {
  private $na_server = 'https://www.iatspayments.com';
  private $agentCode = '';
  private $password = '';
  const SERVICE_NOT_AVAILABLE = 'This service is not available on this server.';

  public function __construct($agentCode, $password) {
    $this->agentCode = $agentCode;
    $this->password = $password;
  }
  public function getSoapClient($serverID, $endpoint, $options = array('trace' => TRUE)) {
    $url = $this->getServer($serverID) . $endpoint;

    if (!isset($this->soap)) {
      $this->soap = SoapClient($url, $options);
    }
  }
  public function getServer($serverID) {
    switch ($serverID) {
      case 'NA':
        return $this->na_server;
        break;
    }
  }

  public function getSoapResponse($serverID, $service, $request) {
    $this->checkServerRestrictions($serverID, $service);

    try {
      $this->getSoapClient($serverID, $service->endpoint);
      $soap = $this->soap;
      $request['agentCode'] = $this->agentCode;
      $request['password'] = $this->password;
      $method = $service->method;
      $result = $service->result;
      $format = $service->format;
      $return = $service->responseHandler($soap->$method($request), $result, $format);
      return $return;
    }
    catch (SoapFault $exception) {
      dpm($exception);
      return FALSE;
    }
  }

  public function checkServerRestrictions($serverID, $service) {
    if (in_array($serverID, $service->restricted_servers)){
      return SERVICE_NOT_AVAILABLE;
    }
    return TRUE;
  }
}


/**
 * Class IATSServce
 *
 * @package IATSAPI
 */
class IATSServce {
  public $endpoint = '';
  public $method = '';
  public $result = '';
  public $format = '';
  public $restricted_servers = array();

  public function responseHandler($response, $result, $format) {
    switch ($format) {
      case 'XML':
        $return = $response->$result->any;
        return new SimpleXMLElement($return);

      case 'CSV':
        $return = $response->$result->any;
        $xml_element =  new SimpleXMLElement($return);
        $file =  base64_decode($xml_element->FILE);
        $file = 'test.csv';
        file_put_contents($file, $return);
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Length: ". filesize("$file").";");
        header("Content-Disposition: attachment; filename=$file");
        header("Content-Type: application/octet-stream; ");
        header("Content-Transfer-Encoding: binary");
        readfile($file);
    }
  }
}

/**
 * Class IATSReportLink
 *
 * @package IATSAPI
 */
class IATSReportLink extends IATSServce {
  public $endpoint = '/NetGate/ReportLink.asmx?WSDL';

  //GetCreditCardRejects
  public function getCCRej() {
    $this->method = 'GetCreditCardReject';
    $this->result = 'GetCreditCardRejectV1Result';
    $this->format = 'XML';
  }

  //GetCreditCardRejectsCSV
  public function getCCRejCSV() {
    $this->method = 'GetCreditCardRejectCSV';
    $this->result = 'GetCreditCardRejectCSVV1Result';
    $this->format = 'CSV';
    $this->restricted_servers = array('UK');
  }
}