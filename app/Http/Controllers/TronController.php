<?php

namespace App\Http\Controllers;

use IEXBase\TronAPI\Exception\TronException;
use IEXBase\TronAPI\Laravel\Facades\TronAPI;
use IEXBase\TronAPI\Provider\HttpProvider;
use IEXBase\TronAPI\Tron;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\This;

class TronController extends Controller
{
  static protected $fullNode;
  static protected $solidityNode;
  static protected $eventServer;
  static protected $tron;

  public function __construct()
  {
    self::$fullNode = new HttpProvider("https://api.trongrid.io");
    self::$solidityNode = new HttpProvider("https://api.trongrid.io");
    self::$eventServer = new HttpProvider("https://api.trongrid.io");

    try {
      self::$tron = new Tron(self::$fullNode, self::$solidityNode, self::$eventServer);
    } catch (TronException $e) {
      self::$tron = new Tron();
    }
  }

  /**
   * @return Collection
   */
  public static function createAccount(): Collection
  {
    self::$tron->setPrivateKey("8e2f6e1c143868a7828ba8f1eb1c19700713076d704c4b335bfa8abd22f197fe");
    try {
      $data = [
        "code" => 200,
        "data" => self::$tron->createAccount()
      ];
    } catch (TronException $e) {
      $data = [
        "code" => 500,
        "data" => $e->getMessage()
      ];
    }

    return collect($data);
  }

  /**
   * @param $private_key
   * @param $address
   * @return Collection
   */
  public static function validateAddress($private_key, $address): Collection
  {
    self::$tron->setPrivateKey($private_key);
    $data = [
      "code" => 200,
      "data" => self::$tron->isAddress($address)
    ];

    return collect($data);
  }

  /**
   * @param $private_key
   * @return Collection
   */
  public static function getData($private_key): Collection
  {
    try {
      self::$tron->setPrivateKey($private_key);
      $address = self::$tron->generateAddress();
      $data = [
        "code" => 200,
        "data" => [
          "wallet" => $address->getAddress(true),
          "wallet_hax" => $address->getAddress(),
          "private_key" => $address->getPrivateKey(),
          "public_key" => $address->getPublicKey(),
          "raw_data" => $address->getRawData(),
        ]
      ];
    } catch (TronException $e) {
      $data = [
        "code" => 500,
        "data" => $e->getMessage()
      ];
    }

    return collect($data);
  }

  public static function balance($private_key, $address, $isTron = true)
  {
    try {
      self::$tron->setPrivateKey($private_key);
      $balance = self::$tron->getBalance($address);
      $data = [
        "code" => 200,
        "data" => $balance
      ];
    } catch (TronException $e) {
      $data = [
        "code" => 500,
        "data" => $e->getMessage()
      ];
    }

    return collect($data);
  }

  public static function tokenBalance($private_key, $address, $isTron = true)
  {
    try {
      self::$tron->setPrivateKey($private_key);
      $balance = self::$tron->getTokenBalance(1, $address);
      $data = [
        "code" => 200,
        "data" => $balance
      ];
    } catch (TronException $e) {
      $data = [
        "code" => 500,
        "data" => $e->getMessage()
      ];
    }

    return collect($data);
  }

  public function index()
  {
    try {
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

//      self::$tron->setAddress('TNDSDMe5VedwYYYSxYY86P7bhLKbH1Pi8u');
//      self::$tron->setPrivateKey('c39e5ae17d4557e1370f2bad33b115ae6edbb096f3be66af8ded353186ecae82'); //bharat

//      $balance = self::$tron->getBalance("TX4GyyrZ7aYEAUxw6C8U3ae59e6L9LQiSo", true);
//      dump(self::$tron->getTokenByID("TNG5j6ihg3EskS6PvtefXnbcCd2fZipPE6"));
//      dump(self::$tron->getTokensIssuedByAddress("TNDSDMe5VedwYYYSxYY86P7bhLKbH1Pi8u"));
//      $data = [
//        "balance" => $balance,
//        "token" => self::$tron->getBalance("TX4GyyrZ7aYEAUxw6C8U3ae59e6L9LQiSo"),
//        "balance token" => self::$tron->getTokenBalance("TNG5j6ihg3EskS6PvtefXnbcCd2fZipPE6", "TX4GyyrZ7aYEAUxw6C8U3ae59e6L9LQiSo")
//      ];
    } catch (TronException $e) {
//      $data = [
//        "Line" => $e->getLine(),
//        "Message" => $e->getMessage(),
//        "Code" => $e->getCode(),
//        "File" => $e->getFile(),
//      ];
    }

//    dd($data);
    dump(self::tokenBalance("c39e5ae17d4557e1370f2bad33b115ae6edbb096f3be66af8ded353186ecae82", "TX4GyyrZ7aYEAUxw6C8U3ae59e6L9LQiSo"));
    dd(self::balance("c39e5ae17d4557e1370f2bad33b115ae6edbb096f3be66af8ded353186ecae82", "TX4GyyrZ7aYEAUxw6C8U3ae59e6L9LQiSo"));

    return view("welcome");
  }
}
