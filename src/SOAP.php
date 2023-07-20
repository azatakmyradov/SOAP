<?php

namespace Soap;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class SOAP {

    protected $client;

    protected $wsdl;

    protected $auth;

    protected $context;


    public function __construct($wsdl, $auth, $context = []) {
        $this->client = new Client([
            'auth' => [$auth['login'], $auth['password']]
        ]);

        $this->auth = $auth;
        $this->context = $context;
        $this->wsdl = $wsdl;
    }

    public function request($method, $action, $params) {
        $headers = [
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => $method
        ];

        $body = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wss="http://www.adonix.com/WSS">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <wss:run soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                            <callContext xsi:type="wss:CAdxCallContext">
                                <codeLang xsi:type="xsd:string">ENG</codeLang>
                                <poolAlias xsi:type="xsd:string">SEED</poolAlias>
                                <poolId xsi:type="xsd:string"></poolId>
                                <requestConfig xsi:type="xsd:string">adxwss.beautify=true&adxwss.optreturn=JSON</requestConfig>
                            </callContext>
                            <publicName xsi:type="xsd:string">' . $action . '</publicName>
                            <inputXml xsi:type="xsd:string">';

        $body .= json_encode($params);

        $body .= '</inputXml>
                </wss:run>
            </soapenv:Body>
        </soapenv:Envelope>';
        
        $request = new Request('POST', $this->wsdl, $headers, $body);

        return $this->client->sendAsync($request)->wait();
    }

    public function __call($method, $args) {
        return $this->request($method, ...$args);
    }

}