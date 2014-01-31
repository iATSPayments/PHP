<?php
/**
 * @file
 */

namespace iATS;

/**
 * Class CustomerLink
 *
 * @package iATS
 */
class CustomerLink extends Core {
  /**
   * CustomerLink constructor.
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
    $this->endpoint = '/NetGate/CustomerLink.asmx?WSDL';
  }

  /**
   * Get Customer Code Detail.
   *
   * @param array $parameters
   *   Request array.
   *
   * @return mixed
   *   Response.
   */
  public function getCustomerCodeDetail($parameters) {
    $response = $this->apiCall('GetCustomerCodeDetail', $parameters);
    return $this->responseHandler($response, 'GetCustomerCodeDetailV1Result');
  }

  /**
   * Create Credit Card Customer Code.
   *
   * @param $parameters
   *
   * @return mixed
   */
  public function createCreditCardCustomerCode($parameters) {
    $response = $this->apiCall('CreateCreditCardCustomerCode', $parameters);
    return $this->responseHandler($response, 'CreateCreditCardCustomerCodeV1Result');
  }

  /**
   * Response Handler for CustomerLink calls.
   *
   * @param array $response
   *   Response
   * @param string $result_name
   *   Result name string
   *
   * @return mixed
   *   Response
   */
  public function responseHandler($response, $result_name) {
    // Check restrictions.
    if ($this->checkServerRestrictions($this->server_id, $this->restrictedservers)) {
      return 'Service cannot be used on this server.';
    }

    $currency = isset($this->params['currency']) ? $this->params['currency'] : NULL;
    $mop = isset($this->params['mop']) ? $this->params['mop'] : NULL;
    if ($this->checkMOPCurrencyRestrictions($this->server_id, $currency, $mop)) {
      return 'Service cannot be used with this Method of Payment or Currency.';
    }

    $result = $this->xml2array($response->$result_name->any);
    return $result;
  }
}
