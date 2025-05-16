<?php
    /*
		#echo Start of Soap1.1 (Basic_Http_Version)
				$soap = new DebugSoapClient('http://netconnect.bluedart.com/Demo/ShippingAPI/Finder/ServiceFinderQuery.svc?wsdl',
				array(
				'trace' 							=> 1,  
				'style'								=> SOAP_DOCUMENT,
				'use'									=> SOAP_LITERAL,
				'soap_version' 				=> SOAP_1_1
				));
				$soap->__setLocation("http://netconnect.bluedart.com/Demo/ShippingAPI/Finder/ServiceFinderQuery.svc/basic");
				
				$soap->sendRequest = true;
				$soap->printRequest = false;
				$soap->formatXML = true;
    #echo End of Soap1.1 (Basic_Http_Version)
      */
  
    
		#echo Start of Soap1.2 (WS_Http_Version)
				$soap = new DebugSoapClient('http://netconnect.bluedart.com/Demo/ShippingAPI/Finder/ServiceFinderQuery.svc?wsdl',
				array(
				'trace' 							=> 1,  
				'style'								=> SOAP_DOCUMENT,
				'use'									=> SOAP_LITERAL,
				'soap_version' 				=> SOAP_1_2
				));
				
				$soap->__setLocation("http://netconnect.bluedart.com/Demo/ShippingAPI/Finder/ServiceFinderQuery.svc");
				
				$soap->sendRequest = true;
				$soap->printRequest = false;
				$soap->formatXML = true;
				
				
				$actionHeader = new SoapHeader('http://www.w3.org/2005/08/addressing','Action','http://tempuri.org/IServiceFinderQuery/GetServicesforPincode',true);
				$soap->__setSoapHeaders($actionHeader);
		
		#echo End of Soap1.2 (ws_Http_Version)
   

$paramsLive = array('pinCode' => '400078',
		 'profile' => 
		 array(
		 	'Api_type' => 'S',
			'LicenceKey'=>'',
			'LoginID'=>'',
			'Version'=>'1.3')
			);
			
$params = array('pinCode' => '400078',
		 'profile' => 
		 array(
		 	'Api_type' => 'S',
			'Area'=>'',
			'Customercode'=>'',
			'IsAdmin'=>'',
			'LicenceKey'=>'',
			'LoginID'=>'',
			'Password'=>'',
			'Version'=>'1.3')
			);
			
#var_dump($params);
#echo '<h2>Parameters</h2><pre>'; print_r($params); echo '</pre>';
// Here I call my external function
$result = $soap->__soapCall('GetServicesforPincode',array($params));
#echo "<br>";
#var_dump($result);
/*
echo $result->GetServicesforPincodeResult->ErrorMessage ;
echo "<br>";
echo $result->GetServicesforPincodeResult->PincodeDescription;
echo "<br>";
*/
echo "<br>";
echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';


class DebugSoapClient extends SoapClient {
  public $sendRequest = true;
  public $printRequest = false;
  public $formatXML = false;

  public function __doRequest($request, $location, $action, $version, $one_way=0) {
    if ( $this->printRequest ) {
      if ( !$this->formatXML ) {
        $out = $request;
      }
      else {
        $doc = new DOMDocument;
        $doc->preserveWhiteSpace = false;
        $doc->loadxml($request);
        $doc->formatOutput = true;
        $out = $doc->savexml();
      }
      echo $out;
    }

    if ( $this->sendRequest ) {
      return parent::__doRequest($request, $location, $action, $version, $one_way);
    }
    else {
      return '';
    }
  }
}