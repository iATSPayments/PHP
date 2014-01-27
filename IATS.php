<?php
/**
 * @file
 * IATS API PHP wrapper.
 */

/**
 * Class IATS
 */
class IATS {
  private $na_server = 'https://www.iatspayments.com';
  private $uk_server = 'https://www.uk.iatspayments.com';
  private $agentcode = '';
  private $password = '';
  const SERVICE_NOT_AVAILABLE = 'This service is not available on this server.';

  /**
   * IATS class constructor.
   *
   * @param string $agentcode
   *   IATS account Agent Code
   * @param string $password
   *   IATS account password
   */
  public function __construct($agentcode, $password) {
    $this->agentcode = $agentcode;
    $this->password = $password;
  }

  /**
   * Create SoapClient object.
   *
   * @param string $serverid
   *   Server identifier
   * @param string $endpoint
   *   Service endpoint
   * @param array $options
   *   SoapClient options
   *
   * @return SoapClient
   *   Returns IATS SoapClient object
   */
  public function getSoapClient($serverid, $endpoint, $options = array('trace' => TRUE)) {
    $url = $this->getServer($serverid) . $endpoint;
    return new SoapClient($url, $options);
  }

  /**
   * Get server URL.
   *
   * @param string $serverid
   *   Server identifier
   *
   * @return string
   *   Return server URL
   */
  public function getServer($serverid) {
    switch ($serverid) {
      case 'NA':
        return $this->na_server;

      case 'UK':
        return $this->uk_server;

    }
  }

  /**
   * Get Soap Response.
   *
   * @param string $serverid
   *   Server identifier
   * @param object $service
   *   Service object
   * @param array $request
   *   Request variable array
   *
   * @return mixed
   *   Error string or method results.
   */
  public function getSoapResponse($serverid, $service, $request) {
    $this->checkServerRestrictions($serverid, $service);
    $this->checkMOPCurrencyRestrictions(NULL, NULL, NULL);

    try {
      $soap = $this->getSoapClient($serverid, $service->endpoint);
      $request['agentcode'] = $this->agentcode;
      $request['password'] = $this->password;
      $method = $service->method;
      $result = $service->result;
      $format = $service->format;
      $return = $service->responseHandler($soap->$method($request), $result, $format);
      return $return;
    }
    catch (SoapFault $exception) {
      return FALSE;
    }
  }

  /**
   * Check server restrictions
   *
   * @param string $serverid
   *   Server identifier
   * @param object $service
   *   Service object
   *
   * @return bool
   *   Result of server restricted check
   */
  public function checkServerRestrictions($serverid, $service) {
    if (in_array($serverid, $service->restricted_servers)){
      $this->restricted = SERVICE_NOT_AVAILABLE;
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Check Method of Payment (MOP) is available based on server and currency.
   *
   * @param string $serverid
   *   Server identifier
   * @param string $currency
   *   Currency
   * @param string $mop
   *   Method of Payment
   *
   * @return bool
   *   Result of check
   */
  public function checkMOPCurrencyRestrictions($serverid, $currency, $mop) {
    return TRUE;
  }

  /**
   * MOP Currency matrix.
   *
   * @return array
   */
  public function getMOPCurrencyMatrix() {
    return array(
      'NA' => array(
        'USD' => array(
          'VISA','MC', 'AMX', 'DSC',
          'VISA DEBIT', 'MC DEBIT',
        ),
        'CDN' => array(
          'VISA', 'MC', 'AMX',
          'VISA DEBIT',
        ),
      ),
      'UK' => array(
        'GBP' => array(
          'VISA', 'MC', 'AMX', 'MAESTRO',
          'VISA DEBIT',
        ),
        'EUR'  => array(
          'VISA', 'MC', 'AMX',
          'VISA DEBIT',
        ),
      ),
    );
  }
}


/**
 * Class IATSServce
 */
class IATSService {
  public $endpoint = '';
  public $method = '';
  public $result = '';
  public $format = '';
  public $restrictedservers = array();
}

/**
 * Class IATSProcessLink
 */
class IATSProcessLink extends IATSService {
  public $endpoint = '/NetGate/ProcessLink.asmx?WSDL';

  /**
   * Sets properties for the ProcessCreditCardV1 method.
   */
  public function processCC() {
    $this->method = 'ProcessCreditCard';
    $this->result = 'ProcessCreditCardV1Result';
    $this->format = 'AR';
  }

  /**
   * Sets properties for the ProcessCreditCardWithCustomerCodeV1 method.
   */
  public function processCCwithCustCode() {
    $this->method = 'ProcessCreditCardWithCustomerCode';
    $this->result = 'ProcessCreditCardWithCustomerCodeV1Result';
    $this->format = 'AR';
  }

  /**
   * Response Handler for ProcessLink calls.
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
    $result = xmlstr_to_array($response->$result->any);
//    if ($result['PROCESSRESULT']['AUTHORIZATIONRESULT'] == 'REJECT: 1') {
//      $resp = 'Bad Credentials';
//    }
//    else {
//      $resp = $result;
//    }
    return $result;
  }
}

/**
 * Class IATSCustomerLink
 */
class IATSCustomerLink extends IATSService {
  public $endpoint = '/NetGate/CustomerLink.asmx?WSDL';

  /**
   * Sets properties for the GetCustomerCodeDetailV1 method.
   */
  public function getCustCode() {
    $this->method = 'GetCustomerCodeDetail';
    $this->result = 'GetCustomerCodeDetailV1Result';
    $this->format = 'AR';
  }

  /**
   * Response Handler for CustomerLink calls.
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
    $result = xmlstr_to_array($response->$result->any);
    if ($result['PROCESSRESULT']['AUTHORIZATIONRESULT'] == 'Error : Invalid Username or Password.') {
      $resp = 'Bad Credentials';
    }
    else {
      $resp = $result;
    }
    return $resp;
  }
}


/**
 * Class IATSReportLink
 *
 * @package IATSAPI
 */
class IATSReportLink extends IATSService {
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
          $resp = $result;
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


/**
 * From https://github.com/gaarf/XML-string-to-PHP-array/blob/master/xmlstr_to_array.php.
 *
 * @param array $xmlstr
 *   Array
 *
 * @return array|string
 *   Array
 */
function xmlstr_to_array($xmlstr) {
  $doc = new DOMDocument();
  $doc->loadXML($xmlstr);
  $root = $doc->documentElement;
  $output = domnode_to_array($root);
  $output['@root'] = $root->tagName;
  return $output;
}

/**
 * Parse nodes to arrays.
 *
 * @param mixed $node
 *   XML Node to be processed
 *
 * @return array|string
 *   Processed node
 */
function domnode_to_array($node) {
  $output = array();
  switch ($node->nodeType) {

    case XML_CDATA_SECTION_NODE:
    case XML_TEXT_NODE:
      $output = trim($node->textContent);
      break;

    case XML_ELEMENT_NODE:
      for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
        $child = $node->childNodes->item($i);
        $v = domnode_to_array($child);
        if (isset($child->tagName)) {
          $t = $child->tagName;
          if (!isset($output[$t])) {
            $output[$t] = array();
          }
          $output[$t][] = $v;
        }
        elseif ($v || $v === '0') {
          $output = (string) $v;
        }
      }
      if ($node->attributes->length && !is_array($output)) {
        $output = array('@content' => $output);
      }
      if (is_array($output)) {
        if ($node->attributes->length) {
          $a = array();
          foreach ($node->attributes as $attrName => $attrNode) {
            $a[$attrName] = (string) $attrNode->value;
          }
          $output['@attributes'] = $a;
        }
        foreach ($output as $t => $v) {
          if (is_array($v) && count($v) == 1 && $t != '@attributes') {
            $output[$t] = $v[0];
          }
        }
      }
      break;
  }
  return $output;
}
