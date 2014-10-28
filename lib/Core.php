<?php
/**
 * Core class file.
 */

namespace iATS;

/**
 * Class Core
 *
 * @package iATS
 */
class Core {

  /**
   * @var string $na_server
   *   North America server url.
   */
  private $na_server = 'https://www.iatspayments.com';

  /**
   * @var string $uk_server
   *   UK server url.
   */
  private $uk_server = 'https://www.uk.iatspayments.com';

  /**
   * @var string $agentcode
   *   iATS account agent code.
   */
  protected $agentcode = '';

  /**
   * @var string $password
   *   iATS account password.
   */
  protected $password = '';

  /**
   * @var string $serverid
   *   Server identifier.
   *
   *   @see Core::setServer()
   */
  protected $serverid = '';

  /**
   * @var string $server
   *   Server url.
   */
  protected $server = '';

  /**
   * @var string $endpoint
   *   Service endpoint
   */
  protected $endpoint = '';

  /**
   * @var string $params
   *   Requrest parameters
   */
  protected $params = '';

  /**
   * @var string $resultname
   *   The result name
   */
  public $resultname = '';

  /**
   * @var string $format
   *   Format
   */
  public $format = '';

  /**
   * @var array $restrictedservers
   *   Restricted servers array
   */
  public $restrictedservers = '';

  /**
   * IATS class constructor.
   *
   * @param string $agentcode
   *   iATS account agent code.
   * @param string $password
   *   iATS account password.
   * @param string $serverid
   *   Server identifier. (Defaults to 'NA')
   *
   * @see \iATS\Core::setServer() For options
   *
   */
  public function __construct($agentcode, $password, $serverid = 'NA') {
    $this->agentcode = $agentcode;
    $this->password = $password;
    $this->serverid = $serverid;
  }

  /**
   * Converts a UNIX timestamp to a date string formatted for SOAP requests.
   *
   * @param int $timestamp
   *   The timestamp to convert.
   *
   * @return string
   *   The formatted date string.
   */
  function getFormattedDate($timestamp) {
    return date('c', $timestamp);
  }

  /**
   * Create SoapClient object.
   *
   * @param string $endpoint
   *   Service endpoint
   * @param array $options
   *   SoapClient options
   *   @see http://www.php.net/manual/en/soapclient.soapclient.php
   *
   * @return \SoapClient
   *   Returns IATS SoapClient object
   */
  protected function getSoapClient($endpoint, $options = array()) {
    $this->setServer($this->serverid);
    $wsdl = $this->server . $endpoint;
    return new \SoapClient($wsdl, $options);
  }

  /**
   * Set the server to use based on a server id.
   *
   * @param string $serverid
   *   Server identifier ('UK' or 'NA'.)
   *
   * @throws \Exception
   */
  private function setServer($serverid) {
    switch ($serverid) {
      case 'NA':
        $this->server = $this->na_server;
        break;

      case 'UK':
        $this->server = $this->uk_server;
        break;

      default:
        throw new \Exception('Invalid Server ID.');
    }
  }

  /**
   * Make web service requests to the iATS API.
   *
   * @param string $method
   *   The name of the method to call.
   * @param array $parameters
   *   Parameters to pass the API.
   *
   * @return object
   *   XML object or boolean.
   * @throws \SoapFault
   */
  protected function apiCall($method, $parameters) {
    try {
      // Set the agentcode and password parameters.
      $parameters['agentCode'] = $this->agentcode;
      $parameters['password'] = $this->password;

      // The iATS API does not support IPv6 IP addresses.
      // Detect anything longer than an IPv4 address and remove it here.
      if (isset($parameters['customerIPAddress']) && (strlen($parameters['customerIPAddress']) > 15)) {
        $parameters['customerIPAddress'] = '';
      }

      $soap_options = array(
        'trace' => TRUE,
        'soap_version' => SOAP_1_2
      );

      $soap = $this->getSoapClient($this->endpoint, $soap_options);
      return $soap->$method($parameters);
    }
    catch (\SoapFault $exception) {
      throw new \SoapFault($exception->faultcode, $exception->getMessage());
    }
  }

  /**
   * Check restrictions for service.
   *
   * @param array $parameters
   *   Request parameters.
   *
   * @param bool $forceCurrencyCheck
   *  True to force a currency check even when currency or
   *  method of payment are missing.
   *
   * @return bool|string
   *   FALSE if no restrictions. Message if restricted.
   */
  protected function checkRestrictions($parameters, $forceCurrencyCheck = FALSE) {
    if ($this->checkServerRestrictions($this->serverid, $this->restrictedservers)) {
      return 'Service cannot be used on this server.';
    }

    $currency = isset($parameters['currency']) ? $parameters['currency'] : NULL;
    $mop = isset($parameters['mop']) ? $parameters['mop'] : NULL;

    if ((($currency != null) && ($mop != null)) || $forceCurrencyCheck)
    {
      if ($this->checkMOPCurrencyRestrictions($this->serverid, $currency, $mop)) {
       return 'Service cannot be used with this Method of Payment or Currency.';
      }
    }
    return FALSE;
  }

  /**
   * Check server restrictions.
   *
   * @param string $serverid
   *   Server identifier
   * @param array $restrictedservers
   *   Restricted servers array
   *
   * @return bool
   *   Result of server restricted check
   */
  protected function checkServerRestrictions($serverid, $restrictedservers) {
    if (is_array($restrictedservers) && in_array($serverid, $restrictedservers)) {
      return TRUE;
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
    $restricted = FALSE;
    $matrix = $this->getMOPCurrencyMatrix();
    if (isset($matrix[$serverid][$currency])) {
      // Validate Method of Payment (MOP) against currency.
      $filterresult = array_filter($matrix[$serverid][$currency],
        function ($item) use ($mop) {
          return $item == $mop;
        }
      );
      if (empty($filterresult)) {
        // Currency not valid for any Methods of Payment.
        $restricted = TRUE;
      }
      else {
        $restricted = FALSE;
      }
    }
    else
    {
      // Currency not valid for this server.
      $restricted = TRUE;
    }
    return $restricted;
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
        'CAD' => array(
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

  /**
   * Convert an XML string to an array.
   *
   * @param string $xmlstring
   *   An XML string to be processed.
   *
   * @return array
   *   Array.
   */
  protected function xml2array($xmlstring) {
    $xml = simplexml_load_string($xmlstring);
    $json = json_encode($xml);
    return json_decode($json, TRUE);
  }

  /**
   * Return a rejection message for a given code.
   *
   * @param int $reject_code
   *   iATS rejection code.
   *
   * @return array
   *   Rejection code and message as in array in the format:
   *   [
   *     'code' => 19,
   *     'message' => 'Incorrect CVV2 security code',
   *   ]
   */
  protected function rejectMessage($reject_code) {
    $rejects = array(
      1 => 'Agent code has not been set up on the authorization system. Please call iATS at 1-888-955-5455.',
      2 => 'Unable to process transaction. Verify and re-enter credit card information.',
      3 => 'Invalid Customer Code.',
      4 => 'Incorrect expiration date.',
      5 => 'Invalid transaction. Verify and re-enter credit card information.',
      6 => 'Please have cardholder call the number on the back of the card.',
      7 => 'Lost or stolen card.',
      8 => 'Invalid card status.',
      9 => 'Restricted card status. Usually on corporate cards restricted to specific sales.',
      10 => 'Error. Please verify and re-enter credit card information.',
      11 => 'General decline code. Please have client call the number on the back of credit card',
      12 => 'Incorrect CVV2 or Expiry date',
      14 => 'The card is over the limit.',
      15 => 'General decline code. Please have client call the number on the back of credit card',
      16 => 'Invalid charge card number. Verify and re-enter credit card information.',
      17 => 'Unable to authorize transaction. Authorizer needs more information for approval.',
      18 => 'Card not supported by institution.',
      19 => 'Incorrect CVV2 security code',
      22 => 'Bank timeout. Bank lines may be down or busy. Re-try transaction later.',
      23 => 'System error. Re-try transaction later.',
      24 => 'Charge card expired.',
      25 => 'Capture card. Reported lost or stolen.',
      26 => 'Invalid transaction, invalid expiry date. Please confirm and retry transaction.',
      27 => 'Please have cardholder call the number on the back of the card.',
      32 => 'Invalid charge card number.',
      39 => 'Contact IATS 1-888-955-5455.',
      40 => 'Invalid card number. Card not supported by IATS.',
      41 => 'Invalid Expiry date.',
      42 => 'CVV2 required.',
      43 => 'Incorrect AVS.',
      45 => 'Credit card name blocked. Call iATS at 1-888-955-5455.',
      46 => 'Card tumbling. Call iATS at 1-888-955-5455.',
      47 => 'Name tumbling. Call iATS at 1-888-955-5455.',
      48 => 'IP blocked. Call iATS at 1-888-955-5455.',
      49 => 'Velocity 1 – IP block. Call iATS at 1-888-955-5455.',
      50 => 'Velocity 2 – IP block. Call iATS at 1-888-955-5455.',
      51 => 'Velocity 3 – IP block. Call iATS at 1-888-955-5455.',
      52 => 'Credit card BIN country blocked. Call iATS at 1-888-955-5455.',
      100 => 'DO NOT REPROCESS. Call iATS at 1-888-955-5455.',
    );

    $result = array(
      'code' => $reject_code,
      'message' => isset($rejects[$reject_code]) ? $rejects[$reject_code] : '',
    );

    return $result;
  }

}
