<?php

namespace App\Controller;

use App\Utils;
use App\Entity\AbucoinsApi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/slideshow")
 */
class SlideController extends Controller
{

	/**
     * @Route("/", name="slideshow")
     */
    public function SlideshowAction() 
    {

        $configAbucoins = [
            'secret' => 'Zy5gaXJLb3s/aDx+YXw1UDtPOlVjRnMlMUh3TkUjWGxaMCRKcFd4M2JZKCw9ZF40',
            'access_key' => '10531160-W62SI4MQHEBP13J0L8CNTDZG9UV7KYXR',
            'passphrase' => 'y0k2vqbh'
        ];

        $abucoinsApi = new AbucoinsApi($configAbucoins);

        $activeAccounts = $this->get('slideshow')->getMyCurrencies();
        $list = $this->get('slideshow')->getPreparedData($activeAccounts);

        $cryptoCurrencies = [];
        
        foreach ($list as $currency) {
            if(isset($currency->trade_id) == TRUE){
                $cryptoCurrencies[] = $currency;
            }
        }
        
        // echo '<pre>';
        // var_dump($list);
        // echo '</pre>';
        // die;

        return $this->render('slideshow/index.html.twig', [
            'cryptoCurrencies' => $cryptoCurrencies,
        ]);
    }

}