<?php
/**
 * Created by PhpStorm.
 * User: Micha³
 * Date: 9/21/2017
 * Time: 01:05 PM
 */

namespace App\Utils;

use App\Entity\AbucoinsApi;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class SlideshowService
{

    public function __construct(){

    	$configAbucoins = [
            'secret' => 'Zy5gaXJLb3s/aDx+YXw1UDtPOlVjRnMlMUh3TkUjWGxaMCRKcFd4M2JZKCw9ZF40',
            'access_key' => '10531160-W62SI4MQHEBP13J0L8CNTDZG9UV7KYXR',
            'passphrase' => 'y0k2vqbh'
        ];

        $this->abucoinsApi = new AbucoinsApi($configAbucoins);

    }

    public function getMyCurrencies(){

    	$accounts = $this->abucoinsApi->jsonRequest('GET', '/accounts', null);

        $activeAccounts = [];
        foreach ($accounts as $account) {
            if($account->balance > 0){
                $activeAccounts[] = $account;
            }
        }

        return $activeAccounts;
    	
    }

    public function getPair($currency1, $currency2){

    	$pair = $this->abucoinsApi->jsonRequest('GET', '/products/' . $currency1 . '-' . $currency2 . '/ticker', null);

    	if(isset($pair->message)){
            if($pair->message == 'NotFound'){
            	return FALSE;
            }
        } else {
        	$pair->cpair = $currency2;
        }

        return $pair;
    }

    public function getStats($currency1, $currency2){

    	$stats = $this->abucoinsApi->jsonRequest('GET', '/products/' . $currency1 . '-' . $currency2 . '/stats', null);

        return $stats;
    }


    public function getPreparedData($activeAccounts){

    	$list = [];
        foreach ($activeAccounts as $activeAccount) {

            $ticker = $this->getPair($activeAccount->currency, "PLN");
            if($ticker == FALSE){
                
                    $ticker = $this->getPair($activeAccount->currency, "BTC");
                    if($ticker == FALSE){

                            $ticker = $this->getPair($activeAccount->currency, "USD");
                            if($ticker == FALSE){
                                continue;
                            }
                    }
            }
            $ticker->code = $activeAccount->currency;
            $ticker->balance = $activeAccount->balance;
            $ticker->balance_btc = $activeAccount->balance_btc;
            $stats = $this->getStats($ticker->code, $ticker->cpair);
            $ticker->low = $stats->low;
            $ticker->high = $stats->high;

            $list[] = $ticker;
        }
        return $list;
    }


        // /products/<product-id>/candles?granularity=[granularity]&start=[UTC time of start]&end=[UTC time of end]

    public function getHistory($pair, $start, $end, $granularity){

    	$get = '/products/'. $pair .'/candles?granularity='. $granularity .'&start='. $start .'&end=' . $end;

    	$history = $this->abucoinsApi->jsonRequest('GET', $get, null);

        return $history;

    }



}