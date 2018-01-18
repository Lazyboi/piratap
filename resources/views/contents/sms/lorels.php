<?php
if ( !class_exists('loreyni') ) {
  require_once('lorels1.php');
}
class annymsphQOI {
  const VERSION           = '1.3.1';
  const API_BASE_URL      = 'api.clockworksms.com/xml/';
  const API_AUTH_METHOD   = 'authenticate';
  const API_SMS_METHOD    = 'sms';
  const API_CREDIT_METHOD = 'credit';
  const API_BALANCE_METHOD = 'balance';
  public $key;
  public $ssl;
  public $proxy_host;
  public $proxy_port;
  public $from;
  public $long;
  public $truncate;
  public $log;
  public $invalid_char_action;
  public function __construct($key, array $options = array()) {
    if (empty($key)) {
      throw new loreyni("Key can't be blank");
    } else {
      $this->key = $key;
    }
    $this->ssl                  = (array_key_exists('ssl', $options)) ? $options['ssl'] : null;
    $this->proxy_host           = (array_key_exists('proxy_host', $options)) ? $options['proxy_host'] : null;
    $this->proxy_port           = (array_key_exists('proxy_port', $options)) ? $options['proxy_port'] : null;
    $this->from                 = (array_key_exists('from', $options)) ? $options['from'] : null;
    $this->long                 = (array_key_exists('long', $options)) ? $options['long'] : null;
    $this->truncate             = (array_key_exists('truncate', $options)) ? $options['truncate'] : null;
    $this->invalid_char_action  = (array_key_exists('invalid_char_action', $options)) ? $options['invalid_char_action'] : null;
    $this->log                  = (array_key_exists('log', $options)) ? $options['log'] : false;
  }
  public function send(array $sms) {
    if (!is_array($sms)) {
      throw new loreyni("sms parameter must be an array");
    }
    $single_message = $this->is_assoc($sms);
    if ($single_message) {
      $sms = array($sms);
    }
    $req_doc = new DOMDocument('1.0', 'UTF-8');
    $root = $req_doc->createElement('Message');
    $req_doc->appendChild($root);
    $user_node = $req_doc->createElement('Key');
    $user_node->appendChild($req_doc->createTextNode($this->key));
    $root->appendChild($user_node);
    for ($i = 0; $i < count($sms); $i++) {
      $single = $sms[$i];
      $sms_node = $req_doc->createElement('SMS');
      $sms_node->appendChild($req_doc->createElement('To', $single['to'])); 
      $content_node = $req_doc->createElement('Content');
      $content_node->appendChild($req_doc->createTextNode($single['message']));
      $sms_node->appendChild($content_node);
      if (array_key_exists('from', $single) || isset($this->from)) {
        $from_node = $req_doc->createElement('From');
        $from_node->appendChild($req_doc->createTextNode(array_key_exists('from', $single) ? $single['from'] : $this->from));
        $sms_node->appendChild($from_node);
      }
      if (array_key_exists('client_id', $single)) {
        $client_id_node = $req_doc->createElement('ClientID');
        $client_id_node->appendChild($req_doc->createTextNode($single['client_id']));
        $sms_node->appendChild($client_id_node);
      }
      if (array_key_exists('long', $single) || isset($this->long)) {
        $long = array_key_exists('long', $single) ? $single['long'] : $this->long;
        $long_node = $req_doc->createElement('Long');
        $long_node->appendChild($req_doc->createTextNode($long ? 1 : 0));
        $sms_node->appendChild($long_node);
      }
      if (array_key_exists('truncate', $single) || isset($this->truncate)) {
        $truncate = array_key_exists('truncate', $single) ? $single['truncate'] : $this->truncate;
        $trunc_node = $req_doc->createElement('Truncate');
        $trunc_node->appendChild($req_doc->createTextNode($truncate ? 1 : 0));
        $sms_node->appendChild($trunc_node);
      }
      if (array_key_exists('invalid_char_action', $single) || isset($this->invalid_char_action)) {
        $action = array_key_exists('invalid_char_action', $single) ? $single['invalid_char_action'] : $this->invalid_char_action;
        switch (strtolower($action)) {
          case 'error':
          $sms_node->appendChild($req_doc->createElement('InvalidCharAction', 1));
          break;
          case 'remove':
          $sms_node->appendChild($req_doc->createElement('InvalidCharAction', 2));
          break;
          case 'replace':
          $sms_node->appendChild($req_doc->createElement('InvalidCharAction', 3));
          break;
          default:
          break;
        }
      }
      $sms_node->appendChild($req_doc->createElement('WrapperID', $i));
      $root->appendChild($sms_node);
    }
    $req_xml = $req_doc->saveXML();
    $resp_xml = $this->postToClockwork(self::API_SMS_METHOD, $req_xml);
    $resp_doc = new DOMDocument();
    $resp_doc->loadXML($resp_xml);   
    $response = array();
    $err_no = null;
    $err_desc = null;
    foreach($resp_doc->documentElement->childNodes AS $doc_child) {
      switch(strtolower($doc_child->nodeName)) {
        case 'sms_resp':
        $resp = array();
        $wrapper_id = null;
        foreach($doc_child->childNodes AS $resp_node) {
          switch(strtolower($resp_node->nodeName)) {
            case 'messageid':
            $resp['id'] = $resp_node->nodeValue;
            break;
            case 'errno':
            $resp['error_code'] = $resp_node->nodeValue;
            break;
            case 'errdesc':
            $resp['error_message'] = $resp_node->nodeValue;
            break;
            case 'wrapperid':
            $wrapper_id = $resp_node->nodeValue;
            break;
          }
        }
        if( array_key_exists('error_code', $resp ) ) 
        {
          $resp['success'] = 0;
        } else {
          $resp['success'] = 1;
        }
        $resp['sms'] = $sms[$wrapper_id];
        array_push($response, $resp);
        break;
        case 'errno':
        $err_no = $doc_child->nodeValue;
        break;
        case 'errdesc':
        $err_desc = $doc_child->nodeValue;
        break;
      }
    }

    if (isset($err_no)) {
      throw new loreyni($err_desc, $err_no);
    }
        
    if ($single_message) {
      return $response[0];
    } else {
      return $response;
    }
  }
  public function checkCredit() {
    $req_doc = new DOMDocument('1.0', 'UTF-8');
    $root = $req_doc->createElement('Credit');
    $req_doc->appendChild($root);
    $root->appendChild($req_doc->createElement('Key', $this->key));
    $req_xml = $req_doc->saveXML();

    $resp_xml = $this->postToClockwork(self::API_CREDIT_METHOD, $req_xml);

    $resp_doc = new DOMDocument();
    $resp_doc->loadXML($resp_xml);
    $credit;
    $err_no = null;
    $err_desc = null;
        
    foreach ($resp_doc->documentElement->childNodes AS $doc_child) {
      switch ($doc_child->nodeName) {
        case "Credit":
        $credit = $doc_child->nodeValue;
        break;
        case "ErrNo":
        $err_no = $doc_child->nodeValue;
        break;
        case "ErrDesc":
        $err_desc = $doc_child->nodeValue;
        break;
        default:
        break;
      }
    }

    if (isset($err_no)) {
      throw new loreyni($err_desc, $err_no);
    }
    return $credit;
  }
  public function checkBalance() {
    $req_doc = new DOMDocument('1.0', 'UTF-8');
    $root = $req_doc->createElement('Balance');
    $req_doc->appendChild($root);
    $root->appendChild($req_doc->createElement('Key', $this->key));
    $req_xml = $req_doc->saveXML();
    $resp_xml = $this->postToClockwork(self::API_BALANCE_METHOD, $req_xml);	
    $resp_doc = new DOMDocument();
    $resp_doc->loadXML($resp_xml);
    $balance = null;
    $err_no = null;
    $err_desc = null;
    foreach ($resp_doc->documentElement->childNodes as $doc_child) {
      switch ($doc_child->nodeName) {
        case "Balance":
        $balance = number_format(floatval($doc_child->nodeValue), 2);
        break;
        case "Currency":
        foreach ($doc_child->childNodes as $resp_node) {
          switch ($resp_node->tagName) {
            case "Symbol":
            $symbol = $resp_node->nodeValue; 
            break;
            case "Code":
            $code = $resp_node->nodeValue; 
            break;
          }
        }
        break;
        case "ErrNo":
        $err_no = $doc_child->nodeValue;
        break;
        case "ErrDesc":
        $err_desc = $doc_child->nodeValue;
        break;
        default:
        break;
      }
    }

    if (isset($err_no)) {
      throw new loreyni($err_desc, $err_no);
    }
        
    return array( 'symbol' => $symbol, 'balance' => $balance, 'code' => $code );
  }
  public function checkKey() {
    $req_doc = new DOMDocument('1.0', 'UTF-8');
    $root = $req_doc->createElement('Authenticate');
    $req_doc->appendChild($root);
    $root->appendChild($req_doc->createElement('Key', $this->key));
    $req_xml = $req_doc->saveXML();
    $resp_xml = $this->postToClockwork(self::API_AUTH_METHOD, $req_xml);
    $resp_doc = new DOMDocument();
    $resp_doc->loadXML($resp_xml);
    $cust_id;
    $err_no = null;
    $err_desc = null;

    foreach ($resp_doc->documentElement->childNodes AS $doc_child) {
      switch ($doc_child->nodeName) {
        case "CustID":
        $cust_id = $doc_child->nodeValue;
        break;
        case "ErrNo":
        $err_no = $doc_child->nodeValue;
        break;
        case "ErrDesc":
        $err_desc = $doc_child->nodeValue;
        break;
        default:
        break;
      }
    }

    if (isset($err_no)) {
      throw new loreyni($err_desc, $err_no);
    }
    return isset($cust_id);   
  }
  protected function postToClockwork($method, $data) {
    if ($this->log) {
      $this->logXML("API $method Request XML", $data);
    }
    
    if( isset( $this->ssl ) ) {
      $ssl = $this->ssl;
    } else {
      $ssl = $this->sslSupport();
    }

    $url = $ssl ? 'https://' : 'http://';
    $url .= self::API_BASE_URL . $method;

    $response = $this->xmlPost($url, $data);

    if ($this->log) {
      $this->logXML("API $method Response XML", $response);
    }

    return $response;
  }
  protected function xmlPost($url, $data) {
    if(extension_loaded('curl')) {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
      curl_setopt($ch, CURLOPT_USERAGENT, 'Clockwork PHP Wrapper/1.0' . self::VERSION);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      if (isset($this->proxy_host) && isset($this->proxy_port)) {
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy_host);
        curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
      }

      $response = curl_exec($ch);
      $info = curl_getinfo($ch);

      if ($response === false || $info['http_code'] != 200) {
        throw new Exception('HTTP Error calling Clockwork API - HTTP Status: ' . $info['http_code'] . ' - cURL Erorr: ' . curl_error($ch));
      } elseif (curl_errno($ch) > 0) {
        throw new Exception('HTTP Error calling Clockwork API - cURL Error: ' . curl_error($ch));
      }

      curl_close($ch);

      return $response;
    } elseif (function_exists('stream_get_contents')) {
      $track = ini_get('track_errors');
      ini_set('track_errors',true);

      $params = array('http' => array(
      'method'  => 'POST',
      'header'  => "Content-Type: text/xml\r\nUser-Agent: mediaburst PHP Wrapper/" . self::VERSION . "\r\n",
      'content' => $data
      ));

      if (isset($this->proxy_host) && isset($this->proxy_port)) {
        $params['http']['proxy'] = 'tcp://'.$this->proxy_host . ':' . $this->proxy_port;
        $params['http']['request_fulluri'] = True;
      }

      $ctx = stream_context_create($params);
      $fp = @fopen($url, 'rb', false, $ctx);
      if (!$fp) {
        ini_set('track_errors',$track);
        throw new Exception("HTTP Error calling Clockwork API - fopen Error: $php_errormsg");
      }
      $response = @stream_get_contents($fp);
      if ($response === false) {
        ini_set('track_errors',$track);
        throw new Exception("HTTP Error calling Clockwork API - stream Error: $php_errormsg");
      }
      ini_set('track_errors',$track);
      return $response;
    } else {
      throw new Exception("Clockwork requires PHP5 with cURL or HTTP stream support");
    }
  }

  protected function sslSupport() {
    $ssl = false;
    if (extension_loaded('curl')) {
      $version = curl_version();
      $ssl = ($version['features'] & CURL_VERSION_SSL) ? true : false;
    } elseif (extension_loaded('openssl')) {
      $ssl = true;
    }
    return $ssl;
  }

  protected function logXML($log_msg, $xml) {
    // Tidy if possible
    if (class_exists('tidy')) {
      $tidy = new tidy;
      $config = array(
      'indent'     => true,
      'input-xml'  => true,
      'output-xml' => true,
      'wrap'       => 200
      );
      $tidy->parseString($xml, $config, 'utf8');
      $tidy->cleanRepair();
      $xml = $tidy;
    }
    error_log("Clockwork $log_msg: $xml");
  }

  protected function is_assoc($array) {
    return (bool)count(array_filter(array_keys($array), 'is_string'));
  }
  public static function is_valid_msisdn($val) {
    return preg_match( '/^[1-9][0-9]{7,12}$/', $val );
  }
}
