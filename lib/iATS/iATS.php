<?php
/**
 * @file
 * IATS API PHP wrapper.
 */

namespace iATS;

/**
 * Class iATS
 */
class iATS {
  // TODO: Document me.
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
  protected function getSoapClient($serverid, $endpoint, $options = array('trace' => TRUE)) {
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
  protected function getServer($serverid) {
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
  protected function getSoapResponse($serverid, $service, $request) {
    $servicename = get_class($service);
    $checkreestrictionsarray = array('IATSCustomerLink', 'IATSProcessLink');
    $restrictions = array();

    // TODO: Explain me.
    if (in_array($servicename, $checkreestrictionsarray)) {
      $restrict['server'] = $this->checkServerRestrictions($serverid, $service);
      $currency = $request['currency'];
      $mop = $request['mop'];
      $restrict['mop'] = $this->checkMOPCurrencyRestrictions($serverid, $currency, $mop);
      $restrictions = array_filter($restrict);
    }

    if (!empty($restrictions)) {
      return $restrictions;
    }
    else {
      try {
        $soap = $this->getSoapClient($serverid, $service->endpoint);
        $request['agentCode'] = $this->agentcode;
        $request['password'] = $this->password;
        $method = $service->method;
        $result = $service->result;
        $format = $service->format;
        $response = $soap->$method($request);
        $return = $service->responseHandler($response, $result, $format);
        return $return;
      }
      catch (SoapFault $exception) {
        return FALSE;
      }
    }

  }

  /**
   * Check server restrictions
   *
   * TODO: Why am I a separate method, only used once?
   *
   * @param string $serverid
   *   Server identifier
   * @param object $service
   *   Service object
   *
   * @return bool
   *   Result of server restricted check
   */
  protected function checkServerRestrictions($serverid, $service) {
    if (in_array($serverid, $service->restrictedservers)){
      return array(SERVICE_NOT_AVAILABLE);
    }
    return FALSE;
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
  protected function checkMOPCurrencyRestrictions($serverid, $currency, $mop) {
    $msg = 'MOP not available for this server for this currency';
    $matrix = $this->getMOPCurrencyMatrix();
    $filter = $this->MOPfilter($mop);
    if (isset($matrix[$serverid][$currency])) {
      // TODO: Seems this can be simplified using an anonymous function.
      $filter_result = array_filter($matrix[$serverid][$currency], $filter);
      return empty($filter_result) ? $msg : FALSE;
    }
    else {
      return $msg;
    }
  }

  /**
   * Method of payment filter closure.
   *
   * @param string $mop
   *   Method of payment
   *
   * @return callable
   *   Match
   */
  private function MOPfilter($mop) {
    return function($item) use($mop) {
      return $item == $mop;
    };
  }

  /**
   * MOP Currency matrix.
   *
   * @return array
   *   Array of Server/Currency/MOP
   */
  protected function getMOPCurrencyMatrix() {
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
