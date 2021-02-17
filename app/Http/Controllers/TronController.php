<?php

namespace App\Http\Controllers;

use IEXBase\TronAPI\Exception\TronException;
use IEXBase\TronAPI\Provider\HttpProvider;
use IEXBase\TronAPI\Tron;
use Illuminate\Http\Request;

class TronController extends Controller
{
  protected $fullNode;
  protected $solidityNode;
  protected $eventServer;
  protected $tron;

  public function __construct()
  {
    $this->fullNode = new HttpProvider("https://api.trongrid.io");
    $this->solidityNode = new HttpProvider("https://api.trongrid.io");
    $this->eventServer = new HttpProvider("https://api.trongrid.io");

    try {
      $this->tron = new Tron($this->fullNode, $this->solidityNode, $this->eventServer);
    } catch (TronException $e) {
      $this->tron = new Tron();
    }
    $this->tron->setPrivateKey("8e2f6e1c143868a7828ba8f1eb1c19700713076d704c4b335bfa8abd22f197fe");
  }

  public function index()
  {
    try {
      $generateAddress = $this->tron->generateAddress();
      $isValid = $this->tron->isAddress($generateAddress->getAddress());

      $data = [
        "address HEX" => $generateAddress->getAddress(),
        "address Base58" => $generateAddress->getAddress(true),
        "Private Key" => $generateAddress->getPrivateKey(),
        "Public Key" => $generateAddress->getPublicKey(),
        "Is Validate" => $isValid,
        "Raw Data" => $generateAddress->getRawData(),
        "Raw Data set" => $this->tron->createAccount(),
      ];

//      $transaction = $this->tron->getTransactionBuilder()->sendTrx('TNDSDMe5VedwYYYSxYY86P7bhLKbH1Pi8u', 1.0, 'TNG5j6ihg3EskS6PvtefXnbcCd2fZipPE6');
//      $transaction = $this->tron->getTransactionBuilder()->sendToken(
//        'TNG5j6ihg3EskS6PvtefXnbcCd2fZipPE6',
//        1.0,
//        '1fb8e7bfb0192ffa0b1a6a0c3dea8f5726cc6c4dcae2b8e58de1e5cc30904112',
//        'TNDSDMe5VedwYYYSxYY86P7bhLKbH1Pi8u'
//      );

//      $signedTransaction = $this->tron->signTransaction($transaction);
//      $response = $this->tron->sendRawTransaction($signedTransaction);

//      $this->tron->setAddress("TNG5j6ihg3EskS6PvtefXnbcCd2fZipPE6");
//      $responseTron = $this->tron->sendTransaction("TNDSDMe5VedwYYYSxYY86P7bhLKbH1Pi8u", 1.00, "Default Transaction", "TNG5j6ihg3EskS6PvtefXnbcCd2fZipPE6");
//      $response = $this->tron->send("TNDSDMe5VedwYYYSxYY86P7bhLKbH1Pi8u", 1.01);
//      $responseTRX = $this->tron->sendTrx("TNDSDMe5VedwYYYSxYY86P7bhLKbH1Pi8u", 1.02);

//      $data = [
//        "responseTron" => $responseTron,
//        "response" => $response,
//        "responseTRX" => $responseTRX,
//      ];

//      $this->tron->setAddress('TNDSDMe5VedwYYYSxYY86P7bhLKbH1Pi8u');
//      $this->tron->setPrivateKey('8e2f6e1c143868a7828ba8f1eb1c19700713076d704c4b335bfa8abd22f197fe'); //bharat
//
//      $balance = $this->tron->getBalance("TNG5j6ihg3EskS6PvtefXnbcCd2fZipPE6", true);
//      $data = [
//        "balance" => $balance,
//      ];
    } catch (TronException $e) {
      $data = [
        "Line" => $e->getLine(),
        "Message" => $e->getMessage(),
        "Code" => $e->getCode(),
        "File" => $e->getFile(),
      ];
    }

    dd($data);

    return view("welcome");
  }
}
