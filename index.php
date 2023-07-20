<?php

require 'vendor/autoload.php';

$client = new \Soap\SOAP('http://20.83.183.254:8124/soap-generic/syracuse/collaboration/syracuse/CAdxWebServiceXmlCC', [
    'login' => 'admin',
    'password' => 'DragonsAREfun33!'
]);

$params = [
    'GRP1' => [
        "MFGFCY"    => "NA011",
        "MFGNUM"    => "WONA0110001",
        "MFGTRKDAT" => "20230720",
        "TRSNUM"    => "STD",
        "LOC"       => "QUA01",
        "STA"       => "A"
    ],
    'GRP2' => [
        [
            "QTYSTU" => 1,
            "UOM" => "UN",
            "LOT" => "",
            "MVTDES" => "PID0002"
        ]
    ]
];
$result = $client->run('ZWSMTK', $params);

// $params = [
//     'GRP1' => [
//         "I_FCY"    => "NA011",
//         "I_MFGNUM"    => "WONA0110001",
//         "I_ITM" => "COM013",
//         "I_QTY"    => 1,
//         "I_LOC"       => "QUA01",
//         "I_LOT" => "",
//         "I_MVTDES" => "Descrption",
//     ]
// ];

// $result = $client->run('ZWSMTRKR', $params);

echo $result->getBody();