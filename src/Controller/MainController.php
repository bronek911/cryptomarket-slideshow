<?php

namespace App\Controller;

use App\Utils;
use App\Entity\AbucoinsApi;
use App\Entity\LabCharts;
use App\Entity\LabChartsLine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use \DateTime;

/**
 * @Route("/api")
 */
class MainController extends Controller
{

    /**
     * @Route("/wallet", name="main")
     */
    public function mainAction() 
    {

        $activeAccounts = $this->get('slideshow')->getMyCurrencies();
        $list = $this->get('slideshow')->getPreparedData($activeAccounts);

        return new JsonResponse($list, 200);

    }

    /**
     * @Route("/history/{pair}/{minutes}/{granularity}", name="history")
     */
    public function historyAction($pair, $minutes, $granularity) 
    {

        $datetimeStart = new DateTime('-' . $minutes . 'minutes');
        $datetimeEnd = new DateTime('now');
        $start = $datetimeStart->format("Y-m-d\TH:i:s\Z");
        $end = $datetimeEnd->format("Y-m-d\TH:i:s\Z");

        $history = $this->get('slideshow')->getHistory($pair, $start, $end, $granularity);

        return new JsonResponse($history, 200);

    }

	/**
     * @Route("/chart", name="chart")
     */
    public function chartAction() 
    {

        return $this->render('test.html.twig');

    }

}