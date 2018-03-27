<?php

declare(strict_types=1);

namespace App\Handler;

use App\Db\Dal\GetTotals as GetTotalsDal;
use DateTime;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;

class TodaysTotalsHandler implements RequestHandlerInterface
{
    private $totalsDal;
    private $template;

    public function __construct(
        GetTotalsDal $totalsDal,
        Template\TemplateRendererInterface $template
    ) {
        $this->totalsDal = $totalsDal;
        $this->template  = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // To / From date. Could put this into the form
        $fromDate = (new DateTime())->setTime(0, 0, 0);
        $toDate   = (new DateTime())->setTime(23, 59, 59);
        
        $totalPremium = $this->totalsDal->getTotal($fromDate, $toDate);
        $quotes       = $this->totalsDal->getQuoteList($fromDate, $toDate);

        return new HtmlResponse($this->template->render('app::todays-totals', [
            'totalPremium' => $totalPremium,
            'quotes'       => $quotes,
        ]));
    }
}
