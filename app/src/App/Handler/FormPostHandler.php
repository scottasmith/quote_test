<?php

declare(strict_types=1);

namespace App\Handler;

use App\Handler\PersistQuote;
use App\Entities;
use App\Logic\Quote\QuoteInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Flash\FlashMessageMiddleware;

/**
 * NOTE: I would normally split this class so it has less dependencies
 */
class FormPostHandler implements RequestHandlerInterface
{
    private $persistQuote;
    private $router;
    private $quote;

    public function __construct(
        PersistQuote $persistQuote,
        RouterInterface $router,
        QuoteInterface $quote
    ) {
        $this->persistQuote = $persistQuote;
        $this->router       = $router;
        $this->quote        = $quote;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);

        $data = $request->getParsedBody();

        $entry = Entities\CustomerFormEntry::create($data);

        $quoteResponse = $this->quote->createQuote($entry);

        $this->persistQuote->persist($entry, $quoteResponse);

        $flashMessages->flash('premium', $quoteResponse->getPremium());
        $flashMessages->flash('additionalPremium', $quoteResponse->getAdditionalPremium());

        return new RedirectResponse($this->router->generateUri('form.post.complete'));
    }
}
